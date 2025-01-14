<?php

namespace App\Http\Controllers\Apis\Customer;

use App\Http\Controllers\Controller;
use App\Models\CaseAttornies;
use App\Models\CustomerContract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HiredAttorniesApisController extends Controller
{
    /**
 * Fetch all hired attorneys for a given customer
 *
 * @param \Illuminate\Http\Request $request The incoming request containing 'user_id' (customer's ID)
 * @return \Illuminate\Http\JsonResponse JSON response with the hired attorneys data or error message
 */
    public function allHiredAttornies(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $hiredAttornies = CustomerContract::with('getAttornies.getUserDetails','getCaseDetail.getCaseBid','getCaseDetail.getCaseLaw')
            ->where('customer_id',$request->user_id)
            ->where('status','Accepted')
            ->get();

            if(!$hiredAttornies)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Hired Attornies not found.',
                ], 422);
            }

            $hiredAttornies = $hiredAttornies->map(function ($contract) {
                if($contract->getAttornies)
                {
                    $attorney = $contract->getAttornies->toArray();
                }
                if($contract->getCaseDetail)
                {
                    $caseDetails = $contract->getCaseDetail->toArray();
                    $attorney['case_details'] = $caseDetails;
                    $getCaseAttorneyBid = CaseAttornies::where('case_id',$contract->getCaseDetail->id)->where('attorney_id',$contract->getAttornies->id)->first();
                    $attorney['case_details']['attorney_case_bid'] = $getCaseAttorneyBid;
                }
                return $attorney;
            });

            return response()->json([
                'status' => true,
                'message' => 'Hired Attornies fetched successfully',
                'hired_attornies'=>$hiredAttornies
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


/**
 * Fetch details of a specific hired attorney
 *
 * @param \Illuminate\Http\Request $request The incoming request containing 'attorney_id'
 * @return \Illuminate\Http\JsonResponse JSON response with the hired attorney details or error message
 */
    public function hiredAttorneyDetails(Request $request)
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

            $hiredAttorneyDetails = User::with('getUserDetails','getRatings')->where('user_type','attorney')
            ->where('id',$request->attorney_id)
            ->first();

            //case counts of attornies
            if ($hiredAttorneyDetails) {
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

                $caseCounts = [
                    'total_cases' => $casesTotal,
                    'ongoing_cases' => $casesOngoing,
                    'pending_cases' => $casesPending,
                    'ended_cases' => $casesEnded,
                ];

                $hiredAttorneyDetails->caseCounts = $caseCounts;
            }

            $ratings = $hiredAttorneyDetails->getRatings;
            $average_rating = $ratings->avg('rating');

            $hiredAttorneyDetails['average_ratings'] = $average_rating;

            if(!$hiredAttorneyDetails)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Hired Attorney Details not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Hired Attorney Details fetched successfully',
                'hired_attorney_details'=>$hiredAttorneyDetails
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
