<?php

namespace App\Http\Controllers\Apis\Attorney;

use App\Http\Controllers\Controller;
use App\Models\AttorneyApplication;
use App\Models\AttorneyAgreement;
use App\Models\AttorneyMedia;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserPaymentDetails;
use App\Models\Faq;
use App\Models\Appointment;
use App\Models\AttorneyTermsAndCondition;
use App\Models\AttorneyType;
use App\Models\CaseContracts;
use App\Models\CaseDetail;
use App\Models\LawCategory;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AttorneyAreaApisController extends Controller
{

/**
 * Update the profile of the user (attorney).
 * This function handles the validation of user input, updates the user details,
 * processes image upload, and handles password change if provided.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function updateProfile(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'bio' => 'required',
                'image' => 'required|image|max:5120',
                'current_password' => 'nullable',
                'new_password' => 'required_with:current_password',
                'password_confirmation' => 'required_with:current_password|same:new_password'
            ]);


            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user_detail = UserDetail::where('user_id',$request->attorney_id)->firstOrNew();
            $user_detail->user_id = $request->attorney_id;
            $user_detail->first_name = $request->first_name;
            $user_detail->last_name = $request->last_name;
            $user_detail->dob = $request->dob;
            $user_detail->address = $request->address;
            $user_detail->phone = $request->phone;
            $user_detail->bio = $request->bio;
            if ($request->hasFile('image')) {
                    /** Upload new image */
                    $upload_location = '/storage/profile/';
                    $file = $request->image;
                    $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;
                    /** Saving in DB */
                    $user_detail->image = $save_url;
            }
            $user_detail->save();

            $user = User::with('getUserDetails')->where('id',$request->attorney_id)->first();

            if($request->current_password)
            {
                if (Hash::check($request->current_password, $user->password)) {
                    $user->password = Hash::make($request->password);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Your current password is invalid.',
                    ], 401);
                }
                $user->save();
            }

            if($user->restricted_steps == null)
            {
                $user->restricted_steps = 7;
                $user->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'user' => $user,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Handle media uploads for the attorney application.
 * This function validates the uploaded files and saves them into the database.
 * It supports images, videos, and documents with specific file size limits.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function attorneyApplicationMediaUpload(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'media_image.*' => 'nullable|image|max:5120',                   // Each image file can be up to 5MB
                'media_video.*' => 'nullable|mimetypes:video/mp4|max:20480',    // Each video file can be up to 20MB
                'media_document.*' => 'nullable|mimes:pdf,doc,docx|max:5120',   // Each document file can be up to 5MB
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $attorney_application_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            if ($request->hasFile('media_image')) {
                foreach ($request->media_image as $key => $image) {
                    /** Upload new image */
                    $upload_location = '/storage/attorney_application_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $attorney_application_media = new AttorneyMedia();
                    $attorney_application_media->user_id = $request->user_id;
                    $attorney_application_media->application_media_code = $attorney_application_code;
                    $attorney_application_media->type = 'image';
                    $attorney_application_media->media = $save_url;
                    $attorney_application_media->save();
                }
            }
            if ($request->hasFile('media_video')) {
                foreach ($request->media_video as $key => $image) {
                    /** Upload new video */
                    $upload_location = '/storage/attorney_application_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $attorney_application_media = new AttorneyMedia();
                    $attorney_application_media->user_id = $request->user_id;
                    $attorney_application_media->application_media_code = $attorney_application_code;
                    $attorney_application_media->type = 'video';
                    $attorney_application_media->media = $save_url;
                    $attorney_application_media->save();
                }
            }
            if ($request->hasFile('media_document')) {
                foreach ($request->media_document as $key => $image) {
                    /** Upload new document */
                    $upload_location = '/storage/attorney_application_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $attorney_application_media = new AttorneyMedia();
                    $attorney_application_media->user_id = $request->user_id;
                    $attorney_application_media->application_media_code = $attorney_application_code;
                    $attorney_application_media->type = 'document';
                    $attorney_application_media->media = $save_url;
                    $attorney_application_media->save();
                }
            }

            $attorney_application_media = AttorneyMedia::where('application_media_code', $attorney_application_code)->get();

            return response()->json([
                'status' => true,
                'message' => 'Case media uploaded successfully',
                'attorney_application_media' => $attorney_application_media,
                'application_media_code' => $attorney_application_code,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


/**
 * Submit the attorney application details.
 * This function handles the validation, saving, and processing of attorney details,
 * including handling various optional fields, media uploads, and updating application status.
 * It uses DB transactions for atomic operations to avoid inconsistent states.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function attorneyApplicationDetails(Request $request)
    {
        //using db transaction to avoid extra entry incase of error
        DB::beginTransaction();

        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'name_of_applicant' => 'required',
                'name_of_firm_you_work_for' => 'nullable',
                'do_you_own_this_firm' => 'nullable',
                'how_long_have_you_been_in_service_to_the_public' => 'nullable',
                'website' => 'nullable',
                'email' => 'nullable|email',
                'phone' => 'nullable',
                'languages_spoken' => 'nullable',
                'law_school_name' => 'nullable',
                'year_graduated' => 'nullable',
                'admitted_into_law_AZ' => 'nullable',
                'AZ_state_bar_name' => 'nullable',
                'any_special_certification' => 'nullable',

                'dob' => 'nullable',
                'office_address' => 'nullable',

                'area_of_practice' => 'nullable|array',
                'area_of_practice.*' => 'nullable',
                'year_started_in_this_area' => 'nullable|array',
                'year_started_in_this_area.*' => 'nullable',
                'average_cases_handled_per_month' => 'nullable|array',
                'average_cases_handled_per_month.*' => 'nullable',

                'signature_text' => 'nullable',
                'signature_image' => 'nullable|image|max:5120',
                'application_media_code' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $attorney_application = new AttorneyApplication();
            $attorney_application->user_id = $request->user_id;
            $attorney_application->name_of_applicant = $request->name_of_applicant;
            $attorney_application->name_of_firm_you_work_for = $request->name_of_firm_you_work_for;
            $attorney_application->do_you_own_this_firm = $request->do_you_own_this_firm;
            $attorney_application->how_long_have_you_been_in_service_to_the_public = $request->how_long_have_you_been_in_service_to_the_public;
            $attorney_application->website = $request->website;
            $attorney_application->email = $request->email;
            $attorney_application->phone = $request->phone;
            $attorney_application->languages_spoken = $request->languages_spoken;
            $attorney_application->law_school_name = $request->law_school_name;
            $attorney_application->year_graduated = $request->year_graduated;
            $attorney_application->admitted_into_law_AZ = $request->admitted_into_law_AZ;
            $attorney_application->AZ_state_bar_name = $request->AZ_state_bar_name;
            $attorney_application->any_special_certification = $request->any_special_certification;
            $attorney_application->counties_of_preference = json_encode($request->counties_of_preference);

            $attorney_application->dob = $request->dob;
            $attorney_application->office_address = $request->office_address;

            $attorney_application->area_of_practice = json_encode($request->area_of_practice);
            $attorney_application->year_started_in_this_area = json_encode($request->year_started_in_this_area);
            $attorney_application->average_cases_handled_per_month = json_encode($request->average_cases_handled_per_month);

            $attorney_application->signature_text = $request->signature_text;
            $attorney_application->signature_image = $request->signature_image;

            if ($request->hasFile('signature_image')) {
                    /** Upload new image */
                    $upload_location = '/storage/attorney_application_signatures/';
                    $file = $request->signature_image;
                    $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $attorney_application->signature_image = $save_url;
            }

            $attorney_application->save();




            //updating attorney_application_id of application_media
            if($request->application_media_code)
            {
                $attorney_application_media = AttorneyMedia::where('application_media_code',$request->application_media_code)->get();
                foreach($attorney_application_media as $media)
                {
                    $media->attorney_application_id = $attorney_application->id;
                    $media->save();
                }
            }

            $attorney_applications = AttorneyApplication::with('getAttorneyApplicationMedia')->where('id',$attorney_application->id)->first();
            if($attorney_applications->counties_of_preference !== null)
                {
                    $attorney_applications->counties_of_preference = json_decode($attorney_applications->counties_of_preference);
                }
            $attorney_applications->area_of_practice = json_decode($attorney_applications->area_of_practice);
            $attorney_applications->year_started_in_this_area = json_decode($attorney_applications->year_started_in_this_area);
            $attorney_applications->average_cases_handled_per_month = json_decode($attorney_applications->average_cases_handled_per_month);

            //updating restricted_step flag for mobile app
            $user = User::where('id',$request->user_id)->first();
            if($user->restricted_steps == 7)
            {
                $user->restricted_steps = 8;
                $user->save();
            }


            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Attorney application submitted successfully',
                'attorney_application' => $attorney_applications,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Store attorney agreement data.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function attorneyAgreement(Request $request)
    {
        //using db transaction to avoid extra entry incase of error
        DB::beginTransaction();

        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'attorney_name_1' => 'required',
                'area_of_law' => 'required',
                'malpractice' => 'nullable',
                'signature' => 'nullable|image|max:5120',
                'date' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $attorney_agreement = new AttorneyAgreement();
            $attorney_agreement->user_id = $request->user_id;
            $attorney_agreement->attorney_name_1 = $request->attorney_name_1;
            $attorney_agreement->area_of_law = $request->area_of_law;
            $attorney_agreement->malpractice = $request->malpractice;
            $attorney_agreement->date = $request->date;


            // $attorney_agreement->signature = $request->signature;

            if ($request->hasFile('signature')) {
                    /** Upload new image */
                    $upload_location = '/storage/attorney_agreement_signatures/';
                    $file = $request->signature;
                    $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $attorney_agreement->signature = $save_url;
            }

            $attorney_agreement->save();

            $attorney_agreement = AttorneyAgreement::where('id',$attorney_agreement->id)->first();

            //updating restricted_step flag for mobile app
            $user = User::where('id',$request->user_id)->first();
            if($user->restricted_steps == 8)
            {
                $user->restricted_steps = 9;
                $user->save();
            }

            $attorney_agreement->area_of_law = json_decode($attorney_agreement->area_of_law);

            DB::commit();


            return response()->json([
                'status' => true,
                'message' => 'Attorney agreement submitted successfully',
                'attorney_agreement' => $attorney_agreement,
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
/**
 * Store card details for a user.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function storeCardDetails(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'stripe_customer_id' => 'required',
                'card_expiry_month' => 'required',
                'card_expiry_year' => 'required',
                'card_last_four' => 'required',
                'json_response' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

                //attaching payment to customer
                $userPaymentDetails = new UserPaymentDetails();
                $userPaymentDetails->user_id = $request->user_id;
                $userPaymentDetails->stripe_customer_id = $request->stripe_customer_id;
                $userPaymentDetails->card_expiry_month = $request->card_expiry_month;
                $userPaymentDetails->card_expiry_year = $request->card_expiry_year;
                $userPaymentDetails->card_last_four = $request->card_last_four;
                $userPaymentDetails->json_response = $request->json_response;
                $userPaymentDetails->status = 'Enabled';
                $userPaymentDetails->save();

            //updating steps
            $user = User::where('id',$request->user_id)->first();
            if($user->restricted_steps == 9)
            {
                $user->restricted_steps = 10;
                $user->save();
            }

            $notification = $this->sendNotification([$request->user_id],'Congratulations your card has been attached successfully.',null,null);
            return response()->json([
                'status' => true,
                'message' => 'Card Added successfully',
                'userPaymentDetails' => $userPaymentDetails,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Store payment details for a user.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function storePaymentDetails(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'stripe_attorney_connect_id' => 'required',
                'json_response' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

                // Create new record
                $userPayment = UserPaymentDetails::where('user_id',$request->user_id)->where('status','Enabled')->first();
                $userPayment->user_id = $request->user_id;
                $userPayment->stripe_attorney_connect_id = $request->stripe_attorney_connect_id;
                $userPayment->json_response = $request->json_response;
                $userPayment->status = "Enabled";
                $userPayment->save();

            //updating steps
            $user = User::where('id',$request->user_id)->first();
            if($user->restricted_steps == 9)
            {
                $user->restricted_steps = 10;
                $user->save();
            }

            $notification = $this->sendNotification([$request->user_id],'Congratulations, Connect stripe account onboarding successfull.',null,null);

            return response()->json([
                'status' => true,
                'message' => 'Submit data successfully',
                'userPaymentDetails' => $userPayment,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Preview the application details of a user.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function applicationDetailPreview(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'application_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //fetch profile data
            $profile_data = User::with('getUserDetails','getAttorneyPaymentDetails')->where('id',$request->user_id)->first();
            //fetch application data
            $application_data = AttorneyApplication::with('getAttorneyApplicationMedia')->where('id',$request->application_id)->where('user_id',$profile_data->id)->first();

            if($application_data){
                if($application_data->counties_of_preference !== null)
                {
                    $application_data->counties_of_preference = json_decode($application_data->counties_of_preference);
                }
                $application_data->area_of_practice = json_decode($application_data->area_of_practice);
                $application_data->year_started_in_this_area = json_decode($application_data->year_started_in_this_area);
                $application_data->average_cases_handled_per_month = json_decode($application_data->average_cases_handled_per_month);
            }

            $profile_data['application_data'] = $application_data;

            return response()->json([
                'status' => true,
                'message' => 'Fetched data successfully',
                'profile_data' => $profile_data,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Submits the attorney application details after validation.
 *
 * @param \Illuminate\Http\Request $request The incoming request.
 * @return \Illuminate\Http\JsonResponse The JSON response containing status and application data.
 */
    public function applicationDetailPreviewSubmit(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'application_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //fetch profile data
            $profile_data = User::with('getUserDetails')->where('id',$request->user_id)->first();
            //updating status of application data
            $application_data = AttorneyApplication::where('id',$request->application_id)->update(['status'=>'Pending']);

            //updating steps
            if($profile_data->restricted_steps == 10)
            {
                $profile_data->restricted_steps = 12;
                $profile_data->save();
            }
            $notification = $this->sendNotification([$request->user_id],'Application Submitted Successfully.',null,null);

            return response()->json([
                'status' => true,
                'message' => 'Application submited successfully',
                'profile_date'=> $profile_data,
                'application_data' => $application_data
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Accepts and automates the attorney application process.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing attorney and application data.
 * @return \Illuminate\Http\JsonResponse The JSON response with the status of the operation.
 */
    public function applicationAcceptAutomate(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
                'application_id' => 'required',
                'law_cat_id' => 'required|array',
                'law_cat_id.*' => 'integer',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //fetch profile data
            $profile_data = User::with('getUserDetails')->where('id',$request->attorney_id)->first();
            //updating status of application data
            $update_application_data = AttorneyApplication::where('id',$request->application_id)->update(['status'=>'Accepted']);

            //automating super admin process
            foreach($request->law_cat_id as $law_cat_id){
                $makeAttorneyType =new AttorneyType();
                $makeAttorneyType->user_id = $request->attorney_id;
                $makeAttorneyType->law_cat_id = $law_cat_id;
                $makeAttorneyType->lawyer_id = 2;
                $makeAttorneyType->save();
            }

            //updating steps
            if($profile_data->restricted_steps == 12)
            {
                $profile_data->restricted_steps = 13;
                $profile_data->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Application updated and automated successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Fetches the terms and conditions for the attorney.
 *
 * @return \Illuminate\Http\JsonResponse The JSON response containing the terms and conditions data.
 */
    public function attorneyTermsAndConditions()
    {
        try {
            //fetch terms and conditions data
            $terms = AttorneyTermsAndCondition::first();

            return response()->json([
                'status' => true,
                'message' => 'Terms and conditions fetched successfully',
                'terms_and_conditions' => $terms
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Fetches the available attorney-client agreements.
 *
 * @return \Illuminate\Http\JsonResponse The JSON response containing the agreements data.
 */
    public function attorneyUniversalClientAttorneyAgreements()
    {
        try {
            $agreements = CaseContracts::with('getCaseLaw')->where('status','Enable')->get();

            return response()->json([
                'status' => true,
                'message' => 'Agreements fetched successfully',
                'agreements' => $agreements
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Fetches the attorney fee intake data based on the provided law categories.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing law category IDs.
 * @return \Illuminate\Http\JsonResponse The JSON response with the fee intake data.
 */
    public function attorneyFeeIntake(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'law_cat_id' => 'required|array',
                'law_cat_id.*' => 'integer',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //fetch attorney fee intake data
            $fee = LawCategory::with('subCategories.getLaywers')->whereIn('id',$request->law_cat_id)->get();

            return response()->json([
                'status' => true,
                'message' => 'Fee intake fetched successfully',
                'fee' => $fee,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
