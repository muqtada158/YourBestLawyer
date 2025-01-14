<?php

namespace App\Http\Controllers\Apis\Attorney;

use App\Http\Controllers\Controller;
use App\Models\CaseAttornies;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttorneyCasesApisController extends Controller
{

/**
 * Get the count of cases for a specific attorney.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function getCasesCounts(Request $request)
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

            $casesTotal = CustomerContract::where('attorney_id',$request->attorney_id)
            ->get()
            ->count();

            $casesOngoing = CustomerContract::where('attorney_id',$request->attorney_id)
            ->where('status','Accepted')
            ->get()
            ->count();

            $casesPending = CustomerContract::where('attorney_id',$request->attorney_id)
            ->where('status','Pending')
            ->get()
            ->count();

            $casesEnded = CustomerContract::where('attorney_id',$request->attorney_id)
            ->where('status','Ended')
            ->get()
            ->count();

            return response()->json([
                'status' => true,
                'message' => 'Fetched cases counts successfully',
                'casesTotal' => $casesTotal,
                'casesOngoing' => $casesOngoing,
                'casesPending' => $casesPending,
                'casesEnded' => $casesEnded,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
/**
 * List cases for an attorney based on filter (total, ongoing, pending, or ended).
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function listCases(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
                'filter' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            switch ($request->filter) {
                case 'total':
                    $cases = CustomerContract::with(
                        'getAttornies.getUserDetails',
                        'getCustomer.getUserDetails',
                        'getCaseDetail.getDynamicFormValues',
                        'getCaseDetail.getCaseMedia',
                        'getCaseDetail.getCaseBid',
                        'getCaseDetail.getCaseLaw',
                        'getCaseDetail.getCaseLawSub',
                        'getCaseDetail.getCasePackage',
                        'getCaseDetail.getPaymentPlan.getTransactions',
                        'getContract'
                    )
                    ->where('attorney_id',$request->attorney_id)
                    ->orderby('id','DESC')
                    ->get();
                    break;
                case 'ongoing':
                    $cases = CustomerContract::with(
                        'getAttornies.getUserDetails',
                        'getCustomer.getUserDetails',
                        'getCaseDetail.getDynamicFormValues',
                        'getCaseDetail.getCaseMedia',
                        'getCaseDetail.getCaseBid',
                        'getCaseDetail.getCaseLaw',
                        'getCaseDetail.getCaseLawSub',
                        'getCaseDetail.getCasePackage',
                        'getCaseDetail.getPaymentPlan.getTransactions',
                        'getContract'
                    )
                    ->where('attorney_id',$request->attorney_id)
                    ->where('status','Accepted')
                    ->orderby('id','DESC')
                    ->get();
                    break;
                case 'pending':
                    $cases = CustomerContract::with(
                        'getAttornies.getUserDetails',
                        'getCustomer.getUserDetails',
                        'getCaseDetail.getDynamicFormValues',
                        'getCaseDetail.getCaseMedia',
                        'getCaseDetail.getCaseBid',
                        'getCaseDetail.getCaseLaw',
                        'getCaseDetail.getCaseLawSub',
                        'getCaseDetail.getCasePackage',
                        'getCaseDetail.getPaymentPlan.getTransactions',
                        'getContract'
                    )
                    ->where('attorney_id',$request->attorney_id)
                    ->where('status','Pending')
                    ->orderby('id','DESC')
                    ->get();
                    break;
                case 'ended':
                    $cases = CustomerContract::with(
                        'getAttornies.getUserDetails',
                        'getCustomer.getUserDetails',
                        'getCaseDetail.getDynamicFormValues',
                        'getCaseDetail.getCaseMedia',
                        'getCaseDetail.getCaseBid',
                        'getCaseDetail.getCaseLaw',
                        'getCaseDetail.getCaseLawSub',
                        'getCaseDetail.getCasePackage',
                        'getCaseDetail.getPaymentPlan.getTransactions',
                        'getContract'
                    )
                    ->where('attorney_id',$request->attorney_id)
                    ->where('status','Ended')
                    ->orderby('id','DESC')
                    ->get();
                    break;
                default:
                    return response()->json([
                        'status' => false,
                        'message' => 'Error ! Invalid filter used...'
                    ], 500);
                    break;
            }

            return response()->json([
                'status' => true,
                'message' => 'Fetched cases list successfully',
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
 * Get details of a specific case for an attorney based on case_id and filter.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function detailCases(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required',
                'attorney_id' => 'required',
                'filter' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }


            switch ($request->filter) {
                case 'pending':

                    $cases = $cases = CustomerContract::with(
                        'getAttornies.getUserDetails',
                        'getCustomer.getUserDetails',
                        'getCaseDetail.getCaseMedia',
                        'getCaseDetail.getCaseBid',
                        'getCaseDetail.getCaseLaw',
                        'getCaseDetail.getCaseLawSub',
                        'getCaseDetail.getCasePackage',
                        'getCaseDetail.getPaymentPlan.getTransactions',
                        'getContract'
                    )
                    ->where('attorney_id',$request->attorney_id)
                    ->where('case_id',$request->case_id)
                    ->where('status','Pending')
                    ->first();

                    break;
                case 'ongoing':

                    $cases = CustomerContract::with(
                        'getAttornies.getUserDetails',
                        'getCustomer.getUserDetails',
                        'getCaseDetail.getCaseMedia',
                        'getCaseDetail.getCaseBid',
                        'getCaseDetail.getCaseLaw',
                        'getCaseDetail.getCaseLawSub',
                        'getCaseDetail.getCasePackage',
                        'getCaseDetail.getPaymentPlan.getTransactions',
                        'getContract'
                    )
                    ->where('attorney_id',$request->attorney_id)
                    ->where('case_id',$request->case_id)
                    ->where('status','Accepted')
                    ->first();

                    $getAttorneyBid = CaseAttornies::where('case_id',$request->case_id)
                    ->where('attorney_id',$request->attorney_id)
                    ->first();
                    $cases->getAttorneyBid = $getAttorneyBid;

                    break;
                case 'ended':

                    $cases = CustomerContract::with(
                        'getAttornies.getUserDetails',
                        'getCustomer.getUserDetails',
                        'getCaseDetail.getCaseMedia',
                        'getCaseDetail.getCaseBid',
                        'getCaseDetail.getCaseLaw',
                        'getCaseDetail.getCaseLawSub',
                        'getCaseDetail.getCasePackage',
                        'getCaseDetail.getPaymentPlan.getTransactions',
                        'getContract'
                    )
                    ->where('attorney_id',$request->attorney_id)
                    ->where('case_id',$request->case_id)
                    ->where('status','Ended')
                    ->first();

                    break;

                default:

                    return response()->json([
                        'status' => false,
                        'message' => 'Error ! Invalid filter...'
                    ], 500);

                    break;
            }


            return response()->json([
                'status' => true,
                'message' => 'Fetched cases details successfully',
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
 * End a case for a specific attorney based on case_id and attorney_id.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function endCase(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required',
                'attorney_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $contract = CustomerContract::where('case_id',$request->case_id)
            ->where('attorney_id',$request->attorney_id)
            ->where('status','Accepted')
            ->first();

            if($contract)
            {
                $paymentPlan = PaymentPlan::where('case_id',$request->case_id)
                ->where('attorney_id',$request->attorney_id)
                ->first();
                if($paymentPlan->payment_status != 'Paid')
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Case payments are not paid / clear.'
                    ], 200);
                }
                $case = CaseDetail::findOrFail($contract->case_id);
                $case->case_status = 'Ended';
                $case->save();

                // $notification = $this->sendNotification([$contract->customer_id],"Your case has been ended.",null,null);
                return response()->json([
                    'status' => true,
                    'message' => 'Case ended successfully.'
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Case not found.'
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error :'.$th->getMessage(),
            ], 500);
        }
    }

}
