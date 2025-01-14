<?php

namespace App\Http\Controllers\Apis\Customer;

use App\Http\Controllers\Controller;
use App\Http\Traits\NumberGeneratorTrait;
use App\Models\CaseBid;
use App\Models\CaseDetail;
use App\Models\CaseMedia;
use App\Models\LawSubCategory;
use App\Models\Lawyer;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApplicationApisController extends RestrictedAreaApisController
{
    use NumberGeneratorTrait;

    /**
 * Fetch all applications based on the provided filter and user ID.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing user ID and filter
 * @return \Illuminate\Http\JsonResponse The JSON response containing the applications
 */
    public function allApplications(Request $request)
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
                $applications = CaseDetail::with('getDynamicFormValues','getCaseMedia','getCaseLaw','getCasePackage','getCaseBid')
                ->where('user_id', $request->user_id)
                ->where('application_status','Accepted')
                ->orderby('id','DESC')
                ->get();

                return response()->json([
                    'status' => true,
                    'message' => 'Fetched accepted applications successfully',
                    'applications' => $applications,
                ], 200);
            }

            if(isset($request->filter) && $request->filter == "Pending")
            {
                $applications = CaseDetail::with('getDynamicFormValues','getCaseMedia','getCaseLaw','getCasePackage','getCaseBid')
                ->where('user_id', $request->user_id)
                ->where('application_status','Pending')
                ->orderby('id','DESC')
                ->get();

                return response()->json([
                    'status' => true,
                    'message' => 'Fetched pending applications successfully',
                    'applications' => $applications,
                ], 200);
            }

            if(isset($request->filter) && $request->filter == "Rejected")
            {
                $applications = CaseDetail::with('getDynamicFormValues','getCaseMedia','getCaseLaw','getCasePackage','getCaseBid')
                ->where('user_id', $request->user_id)
                ->where('application_status','Rejected')
                ->orderby('id','DESC')
                ->get();

                return response()->json([
                    'status' => true,
                    'message' => 'Fetched rejected applications successfully',
                    'applications' => $applications,
                ], 200);
            }

            $applications = CaseDetail::with('getDynamicFormValues','getCaseMedia','getCaseLaw','getCasePackage','getCaseBid')
            ->where('user_id', $request->user_id)
            ->where('application_status','!=',null)
            ->get();

            if(!$applications)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Applications not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Fetched applications successfully',
                'applications' => $applications,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


/**
 * Fetch a specific application details by its ID.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing application ID
 * @return \Illuminate\Http\JsonResponse The JSON response containing the application details
 */
    public function viewApplication(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $application = CaseDetail::with('getCaseMedia','getUser')->findOrFail($request->id);

            return response()->json([
                'status' => true,
                'message' => 'Application fetched successfully',
                'application'=>$application
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Add a new application to the system.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing application data
 * @return \Illuminate\Http\JsonResponse The JSON response containing the newly created application
 */
    public function addApplication(Request $request)
    {
        //using db transaction to avoid extra entry incase of error
        DB::beginTransaction();

        try {
            //Validated
            $validateUser =
            [
                'user_id' => 'required',
                'case_type' => 'required',
                'case_sub_type' => 'required',
                'package_type' => 'required',
                'case_code' => 'nullable',
                'is_same_person' => 'nullable',
                'convictee_name' => 'nullable',
                'convictee_dob' => 'nullable',
                'convictee_relationship' => 'nullable',
                'bid' => 'required',
            ];

            //the handleIntakeFormValidation function comes from restrictedAreaApisController, that controller is extended by this controller
            $validateUser = array_merge($validateUser, $this->handleIntakeFormValidation($request));
            $validator = Validator::make($request->all(),$validateUser);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }

            $application = new CaseDetail();
            $application->user_id = $request->user_id;

            $application->sr_no = $this->uniqueNumberGenerator();

            $application->case_type = $request->case_type;
            $application->case_sub_type = $request->case_sub_type;
            $application->package_type = $request->package_type;
            $application->application_status = null;
            $application->case_status = null;


            $application->is_same_person = $request->is_same_person;
            if($request->is_same_person == 0)
            {
                $application->convictee_name = $request->convictee_name;
                $application->convictee_dob = $request->convictee_dob;
                $application->convictee_relationship = $request->convictee_relationship;
            }

            $application->save();

            // Store form values
            $this->storeFormValues($request, $application);

            //setting lawyerType in case detail table for case feed
            $package = $application->getCasePackage()->first();
            if ($package) {
                switch ($package->title) {
                    case 'Novice':
                        $application->lawyer_type = 1;
                        break;
                    case 'Experienced':
                        $application->lawyer_type = 2;
                        break;
                    case 'Top Notch':
                        $application->lawyer_type = 3;
                        break;
                }
                $application->save();
            }

            //updating case_id of casemedia
            if($request->case_code)
            {
                $case_media_update = CaseMedia::where('case_id',$request->case_code)->get();
                foreach($case_media_update as $caseMedia)
                {
                    $caseMedia->case_id = $application->id;
                    $caseMedia->save();
                }
            }

            //casebid
            if ($application) {

                $get_package = Lawyer::where('id',$application->package_type)->first();

                if($request->bid > $get_package->max_amount)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Kindly decrease case bid amount...'
                    ], 500);
                }

                if($request->bid < $get_package->min_amount)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Kindly increase case bid amount...'
                    ], 500);
                }

                $case_bid = new CaseBid();
                $case_bid->user_id = $request->user_id;
                $case_bid->case_id = $application->id;
                $case_bid->bid = number_format($request->bid, 2, '.', '');
                $case_bid->save();
            }

            $applications = CaseDetail::with('getCaseMedia','getCaseLaw','getCaseLawSub','getCasePackage','getCaseBid','getDynamicFormValues')
            ->where('id',$application->id)->first();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Application submitted successfully',
                'application' => $applications,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Updates an existing application.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */

    public function updateApplication(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required',
                'user_id' => 'required',
                'client_name' => 'required',
                'client_dob' => 'required',
                'preferred_language' => 'required',
                'court_where_the_case_is_at' => 'required',
                'case_or_citation_number' => 'nullable',
                'charges' => 'required',
                'next_court_date' => 'required',
                'type_of_hearing' => 'required',
                'how_many_hearing_have_you_had' => 'required',
                'list_all_prior_criminal_convictions' => 'required',
                'case_type' => 'required',
                'case_sub_type' => 'required',
                'package_type' => 'required',
                'application' => 'required',
                'case_code' => 'nullable',
                'is_same_person' => 'nullable',
                'convictee_name' => 'nullable',
                'convictee_dob' => 'nullable',
                'convictee_relationship' => 'nullable',
                'bid' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $application = CaseDetail::where('id',$request->case_id)->first();
            if(!$application){
                return response()->json([
                    'status' => false,
                    'message' => 'Application not found.',
                ], 404);
            }

            $application->user_id = $request->user_id;
            $application->client_name = $request->client_name;
            $application->client_dob = $request->client_dob;
            $application->preferred_language = $request->preferred_language;
            $application->court_where_the_case_is_at = $request->court_where_the_case_is_at;
            $application->case_or_citation_number = $request->case_or_citation_number;
            $application->charges = $request->charges;
            $application->next_court_date = $request->next_court_date;
            $application->type_of_hearing = $request->type_of_hearing;
            $application->how_many_hearing_have_you_had = $request->how_many_hearing_have_you_had;
            $application->list_all_prior_criminal_convictions = $request->list_all_prior_criminal_convictions;
            $application->case_type = $request->case_type;
            $application->case_sub_type = $request->case_sub_type;
            $application->package_type = $request->package_type;
            $application->application = $request->application;

            $application->is_same_person = $request->is_same_person;
            $application->convictee_name = $request->convictee_name;
            $application->convictee_dob = $request->convictee_dob;
            $application->convictee_relationship = $request->convictee_relationship;

            $application->save();

            //setting lawyerType in case detail table for case feed
            $package = $application->getCasePackage()->first();
            if ($package) {
                switch ($package->title) {
                    case 'Novice':
                        $application->lawyer_type = 1;
                        break;
                    case 'Experienced':
                        $application->lawyer_type = 2;
                        break;
                    case 'Top Notch':
                        $application->lawyer_type = 3;
                        break;
                }
                $application->save();
            }

            //updating case_id of casemedia
            if($request->case_code)
            {
                $case_media_update = CaseMedia::where('case_id',$request->case_code)->get();
                foreach($case_media_update as $caseMedia)
                {
                    $caseMedia->case_id = $application->id;
                    $caseMedia->save();
                }
            }

            $applications = CaseDetail::with('getCaseBid')->where('id',$application->id)->first();

            //casebid
            if ($request->bid) {

                $get_package = Lawyer::where('id',$application->package_type)->first();

                if($request->bid > $get_package->max_amount)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Kindly decrease case bid amount...'
                    ], 500);
                }

                if($request->bid < $get_package->min_amount)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Kindly increase case bid amount...'
                    ], 500);
                }

                $case_bid = $applications->getCaseBid()->first();
                $case_bid->user_id = $request->user_id;
                $case_bid->case_id = $application->id;
                $case_bid->bid = number_format($request->bid, 2, '.', '');
                $case_bid->save();
            }

            $applications = CaseDetail::with('getCaseMedia','getCaseLaw','getCaseLawSub','getCasePackage','getCaseBid')
            ->where('id',$application->id)->first();

            return response()->json([
                'status' => true,
                'message' => 'Application updated successfully',
                'application' => $applications,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Creates a payment plan for an application.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function paymenPlanForApplication(Request $request)
    {
        try {
            // Validated
            $validateUser = Validator::make($request->all(), [
                'customer_id' => 'required',
                'case_id' => 'required',
                'sub_cat_id' => 'required',
                'package_id' => 'required',
                'installments' => 'required|in:yes,no',
                'total_amount' => 'required',
                'installment_cycle' => 'required_if:installments,yes|nullable',
                'downpayment'  => 'required_if:installments,yes|nullable',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $getSubCat = LawSubCategory::where('id',$request->sub_cat_id)->first();
            if($getSubCat)
            {
                if((int)$request->installment_cycle > $getSubCat->installments)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => 'Installment cycle you picked are greater than the installments are available.'
                    ], 401);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'SubCategory not found.',
                ], 404);
            }

            // Begin a transaction
            DB::beginTransaction();

            $case_payment_plan = new PaymentPlan();
            $case_payment_plan->customer_id = $request->customer_id;
            // $case_payment_plan->attorney_id = $request->attorney_id;
            $case_payment_plan->case_id = $request->case_id;
            $case_payment_plan->sub_cat_id = $request->sub_cat_id ;
            $case_payment_plan->package_id = $request->package_id;
            $case_payment_plan->invoice_no = null;
            $case_payment_plan->installments = $request->installments;
            $case_payment_plan->total_amount = $request->total_amount;
            $case_payment_plan->installment_cycle = $request->installment_cycle;
            $case_payment_plan->status = 'Enabled';
            $case_payment_plan->payment_status = 'Unpaid';
            $case_payment_plan->save();

            $case = CaseDetail::where('id',$request->case_id)
            ->first();
            if($case_payment_plan->installments == "yes")
            {

                $min_bid_amount = $case->getCasePackage->min_amount / 2;
                $max_bid_amount = $case->getCasePackage->min_amount * 0.90;

                if($request->downpayment < $min_bid_amount)
                {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Your downpayment is lower than 50% of selected package mininum amount.',
                    ], 404);
                }
                if($request->downpayment > $max_bid_amount)
                {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Your downpayment is higher than 90% of selected package maximum amount.',
                    ], 404);
                }

                $transaction = new Transactions();
                $transaction->payment_plan_id = $case_payment_plan->id;
                $transaction->customer_id = $case_payment_plan->customer_id;
                $transaction->attorney_id = null;
                $transaction->case_id = $case_payment_plan->case_id;
                $transaction->installment_cycle_no = 0; // 0 for downpayment
                $transaction->amount = (int)round($request->downpayment);
                $transaction->date_of_charge = null;
                $transaction->status = 'Pending';
                $transaction->save();

                //we make downpayment only here and the remaining installments will created on contract accept function of attorney
            }else{
                $transaction = new Transactions();
                $transaction->payment_plan_id = $case_payment_plan->id;
                $transaction->customer_id = $case_payment_plan->customer_id;
                $transaction->attorney_id = null;
                $transaction->case_id = $case_payment_plan->case_id;
                $transaction->installment_cycle_no = 0; // 0 for downpayment
                $transaction->amount = $case_payment_plan->total_amount;
                $transaction->date_of_charge = null;
                $transaction->status = 'Pending';
                $transaction->save();
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment plan saved successfully',
                'case_payment_plan' => $case_payment_plan,
                'transaction' => $transaction
            ], 200);

        } catch (\Throwable $th) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Submits a case application.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function caseSubmitApplication(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'case_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //fetch profile data
            $profile_data = User::with('getUserPaymentDetails')->where('id',$request->user_id)->first();
            //fetch case data
            $case_data = CaseDetail::where('id',$request->case_id)->update(['application_status'=>'Accepted','case_status'=>'Pending']);

            $notification = $this->sendNotification([$request->user_id],'Application Submitted Successfully.',null,null);
            return response()->json([
                'status' => true,
                'message' => 'Case submitted successfully'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


/**
 * Deletes a case application.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */

    public function deleteApplication(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $application = CaseDetail::findOrFail($request->id);
            if($application->case_status == 'Accepted')
            {
                return response()->json([
                    'status' => true,
                    'message' => "This application's case accepted already, and cannot be deleted.",
                ], 200);
            }

            $application->delete();
            return response()->json([
                'status' => true,
                'message' => 'Application deleted successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
