<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AttorneyReviews;
use App\Models\CaseAttornies;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use App\Models\CustomerFeedback;
use App\Models\PaymentPlan;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerCasesController extends Controller
{
    /**
     * Display a list of cases for the customer, filtered by status.
     *
     * This method retrieves cases for the logged-in customer based on their case status (Accepted, Pending, Ended, or All).
     * It returns a paginated list of cases, or case counts if no status is provided.
     *
     * @param string|null $status The status of the cases to filter by (Accepted, Pending, Ended, or All)
     * @return \Illuminate\View\View
     */
    public function cases($status = null)
    {
        try{
            $user_id = auth()->user()->id;
            if(isset($status) && $status == "Accepted")
            {
                $cases = CaseDetail::with('getCaseMedia','getCaseLaw','getCasePackage')
                ->where('user_id', $user_id)
                ->where('case_status','Accepted')
                ->orderby('id','DESC')
                ->paginate(10);

                return view('customer.cases-all',compact('cases'));
            }

            if(isset($status) && $status == "Pending")
            {
                $cases = CaseDetail::with('getCaseMedia','getCaseLaw','getCasePackage')
                ->where('user_id', $user_id)
                ->where('case_status','Pending')
                ->orderby('id','DESC')
                ->paginate(10);

                return view('customer.cases-all',compact('cases'));
            }

            if(isset($status) && $status == "Ended")
            {
                $cases = CaseDetail::with('getCaseMedia','getCaseLaw','getCasePackage')
                ->where('user_id', $user_id)
                ->where('case_status','Ended')
                ->orderby('id','DESC')
                ->paginate(10);

                return view('customer.cases-all',compact('cases'));
            }

            if(isset($status) && $status == "All")
            {
                $cases = CaseDetail::with('getCaseMedia','getCaseLaw','getCasePackage')
                ->where('user_id', $user_id)
                ->where('case_status','!=',null)
                ->orderby('id','DESC')
                ->paginate(10);

                return view('customer.cases-all',compact('cases'));
            }

            $totalCases = CaseDetail::where('user_id',$user_id)->where('case_status','!=',null)->count();
            $acceptedCases = CaseDetail::where('user_id',$user_id)->where('case_status','Accepted')->count();
            $endedCases = CaseDetail::where('user_id',$user_id)->where('case_status','Ended')->count();
            $pendingCases = CaseDetail::where('user_id',$user_id)->where('case_status','Pending')->count();

            return view('customer.cases',compact('totalCases','acceptedCases','pendingCases','endedCases'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
       /**
     * Display the details of a specific case for the customer.
     *
     * This method retrieves detailed information for a specific case, including
     * media, dynamic form values, bid information, and related customer contracts.
     * It also fetches the interested attorneys and payment plans if available.
     *
     * @param int $case_id The ID of the case to retrieve details for
     * @return \Illuminate\View\View
     */
    public function case_details($case_id)
    {
        try {

            $case = CaseDetail::with('getCaseMedia','getDynamicFormValues','getUser.getUserDetails','getCaseLaw','getCaseBid','getAcceptedCustomerContracts')->findOrFail($case_id);
            $interested_attornies = CaseAttornies::where('case_id',$case->id)->where('status','Interested')->get();

            $customer_contract = CustomerContract::where('case_id',$case->id)
            ->where('customer_id',$case->getUser->id)
            ->where('status','!=',"Rejected")
            ->first();

            $paymentPlan = PaymentPlan::where('customer_id',$case->user_id)
            ->where('case_id',$case->id)
            ->where('status','Enabled')
            ->first();

            $dynamicForms = null;
            if($case->getDynamicFormValues)
            {
                $dynamicForms = json_decode($case->getDynamicFormValues->form_values);
            }

            return view('customer.case-details',compact('case','interested_attornies','customer_contract','paymentPlan','dynamicForms'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    public function customer_case_reject($id)
    {
        try {
            $update_attorney = CaseAttornies::where('id',$id)->update(['status'=>'NotInterested']);

            //sending email
            $this->sendEmail(
                $update_attorney->getAttornies->email,
                'Bid Rejected',
                'Your bid on Case Sr No # '.$update_attorney->getCaseDetails->sr_no.' has been rejected.'
            );

            $alert = [
                'message' => 'Bid Reject Successfully...',
                'alert-type' => 'success'
            ];
            return back()->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    public function attorney_review($id)
    {
        $contract = CustomerContract::where('id',$id)->first();

        $check_review = CustomerFeedback::where('case_id',$contract->case_id)
        ->where('customer_id',$contract->customer_id)
        ->where('attorney_id',$contract->attorney_id)
        ->first();

        $ratings = CustomerFeedback::where('attorney_id',$contract->getAttornies->id)->get()->pluck('rating')->toArray();
        if(!$ratings)
        {
            $ratings = [0];
        }

        $averageRating = number_format(array_sum($ratings) / count($ratings), 1);
        $attorneyReviews = AttorneyReviews::where('attorney_id',$contract->attorney_id)->first();

        return view('customer.end-case',compact('contract','averageRating','check_review','attorneyReviews'));
    }
    public function customerReview(Request $request)
    {
        //Validation
        $this->validate($request,
        [
            'case_id' => 'required',
            'attorney_id' => 'required',
            'rating' => 'required|integer',
            'review' => 'required',
        ]);
        try {

            $case = CaseDetail::where('id',$request->case_id)->first();

            $feedback = new CustomerFeedback();
            $feedback->case_id = $request->case_id;
            $feedback->customer_id = auth()->user()->id;
            $feedback->attorney_id = $request->attorney_id;
            $feedback->rating = $request->rating;
            $feedback->review = $request->review;
            $feedback->save();


            $alert = [
                'message' => 'Your review has been submitted successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_case_details',[$case->id])->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert)->withInput();
        }
    }
}
