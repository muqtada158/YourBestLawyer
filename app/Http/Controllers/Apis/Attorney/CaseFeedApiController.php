<?php

namespace App\Http\Controllers\Apis\Attorney;

use App\Http\Controllers\Controller;
use App\Http\Traits\NotificationTrait;
use App\Models\CaseAttornies;
use App\Models\CaseDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaseFeedApiController extends Controller
{
    use NotificationTrait;

    /**
 * Get the list of cases for an attorney based on certain criteria.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function caseFeed(Request $request)
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

            //get attorney
            $attorney = User::with('getAttorneyType')->where('id',$request->attorney_id)->first();

            //case ids to reject
            $caseIdsToReject = CaseAttornies::where('attorney_id', $request->attorney_id)
                ->pluck('case_id')
                ->toArray();

            $attorneyTypes = $attorney->getAttorneyType;
            // Retrieve all cases matching the initial criteria
                $casesQuery = CaseDetail::with('getDynamicFormValues','getCaseMedia', 'getCaseBid', 'getCaseLaw', 'getCasePackage','getPaymentPlan.getTransactions', 'getUser.getUserDetails')
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
            $cases = $casesQuery->orderBy('id', 'DESC')->get();

            return response()->json([
                'status' => true,
                'message' => 'Fetched data successfully',
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
 * Get detailed information about a specific case.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function caseFeedDetails(Request $request)
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

            // Get customer contracts according to attorney types
            $cases = CaseDetail::with('getDynamicFormValues','getCaseMedia','getCaseBid','getCaseLaw','getCasePackage','getUser.getUserDetails')
                ->where('id',$request->case_id)
                ->where('case_status', 'Pending')
                ->first();

            return response()->json([
                'status' => true,
                'message' => 'Fetched data successfully',
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
 * Submit attorney's bid and interest in a case.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function caseAttornies(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required|exists:case_details,id',
                'attorney_id' => 'required|exists:users,id',
                'attorney_bid' => 'nullable',
                'status' => 'required|in:Interested,NotInterested',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if($request->status == "Interested")
            {
                $getPackage = CaseDetail::with('getCasePackage')->where('id',$request->case_id)->first();
                if($getPackage)
                {
                    if($request->attorney_bid < $getPackage->getCasePackage->min_amount)
                    {
                        return response()->json([
                            'status' => false,
                            'message' => 'validation error',
                            'errors' => 'Attorney bid is less than the amount of package.'
                        ], 401);
                    }
                    if($request->attorney_bid > $getPackage->getCasePackage->max_amount)
                    {
                        return response()->json([
                            'status' => false,
                            'message' => 'validation error',
                            'errors' => 'Attorney bid is greater than the amount of package.'
                        ], 401);
                    }
                }
            }

            $caseInterestedAttornies = new CaseAttornies();
            $caseInterestedAttornies->case_id = $request->case_id;
            $caseInterestedAttornies->attorney_id = $request->attorney_id;
            $caseInterestedAttornies->attorney_bid = $request->attorney_bid;
            $caseInterestedAttornies->status = $request->status;
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

            //triggering notifications
            // $notification = $this->sendNotification([$customer->id],'You got a bid on your application.',null,null);

            return response()->json([
                'status' => true,
                'message' => 'Submit data successfully',
                'caseInterestedAttornies' => $caseInterestedAttornies,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
