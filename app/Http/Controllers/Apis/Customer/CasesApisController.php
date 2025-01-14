<?php

namespace App\Http\Controllers\Apis\Customer;

use App\Http\Controllers\Controller;
use App\Models\CaseAttornies;
use App\Models\CaseBid;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use App\Models\CustomerFeedback;
use App\Models\PaymentPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CasesApisController extends Controller
{
    /**
 * Fetches all cases based on the user's filter (Accepted, Pending, Ended, etc.)
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function allCases(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'filter' => 'nullable'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(isset($request->filter) && $request->filter == "Accepted")
            {
                $cases = CaseDetail::with(
                    'getDynamicFormValues',
                    'getCaseMedia',
                    'getCaseBid',
                    'getCaseLaw',
                    'getCaseLawSub',
                    'getCasePackage',
                    'getCustomerContractAccepted.getAttornies',
                    'getPaymentPlan.getTransactions'
                    )
                ->where('user_id', $request->user_id)
                ->where('case_status','Accepted')
                ->orderby('id','ASC')
                ->get();

                foreach($cases as $case)
                {
                    $getCustomerContract = CustomerContract::where('case_id',$case->id)->first();
                    $getCaseAttorney = CaseAttornies::where('case_id',$case->id)->where('attorney_id',$getCustomerContract->attorney_id)->first();
                    $case->get_attorney_bid = $getCaseAttorney;
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Fetched accepted cases successfully',
                    'cases' => $cases,
                ], 200);
            }

            if(isset($request->filter) && $request->filter == "Pending")
            {
                $cases = CaseDetail::with(
                    'getDynamicFormValues',
                    'getCaseMedia',
                    'getCaseBid',
                    'getCaseLaw',
                    'getCaseLawSub',
                    'getCasePackage',
                    'getCustomerContractAccepted.getAttornies',
                    'getPaymentPlan.getTransactions'
                )->where('user_id', $request->user_id)->where('case_status','Pending')->orderby('id','ASC')->get();
                return response()->json([
                    'status' => true,
                    'message' => 'Fetched pending cases successfully',
                    'cases' => $cases,
                ], 200);
            }

            if(isset($request->filter) && $request->filter == "Ended")
            {
                $cases = CaseDetail::with(
                    'getDynamicFormValues',
                    'getCaseMedia',
                    'getCaseBid',
                    'getCaseLaw',
                    'getCaseLawSub',
                    'getCasePackage',
                    'getCustomerContractAccepted.getAttornies',
                    'getPaymentPlan.getTransactions'
                )->where('user_id', $request->user_id)->where('case_status','Ended')->orderby('id','ASC')->get();
                return response()->json([
                    'status' => true,
                    'message' => 'Fetched rejected cases successfully',
                    'cases' => $cases,
                ], 200);
            }

            $cases = CaseDetail::with(
                'getDynamicFormValues',
                'getCaseMedia',
                'getCaseBid',
                'getCaseLaw',
                'getCaseLawSub',
                'getCasePackage',
                'getCustomerContractAccepted.getAttornies',
                'getPaymentPlan.getTransactions'
            )->where('user_id', $request->user_id)->where('case_status','!=',null)->get();

            if(!$cases)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'cases not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Fetched cases successfully',
                'cases' => $cases,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Fetches a single case details by case ID.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function viewCase(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $case = CaseDetail::with('getCaseMedia','getUser.getUserDetails','getCaseLaw','getCaseBid','getAcceptedCustomerContracts','getPaymentPlan.getTransactions')
            ->findOrFail($request->case_id);
            if($case->getAcceptedCustomerContracts)
            {
                $getAttorneyBid = CaseAttornies::where('case_id',$case->id)->where('attorney_id',$case->getAcceptedCustomerContracts->attorney_id)->first();
                $case->getAttorneyBid = $getAttorneyBid;
            }
            return response()->json([
                'status' => true,
                'message' => 'Case fetched successfully',
                'case'=>$case
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Submits customer feedback for a case.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function customerFeedback(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required',
                'customer_id' => 'required',
                'attorney_id' => 'required',
                'rating' => 'required|integer',
                'review' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $case = CaseDetail::where('id',$request->case_id)->first();

            if(!$case)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Case not found.',
                ], 422);
            }

            $feedback = new CustomerFeedback();
            $feedback->case_id = $request->case_id;
            $feedback->customer_id = $request->customer_id;
            $feedback->attorney_id = $request->attorney_id;
            $feedback->rating = $request->rating;
            $feedback->review = $request->review;
            $feedback->save();

            return response()->json([
                'status' => true,
                'message' => 'Your feedback submitted successfully.',
                'customer_feedback'=>$feedback,
                'case'=>$case
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Fetch customer feedback for a specific case and customer.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function customerGetFeedback(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required',
                'customer_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $customerFeedback = CustomerFeedback::where('case_id',$request->case_id)->where('customer_id',$request->customer_id)->first();

            if(!$customerFeedback)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Customer feedback not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Fetched customer feedback successfully.',
                'customer_feedback'=>$customerFeedback,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Fetch the average rating for an attorney.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function attorneyRatings(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $attorney = User::with('getUserDetails')->where('id',$request->attorney_id)->first();
            $ratings = CustomerFeedback::where('attorney_id',$request->attorney_id)->get()->pluck('rating')->toArray();

            if(!$ratings)
            {
                $ratings = [0];
            }

            $averageRating = number_format(array_sum($ratings) / count($ratings), 2);
            return response()->json([
                'status' => true,
                'message' => 'Attorney and rating fetched successfully.',
                'ratings'=>$averageRating,
                'attorney'=>$attorney
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Reject a customer contract and update associated payment plan.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function rejectContractCustomer(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'contract_id' => 'required',
                'customer_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            DB::beginTransaction();

            $contract = CustomerContract::where('id',$request->contract_id)
            ->where('customer_id',$request->customer_id)->first();
            $contract->status = 'Rejected';
            $contract->save();

            //reverting attorney bid and update payment plan according to that starts
            $customer_bid = CaseBid::where('case_id',$contract->case_id)
            ->where('user_id',$contract->customer_id)
            ->first();
                //updating payment plan
                $paymentPlan = PaymentPlan::where('customer_id',$contract->customer_id)
                ->where('case_id',$contract->case_id)
                ->first();
                $paymentPlan->status = 'Disabled';
                $paymentPlan->save();
                //creating another payment plan
                $newPaymentPlan = new PaymentPlan();
                $newPaymentPlan->customer_id = $paymentPlan->customer_id;
                $newPaymentPlan->attorney_id = null;
                $newPaymentPlan->case_id = $paymentPlan->case_id;
                $newPaymentPlan->sub_cat_id  = $paymentPlan->sub_cat_id;
                $newPaymentPlan->package_id  = $paymentPlan->package_id;
                $newPaymentPlan->invoice_no  = null;
                $newPaymentPlan->installments  = $paymentPlan->installments;
                $newPaymentPlan->total_amount  = $paymentPlan->total_amount;
                $newPaymentPlan->installment_cycle  = $paymentPlan->installment_cycle;
                $newPaymentPlan->status = 'Enabled';
                $newPaymentPlan->payment_status = 'UnPaid';
                $newPaymentPlan->save();
            //reverting attorney bid and update payment plan according to that ends

            $case_details = CaseDetail::where('id',$contract->case_id)->update(['case_status'=>'Pending']);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Contract rejected successfully.',
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
