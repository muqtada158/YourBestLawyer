<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\CaseAttornies;
use App\Models\CaseDetail;
use App\Models\PaymentPlan;
use App\Models\User;
use Illuminate\Http\Request;

class AttorneyLeadsController extends Controller
{
      /**
     * Retrieves and filters attorney leads based on case criteria and attorney types.
     *
     * This function fetches all cases that are pending and have been accepted, excluding cases the attorney
     * has previously rejected. It filters cases by matching the case type and attorney type, and
     * returns a paginated list of cases available for the attorney to bid on.
     *
     * @return \Illuminate\View\View The view displaying a list of available attorney leads.
     */
    public function leads()
    {
        try {
            //get attorney
            $attorney = User::with('getAttorneyType')->where('id',auth()->user()->id)->first();

            //case ids to reject
            $caseIdsToReject = CaseAttornies::where('attorney_id', auth()->user()->id)
                ->pluck('case_id')
                ->toArray();

            $attorneyTypes = $attorney->getAttorneyType;
            // Retrieve all cases matching the initial criteria
                $casesQuery = CaseDetail::with('getCaseMedia', 'getCaseBid', 'getCaseLaw', 'getCasePackage', 'getUser.getUserDetails')
                ->where('application_status', 'Accepted')
                ->where('case_status', 'Pending')
                ->whereNotIn('id', $caseIdsToReject); // Exclude the cases with IDs in $caseIdsToReject

            // Add the complex where condition for matching case_type and lawyer_type pairs
            $casesQuery->where(function ($query) use ($attorneyTypes) {
                foreach ($attorneyTypes as $attorneyType) {
                    $query->orWhere(function ($subQuery) use ($attorneyType) {
                        $subQuery->where('case_type', $attorneyType->law_cat_id)
                                ->where('lawyer_type', $attorneyType->lawyer_id);
                    });
                }
            });

            // Order by ID and paginate
            $cases = $casesQuery->orderBy('id', 'DESC')->paginate(10);

            return view('attorney.leads',compact('cases'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }

    }

        /**
     * Displays the details of a specific customer case, including bid information and payment plans.
     *
     * This method retrieves detailed information for a specific case, including the attorney's bid, customer details,
     * and any payment plans in place. It also includes any dynamic form data associated with the case.
     *
     * @param  int  $case_id The ID of the case for which details are to be retrieved.
     * @return \Illuminate\View\View The view displaying the case and associated customer details.
     */
    public function leads_customer_details($case_id)
    {
        try {
            // Get customer contracts according to attorney types
            $case = CaseDetail::with('getCaseMedia','getCaseBid','getCaseLaw','getCasePackage','getUser.getUserDetails','getDynamicFormValues')
                ->where('id',$case_id)
                ->where('case_status', 'Pending')
                ->first();

            $attorney_bid = CaseAttornies::where('case_id',$case->id)
            ->where('attorney_id',auth()->user()->id)
            ->first();

            $paymentPlan = PaymentPlan::where('customer_id',$case->user_id)
            ->where('case_id',$case->id)
            ->where('status','Enabled')
            ->orderby('created_at','ASC')
            ->first();

            $installment_amount = 0;
            if($paymentPlan->installments == "yes")
            {
                $installment_amount = round(($case->getCaseBid->bid - $paymentPlan->getTransactionDownpayment->amount) / $paymentPlan->installment_cycle);
            }

            $dynamicForms = null;
            if($case->getDynamicFormValues)
            {
                $dynamicForms = json_decode($case->getDynamicFormValues->form_values);
            }

            return view('attorney.leads-customer-details',compact('case','attorney_bid','paymentPlan','installment_amount','dynamicForms'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    /**
     * Allows the attorney to place a bid on a case they are interested in.
     *
     * This method validates the bid amount and checks if it meets the case package requirements and
     * any applicable payment plan downpayment conditions. If the bid is valid, it is saved and
     * an email notification is sent to the customer. Updates the customer's steps if needed.
     *
     * @param  \Illuminate\Http\Request  $request The request containing the case ID and bid amount.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
     */
    public function leads_interested(Request $request)
    {
        $this->validate($request, [
            'case_id' => 'required|exists:case_details,id',
            'bid' => 'required',
        ]);

        try {
            $case = CaseDetail::where('id',$request->case_id)->first();

            if($request->bid < $case->getCasePackage->min_amount)
            {
                $alert = [
                    'message' => 'Your bid amount is too low, Kindly increase bid amount.',
                    'alert-type' => 'error'
                ];
                return back()->with($alert);
            }
            if($request->bid > $case->getCasePackage->max_amount)
            {
                $alert = [
                    'message' => 'Your bid amount is too high, Kindly decrease bid amount.',
                    'alert-type' => 'error'
                ];
                return back()->with($alert);
            }

            $paymentPlan = PaymentPlan::where('case_id',$request->case_id)
            ->where('status','Enabled')
            ->where('payment_status','Unpaid')
            ->first();

            if($request->bid < $paymentPlan->getTransactionDownpayment->amount)
            {
                $alert = [
                    'message' => 'Your bid amount is too low, Kindly increase it to $'.$paymentPlan->getTransactionDownpayment->amount,
                    'alert-type' => 'error'
                ];
                return back()->with($alert);
            }

            $caseInterestedAttornies = new CaseAttornies();
            $caseInterestedAttornies->case_id = $request->case_id;
            $caseInterestedAttornies->attorney_id = auth()->user()->id;
            $caseInterestedAttornies->attorney_bid = $request->bid;
            $caseInterestedAttornies->status = 'Interested';
            $caseInterestedAttornies->save();

            // Update restricted_steps if necessary
            if ($caseInterestedAttornies) {
                $caseDetail = CaseDetail::find($caseInterestedAttornies->case_id);
                $customer = $caseDetail->getUser()->first();

                if ($customer && $customer->restricted_steps == 13) {
                    $customer->restricted_steps = 14;
                    $customer->save();
                }
            }

            //sending email to attorney
            $this->sendEmail(
                $case->getUser->email,
                'You got a bid on your application.',
                ''.ucfirst(auth()->user()->getUserDetails->first_name). ' has submitted a bid on your application Sr No # '.$case->sr_no.' Please review the details.'
            );

            $alert = [
                'message' => "Bid placed successfully",
                'alert-type' => 'success'
            ];
            return back()->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

       /**
     * Marks a case as not of interest to the attorney.
     *
     * This method allows the attorney to decline a case by setting their bid amount to 0
     * and marking the status as "Not Interested." A success or error message is returned
     * depending on the outcome.
     *
     * @param  \Illuminate\Http\Request  $request The request containing the case ID.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
     */
    public function leads_not_interested(Request $request)
    {
        $this->validate($request, [
            'case_id' => 'required|exists:case_details,id',
        ]);

        try {
            $caseInterestedAttornies = new CaseAttornies();
            $caseInterestedAttornies->case_id = $request->case_id;
            $caseInterestedAttornies->attorney_id = auth()->user()->id;
            $caseInterestedAttornies->attorney_bid = 0;
            $caseInterestedAttornies->status = 'NotInterested';
            $caseInterestedAttornies->save();

            $alert = [
                'message' => "Application declined successfully",
                'alert-type' => 'success'
            ];
            return back()->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
