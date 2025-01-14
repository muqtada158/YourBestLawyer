<?php

namespace App\Http\Controllers\Apis\Customer;

use App\Http\Controllers\Controller;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardApisController extends Controller
{
    /**
 * View user profile
 *
 * @param \Illuminate\Http\Request $request The incoming request containing user_id
 * @return \Illuminate\Http\JsonResponse JSON response with the profile data or error message
 */
    public function viewProfile(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $profile = User::with('getUserDetails')->where('id', $request->user_id)->first();

            if(!$profile)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User profile not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Fetched profile successfully',
                'profile' => $profile,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Update user password
 *
 * @param \Illuminate\Http\Request $request The incoming request containing user credentials
 * @return \Illuminate\Http\JsonResponse JSON response with success or error message
 */
    public function updatePassword(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'current_password' => 'required',
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|string|same:new_password',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $user = User::findOrFail($request->user_id);

            if(!$user)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User user not found.',
                ], 422);
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect.',
                ], 422);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            $notification = $this->sendNotification([$request->user_id],'Password Updated Successfully.',null,null);
            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully.',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


/**
 * Get user applications with pending status
 *
 * @param \Illuminate\Http\Request $request The incoming request containing user_id
 * @return \Illuminate\Http\JsonResponse JSON response with list of pending applications or error message
 */
    public function getApplications(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $application = CaseDetail::with('getCaseMedia','getCaseBid')->where('user_id', $request->user_id)->where('case_status','Pending')->get();

            if(!$application)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Application not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Fetched applications successfully',
                'applications' => $application,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


/**
 * Get list of assigned attorneys for a customer
 *
 * @param \Illuminate\Http\Request $request The incoming request containing user_id
 * @return \Illuminate\Http\JsonResponse JSON response with list of assigned attorneys or error message
 */
    public function getAssignedAttornies(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $attornies = CustomerContract::with('getAttornies.getUserDetails')->where('customer_id',$request->user_id)->get();

            if(!$attornies)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Attornies not found.',
                ], 422);
            }

            $attornies = $attornies->pluck('getAttornies')->filter(); // to get only attornies

            return response()->json([
                'status' => true,
                'message' => 'Fetched attornies successfully',
                'attornies' => $attornies,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Get list of customer contracts
 *
 * @param \Illuminate\Http\Request $request The incoming request containing customer_id
 * @return \Illuminate\Http\JsonResponse JSON response with list of contracts or error message
 */
    public function getCustomerContractList(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'customer_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $contracts = CustomerContract::with('getAttornies.getUserDetails', 'getCustomer.getUserDetails',
            'caseAttorneyBid',
            'getCaseDetail.getCaseBid',
            'getCaseDetail.getCaseLaw',
            'getCaseDetail.getCaseLawSub',
            'getCaseDetail.getCasePackage',
            'getCaseDetail.getPaymentPlan.getTransactions')
            ->where('customer_id',$request->customer_id)
            ->get();

            if(!$contracts)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Contracts not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Fetched contracts successfully',
                'contracts' => $contracts,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Get customer contract details
 *
 * @param \Illuminate\Http\Request $request The incoming request containing contract_id
 * @return \Illuminate\Http\JsonResponse JSON response with contract details or error message
 */
    public function getCustomerContractDetails(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'contract_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $contracts = CustomerContract::with('getCustomer.getUserDetails','getAttornies.getUserDetails','getCaseDetail','getContract','getPaymentPlan.getTransactions')
            ->where('id',$request->contract_id)
            ->first();

            if(!$contracts)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Contract not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Fetched contract successfully',
                'contracts' => $contracts,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
