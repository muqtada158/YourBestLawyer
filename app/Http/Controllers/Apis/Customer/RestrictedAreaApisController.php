<?php

namespace App\Http\Controllers\Apis\Customer;

use App\Http\Controllers\Controller;
use App\Http\Traits\NotificationTrait;
use App\Http\Traits\NumberGeneratorTrait;
use App\Models\Appointment;
use App\Models\CaseAttornies;
use App\Models\CaseBid;
use App\Models\CaseContracts;
use App\Models\CaseDetail;
use App\Models\CaseMedia;
use App\Models\Contracts;
use App\Models\CustomerContract;
use App\Models\DynamicForms;
use App\Models\DynamicFormValues;
use App\Models\LawCategory;
use App\Models\LawSubCategory;
use App\Models\Lawyer;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserPaymentDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RestrictedAreaApisController extends Controller
{
    use NumberGeneratorTrait, NotificationTrait;

    public function updateProfile(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'image' => 'required|image|max:5120',
                'current_password' => 'nullable',
                'new_password' => 'required_with:old_password',
                'password_confirmation' => 'required_with:old_password|same:new_password'
            ]);


            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user_detail = UserDetail::where('user_id',$request->user_id)->firstOrNew();
            $user_detail->user_id = $request->user_id;
            $user_detail->first_name = $request->first_name;
            $user_detail->last_name = $request->last_name;
            $user_detail->dob = $request->dob;
            $user_detail->address = $request->address;
            $user_detail->phone = $request->phone;
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

            $user = User::with('getUserDetails')->where('id',$request->user_id)->first();

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
                $user->restricted_steps = 9;
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

    public function getAllCategoriesWithSubCategoriesWithLawyers()
    {
        try {
            $subCategories = LawCategory::with('subCategories.getLaywers')->orderby('id','ASC')->get();

            // $subCategories = LawCategory::with(['subCategories' => function ($query) {
            //     $query->select('cat_id', 'id', 'title','installments_available','installments')
            //         ->with(['getLaywers' => function ($query) {
            //             $query->select('id', 'sub_cat_id', 'title', 'min_amount', 'max_amount');
            //         }]);
            // }])->select('id', 'title')
            //     ->orderBy('id', 'ASC')
            //     ->get();

            return response()->json([
                'status' => true,
                'message' => 'All categories with subcategories fetched successfully',
                'categories' => $subCategories,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function caseMediaUploadInitial(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'media_image.*' => 'nullable|image|max:5120',                   // Each image file can be up to 5MB
                'media_video' => 'nullable|max:20480', // Each video file can be up to 20MB
                'media_document.*' => 'nullable|mimes:pdf,doc,docx|max:5120',   // Each document file can be up to 5MB
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $case_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            if ($request->hasFile('media_image')) {
                foreach ($request->media_image as $key => $image) {
                    /** Upload new image */
                    $upload_location = '/storage/case_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $case_media = new CaseMedia();
                    $case_media->user_id = $request->user_id;
                    $case_media->case_id = $case_code;
                    $case_media->type = 'image';
                    $case_media->media = $save_url;
                    $case_media->save();
                }
            }
            if ($request->hasFile('media_video')) {
                foreach ($request->media_video as $key => $image) {
                    /** Upload new video */
                    $upload_location = '/storage/case_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $case_media = new CaseMedia();
                    $case_media->user_id = $request->user_id;
                    $case_media->case_id = $case_code;
                    $case_media->type = 'video';
                    $case_media->media = $save_url;
                    $case_media->save();
                }
            }
            if ($request->hasFile('media_document')) {
                foreach ($request->media_document as $key => $image) {
                    /** Upload new document */
                    $upload_location = '/storage/case_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $case_media = new CaseMedia();
                    $case_media->user_id = $request->user_id;
                    $case_media->case_id = $case_code;
                    $case_media->type = 'document';
                    $case_media->media = $save_url;
                    $case_media->save();
                }
            }

            $case_media = CaseMedia::where('case_id', $case_code)->get();

            return response()->json([
                'status' => true,
                'message' => 'Case media uploaded successfully',
                'case_media' => $case_media,
                'case_code' => $case_code,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getIntakeForms(Request $request)
    {
        try {
            // Validated
            $validateUser = Validator::make($request->all(), [
                'law_cat_id' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $form = DynamicForms::where('case_cat_id',$request->law_cat_id)->first();
            $form->form = json_decode($form->form);

            return response()->json([
                'status' => true,
                'message' => 'Fetched intake dynamic form successfully',
                'form' => $form
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function caseDetails(Request $request)
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

            $validateUser = array_merge($validateUser, $this->handleIntakeFormValidation($request));
            $validator = Validator::make($request->all(),$validateUser);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }

            $case_detail = new CaseDetail();
            $case_detail->user_id = $request->user_id;

            $case_detail->sr_no = $this->uniqueNumberGenerator();

            $case_detail->case_type = $request->case_type;
            $case_detail->case_sub_type = $request->case_sub_type;
            $case_detail->package_type = $request->package_type;
            $case_detail->application_status = null;
            $case_detail->case_status = null;

            $case_detail->is_same_person = $request->is_same_person;
            if($request->is_same_person == 0)
            {
                $case_detail->convictee_name = $request->convictee_name;
                $case_detail->convictee_dob = $request->convictee_dob;
                $case_detail->convictee_relationship = $request->convictee_relationship;
            }

            $case_detail->save();

            // Store form values
            $this->storeFormValues($request, $case_detail);

            //setting lawyerType in case detail table for case feed
            $package = $case_detail->getCasePackage()->first();
            if ($package) {
                switch ($package->title) {
                    case 'Novice':
                        $case_detail->lawyer_type = 1;
                        break;
                    case 'Experienced':
                        $case_detail->lawyer_type = 2;
                        break;
                    case 'Top Notch':
                        $case_detail->lawyer_type = 3;
                        break;
                }
                $case_detail->save();
            }

            //updating case_id of casemedia
            if($request->case_code)
            {
                $case_media_update = CaseMedia::where('case_id',$request->case_code)->get();
                foreach($case_media_update as $caseMedia)
                {
                    $caseMedia->case_id = $case_detail->id;
                    $caseMedia->save();
                }
            }

            //casebid
            if ($case_detail) {

                $get_package = Lawyer::where('id',$case_detail->package_type)->first();

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
                $case_bid->case_id = $case_detail->id;
                $case_bid->bid = number_format($request->bid, 2, '.', '');
                $case_bid->save();
            }



            $case_details = CaseDetail::with('getCaseMedia','getCaseLaw','getCaseLawSub','getCasePackage','getCaseBid','getDynamicFormValues')
            ->where('id',$case_detail->id)->first();

            //getting contract details
            //for now it is dummy we need to send specific contracts via filter when all contracts upload to db in future
            if ($case_details) {
                $contract_detail = Contracts::latest()->first();
                // Add the contract detail to the case details object
                $case_details->contract_detail = $contract_detail;
            }

            //updating restricted_step flag for mobile app
            $user = User::where('id',$request->user_id)->first();
            if($user->restricted_steps == 9)
            {
                $user->restricted_steps = 10;
                $user->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Case details submitted successfully',
                'case_detail' => $case_details,
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function caseDetailsEdit(Request $request)
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

            $case_detail = CaseDetail::where('id',$request->case_id)->first();
            $case_detail->user_id = $request->user_id;
            $case_detail->client_name = $request->client_name;
            $case_detail->client_dob = $request->client_dob;
            $case_detail->preferred_language = $request->preferred_language;
            $case_detail->court_where_the_case_is_at = $request->court_where_the_case_is_at;
            $case_detail->case_or_citation_number = $request->case_or_citation_number;
            $case_detail->charges = $request->charges;
            $case_detail->next_court_date = $request->next_court_date;
            $case_detail->type_of_hearing = $request->type_of_hearing;
            $case_detail->how_many_hearing_have_you_had = $request->how_many_hearing_have_you_had;
            $case_detail->list_all_prior_criminal_convictions = $request->list_all_prior_criminal_convictions;
            $case_detail->case_type = $request->case_type;
            $case_detail->case_sub_type = $request->case_sub_type;
            $case_detail->package_type = $request->package_type;
            $case_detail->application = $request->application;

            $case_detail->is_same_person = $request->is_same_person;
            $case_detail->convictee_name = $request->convictee_name;
            $case_detail->convictee_dob = $request->convictee_dob;
            $case_detail->convictee_relationship = $request->convictee_relationship;

            $case_detail->save();

            //setting lawyerType in case detail table for case feed
            $package = $case_detail->getCasePackage()->first();
            if ($package) {
                switch ($package->title) {
                    case 'Novice':
                        $case_detail->lawyer_type = 1;
                        break;
                    case 'Experienced':
                        $case_detail->lawyer_type = 2;
                        break;
                    case 'Top Notch':
                        $case_detail->lawyer_type = 3;
                        break;
                }
                $case_detail->save();
            }

            //updating case_id of casemedia
            if($request->case_code)
            {
                $case_media_update = CaseMedia::where('case_id',$request->case_code)->get();
                foreach($case_media_update as $caseMedia)
                {
                    $caseMedia->case_id = $case_detail->id;
                    $caseMedia->save();
                }
            }


            $case_details = CaseDetail::with('getCaseBid')->where('id',$case_detail->id)->first();

            //casebid
            if ($request->bid) {

                $get_package = Lawyer::where('id',$case_detail->package_type)->first();

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

                $case_bid = $case_details->getCaseBid()->first();
                $case_bid->user_id = $request->user_id;
                $case_bid->case_id = $case_detail->id;
                $case_bid->bid = number_format($request->bid, 2, '.', '');
                $case_bid->save();
            }

            $case_details = CaseDetail::with('getCaseMedia','getCaseLaw','getCaseLawSub','getCasePackage','getCaseBid')
            ->where('id',$case_detail->id)->first();


            return response()->json([
                'status' => true,
                'message' => 'Case details submitted successfully',
                'case_detail' => $case_details,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function storeFormValues($request, $caseDetail) {
        $formValueData = $this->getFormValueData($request);

        $store = new DynamicFormValues();
        $store->case_id = $caseDetail->id;
        $store->user_id = $caseDetail->user_id;
        $store->form_values = json_encode($formValueData);
        $store->status = 'Enabled';
        $store->save();
    }
    public function handleIntakeFormValidation($request) {
        switch ($request->case_type) {
            case 1: // Family Law
                return [
                    // 'person_accused' => 'required|boolean',
                    // 'convictee_name' => 'nullable|string|required_if:person_accused,0',
                    // 'convictee_dob' => 'nullable|required_if:person_accused,0',
                    // 'relation_with_convictee' => 'nullable|string|required_if:person_accused,0',
                    'client_name' => 'required',
                    'current_address_of_adversary' => 'required|string',
                    'marriage_date_if_applicable' => 'nullable',
                    'place_of_marriage_if_applicable' => 'nullable|string',
                    'number_of_children_in_common' => 'nullable',
                    'number_of_children_not_in_common' => 'nullable',
                    'value_of_community_assets' => 'nullable|string',
                    'do_you_or_the_adversary_own_any_business' => 'required|string',
                    'your_objective' => 'required|string',
                ];
                break;
            case 2: // DUI
                return [
                    'date_of_violation' => 'required',
                    'complaint_or_citation_number' => 'required|string',
                    'court_where_the_case_was_filed' => 'required|string',
                    'how_many_hearings_have_you_gone_to' => 'required|integer',
                    'next_court_hearing' => 'required',
                    'type_of_hearing' => 'required|string|in:Initial Appearance,Preliminary Hearing,Status Conference,Arraignment,Pre-trial Conference,Change of Plea,Trial,Jury Trial',
                    'list_all_charges_you_are_being_charged_with' => 'required|string',
                    'preferred_language' => 'required|string',
                    'prior_dui_convictions_within_the_last_7_years' => 'required|string|in:Yes,No',
                    'how_many_dui_convictions' => 'nullable|integer',
                    'prior_felony_convictions' => 'required|string|in:Yes,No',
                    'any_prior_misdemeanor_convictions_within_the_last_7_years' => 'required|string|in:Yes,No',
                    'how_many_misdemeanor_convictions' => 'nullable|integer',
                    'are_you_currently_on_probation' => 'required|string|in:Yes,No',
                    'current_immigration_status' => 'required|string|in:Undocumented,Visa Status,Resident,Citizen',
                ];
                break;
            case 3: // Personal Injury
                return [
                    'date_of_injury' => 'required',
                    'location_of_injury_city' => 'required|string',
                    'location_of_injury_state' => 'required|string',
                    'location_of_injury_county' => 'required|string',
                    'police_department_involved' => 'required|string',
                    'cross_streets' => 'required|string',
                    'were_you_cited' => 'required|in:Yes,No',
                    'was_anybody_else_cited' => 'nullable|in:Yes,No',
                    'number_of_people_in_vehicle' => 'required|integer|min:1',
                    'part_of_car_impacted' => 'required|string',
                    'estimated_damages' => 'required|string',
                    'body_parts_hurting' => 'required|string',
                    'have_you_seen_a_doctor' => 'required|in:Yes,No',
                    'did_you_notify' => 'nullable|in:Yes,No',
                    'their_name' => 'nullable|string',
                    'their_contact_phone' => 'nullable',
                    'their_contact_email' => 'nullable|email',
                    'name_of_the_business' => 'nullable|string',
                ];
                break;
            case 5: // Bacnkruptcy Law
                return [
                    'spouses_name_if_applicable' => 'nullable',
                    'number_of_children_legally_responsible' => 'nullable|integer',
                    'yearly_gross_income' => 'required|integer',
                    'do_you_or_your_spouse_own_a_business' => 'required|string|in:Yes,No',
                    'do_you_own_a_home' => 'required|string|in:Yes,No',
                    'how_much_do_you_owe_on_your_house' => 'nullable',
                    'estimated_equity_in_your_home' => 'nullable',
                    'amount_of_unsecured_debt' => 'required',
                    'amount_of_secured_debts' => 'required',
                    'are_you_involved_in_legal_proceedings' => 'required|string',
                    'legal_proceedings_details' => 'nullable|string',
                    'are_paychecks_subject_to_garnishment' => 'required|string',
                    'do_you_have_outstanding_tax_obligations' => 'required|',
                    'outstanding_tax_years' => 'nullable',
                    'entered_into_agreements_with_irs' => 'required|string|in:Yes,No',
                ];
                break;
            case 6: // Civil Law
                return [
                    'matter_type' => 'required|string|in:Business,Personal',
                    'business_name' => 'nullable|string|required_if:matter_type,Business',
                    'business_state' => 'nullable|string|required_if:matter_type,Business',
                    'officer_name' => 'nullable|required_if:matter_type,Business',
                    'adversary_type' => 'required|string|in:Soon-to-be Former Spouse,Baby’s Mother/Father',
                    'adversarys_name' => 'required|string',
                    'adversarys_residence' => 'required|string',
                    'location_of_business_transactions' => 'required|string',
                    'compensation_amount_sought' => 'required|string',
                    'description_of_wrongful_conduct' => 'required|string',
                    'are_you_facing_lawsuits' => 'required|string|in:Yes,No',
                    'court_where_served' => 'nullable|string|required_if:are_you_facing_lawsuits,Yes',
                    'when_were_you_served' => 'nullable|required_if:are_you_facing_lawsuits,Yes',
                    'case_number' => 'nullable|string|required_if:are_you_facing_lawsuits,Yes',
                ];
                break;
        }
    }
    public function getFormValueData($request) {
        switch ($request->case_type) {
            case 1: // Family Law
                return [
                    'Client Name' => $request->client_name ?? null,
                    'Current Address Of Adversary' => $request->current_address_of_adversary ?? null,
                    'Marriage Date' => $request->marriage_date_if_applicable ?? null,
                    'Place Of Marriage' => $request->place_of_marriage_if_applicable ?? null,
                    'Number Of Children In Common' => $request->number_of_children_in_common ?? null,
                    'Number Of Children Not In Common' => $request->number_of_children_not_in_common ?? null,
                    'Value Of Community Assets' => $request->value_of_community_assets ?? null,
                    'Do You Or The Adversary Own Any Business' => $request->do_you_or_the_adversary_own_any_business ?? null,
                    'Your Objective' => $request->your_objective ?? null,
                ];

                break;
            case 2: // DUI
                return [
                    'Date Of Violation' => $request->date_of_violation ?? null,
                    'Complaint Or Citation Number' => $request->complaint_or_citation_number ?? null,
                    'Court Where The Case Was Filed' => $request->court_where_the_case_was_filed ?? null,
                    'How Many Hearings Have You Gone To' => $request->how_many_hearings_have_you_gone_to ?? null,
                    'Next Court Hearing' => $request->next_court_hearing ?? null,
                    'Type Of Hearing' => $request->type_of_hearing ?? null,
                    'List All Charges You Are Being Charged With' => $request->list_all_charges_you_are_being_charged_with ?? null,
                    'Preferred Language' => $request->preferred_language ?? null,
                    'Prior DUI Convictions Within The Last 7 Years' => $request->prior_dui_convictions_within_the_last_7_years ?? null,
                    'How Many DUI Convictions' => $request->how_many_dui_convictions ?? null,
                    'Prior Felony Convictions' => $request->prior_felony_convictions ?? null,
                    'Any Prior Misdemeanor Convictions Within The Last 7 Years' => $request->any_prior_misdemeanor_convictions_within_the_last_7_years ?? null,
                    'How Many Misdemeanor Convictions' => $request->how_many_misdemeanor_convictions ?? null,
                    'Are You Currently On Probation' => $request->are_you_currently_on_probation ?? null,
                    'Current Immigration Status' => $request->current_immigration_status ?? null,
                ];

                break;
            case 3: // Personal Injury
                return [
                    'Date Of Injury' => $request->date_of_injury ?? null,
                    'Location Of Injury City' => $request->location_of_injury_city ?? null,
                    'Location Of Injury State' => $request->location_of_injury_state ?? null,
                    'Location Of Injury County' => $request->location_of_injury_county ?? null,
                    'Police Department Involved' => $request->police_department_involved ?? null,
                    'Cross Streets' => $request->cross_streets ?? null,
                    'Were You Cited' => $request->were_you_cited ?? null,
                    'Was Anybody Else Cited' => $request->was_anybody_else_cited ?? null,
                    'Number Of People In Vehicle' => $request->number_of_people_in_vehicle ?? null,
                    'What Part of the Car Was Impacted?' => $request->part_of_car_impacted ?? null,
                    'How much do you estimate the amount of damages to your vehicle?' => $request->estimated_damages ?? null,
                    'Describe All Body Parts That Are Hurting Because of the Accident' => $request->body_parts_hurting ?? null,
                    'Have You Seen A Doctor' => $request->have_you_seen_a_doctor ?? null,
                    'Did You Notify the Appropriate Owners, Supervisors, or Someone in Charge of the Property?' => $request->did_you_notify ?? null,
                    'Their Name' => $request->their_name ?? null,
                    'Their Contact Phone' => $request->their_contact_phone ?? null,
                    'Their Contact Email' => $request->their_contact_email ?? null,
                    'Name Of The Business' => $request->name_of_the_business ?? null,
                ];

                break;
            case 5: // Bacnkruptcy Law
                return [
                    'Spouses Name' => $request->spouses_name_if_applicable ?? null,
                    'Number of Children for Whom You and Your Spouse Are Legally Responsible' => $request->number_of_children_legally_responsible ?? null,
                    'Yearly Gross Income (Before Taxes and Deductions)' => $request->yearly_gross_income ?? null,
                    'Do You or Your Spouse Own a Business?' => $request->do_you_or_your_spouse_own_a_business ?? null,
                    'Do You Own a Home?' => $request->do_you_own_a_home ?? null,
                    'If Yes, How Much Do You Owe on Your House?' => $request->how_much_do_you_owe_on_your_house ?? null,
                    'Estimated Equity in Your Home' => $request->estimated_equity_in_your_home ?? null,
                    'How Much Do You Owe in Unsecured Debt (e.g., Credit Cards, Personal Loans, Medical Bills)?' => $request->amount_of_unsecured_debt ?? null,
                    'How Much Do You Owe in Secured Debts (e.g., House Loan, Car Loans, Furniture Loans)?' => $request->amount_of_secured_debts ?? null,
                    'Are You Presently Involved in Any Legal Proceedings?' => $request->are_you_involved_in_legal_proceedings ?? null,
                    'If Yes, What Are They?' => $request->legal_proceedings_details ?? null,
                    'Are Your Paychecks Currently Subject to Garnishment?' => $request->are_paychecks_subject_to_garnishment ?? null,
                    'Do You Have Outstanding Tax Obligations?' => $request->do_you_have_outstanding_tax_obligations ?? null,
                    'If So, For Which Years?' => $request->outstanding_tax_years ?? null,
                    'Have You Entered Into Any Agreements, Such as a Reaffirmation with the IRS, to Settle These Tax Liabilities?' => $request->entered_into_agreements_with_irs ?? null,
                ];

                break;
            case 6: // Civil Law
                return [
                    'Is This a Personal Civil Matter or a Business Matter?' => $request->matter_type ?? null,
                    'Business Name' => ($request->matter_type === 'Business') ? $request->business_name ?? null : null,
                    'State Where Business Resides' => ($request->matter_type === 'Business') ? $request->business_state ?? null : null,
                    'Name of Officer in Charge' => ($request->matter_type === 'Business') ? $request->officer_name ?? null : null,
                    'Adversary Type' => $request->adversary_type ?? null,
                    'Adversary’s Name' => $request->adversarys_name ?? null,
                    'Adversary’s Residence' => $request->adversarys_residence ?? null,
                    'Location Of Business Transactions' => $request->location_of_business_transactions ?? null,
                    'Compensation Amount Sought' => $request->compensation_amount_sought ?? null,
                    'Description Of Wrongful Conduct' => $request->description_of_wrongful_conduct ?? null,
                    'Are You Currently Facing Any Lawsuits?' => $request->are_you_facing_lawsuits ?? null,
                    'Court Where Served' => ($request->are_you_facing_lawsuits === 'Yes') ? $request->court_where_served ?? null : null,
                    'When Were You Served' => ($request->are_you_facing_lawsuits === 'Yes') ? $request->when_were_you_served ?? null : null,
                    'Case Number' => ($request->are_you_facing_lawsuits === 'Yes') ? $request->case_number ?? null : null,
                ];

                break;
        }
    }

    public function caseBidAndUserPaymentDetails(Request $request)
    {
        try {
            // Validated
            $validateUser = Validator::make($request->all(), [
                'user_id' => 'required',
                'stripe_customer_id' => 'required',
                'card_expiry_month' => 'nullable',
                'card_expiry_year' => 'nullable',
                'card_last_four' => 'nullable',
                'json_response' => 'nullable',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            // Begin a transaction
            DB::beginTransaction();

            $user_payment_details = new UserPaymentDetails();
            $user_payment_details->user_id = $request->user_id;
            $user_payment_details->stripe_customer_id = $request->stripe_customer_id;
            $user_payment_details->card_expiry_month = $request->card_expiry_month;
            $user_payment_details->card_expiry_year = $request->card_expiry_year;
            $user_payment_details->card_last_four = $request->card_last_four;
            $user_payment_details->json_response = $request->json_response;
            $user_payment_details->status = 'Enabled';
            $user_payment_details->save();

            $user = User::where('id',$request->user_id)->first();
            if($user->restricted_steps == 10)
            {
                $user->restricted_steps = 11;
                $user->save();
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment details saved successfully',
                'user_payment_details' => $user_payment_details
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

    public function getCasePaymentPlan(Request $request)
    {
        try {
            // Validated
            $validateUser = Validator::make($request->all(), [
                'law_subcategory_id' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $case = LawSubCategory::where('id',$request->law_subcategory_id)->first();

            return response()->json([
                'status' => true,
                'message' => 'Fetched plan successfully',
                'case' => $case
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function casePaymentPlanStore(Request $request)
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


            $user = User::where('id',$request->customer_id)->first();
            if($user->restricted_steps == 11)
            {
                $user->restricted_steps = 12;
                $user->save();
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

    public function casePreview(Request $request)
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
            $profile_data = User::with('getUserDetails','getUserPaymentDetails')->where('id',$request->user_id)->first();
            //fetch case data
            $case_data = CaseDetail::with('getCaseMedia','getCaseBid','getCaseLaw','getCaseLawSub','getCasePackage','getDynamicFormValues')->where('id',$request->case_id)->where('user_id',$profile_data->id)->first();

            return response()->json([
                'status' => true,
                'message' => 'Fetched data successfully',
                'profile_data' => $profile_data,
                'case_data' => $case_data,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function caseSubmit(Request $request)
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

            //triggering notifications
            $notification = $this->sendNotification([$request->user_id],'Application Submitted Successfully.',null,null);

            if($profile_data->restricted_steps == 12)
            {
                $profile_data->restricted_steps = 13;
                $profile_data->save();
            }

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

    public function getAllAttornies(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //fetch attornies data
            $interstedAttornies= CaseAttornies::with('getAttornies.getUserDetails','getAttornies.getUserPaymentDetailsOne','getAttornies.getRatings','getCaseDetails.getCaseBid')
            ->where('case_id',$request->case_id)
            ->where('status','Interested')
            ->get();

            $interstedAttornies->each(function ($attorney) {
                $ratings = $attorney->getAttornies->getRatings;
                $average_rating = $ratings->avg('rating');
                $attorney->average_ratings = $average_rating;
            });

            return response()->json([
                'status' => true,
                'message' => 'Attornies fetched successfully',
                'attornies' => $interstedAttornies
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function getAttorneyDetails(Request $request)
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

            //fetch attornies data
            $attorney_details = User::with('getUserDetails','getInterestedAttorney','getCaseCounts')->where('id',$request->attorney_id)->first();

            $ratings = $attorney_details->getRatings;
            $average_rating = $ratings->avg('rating');

            // Add the average_ratings field to the array
            $attorney_details['average_ratings'] = $average_rating;

            return response()->json([
                'status' => true,
                'message' => 'Attorney detail fetched successfully',
                'attorney_details' => $attorney_details
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function customerContract(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'customer_id' => 'required',
                'attorney_id' => 'required',
                'case_id' => 'required',
                'convictee_full_name' => 'nullable',
                'convictee_date' => 'nullable',
                'convictee_relationship' => 'nullable',
                'contract_date' => 'required',
                'contract_id' => 'required',
                'signature_image' => 'required|image|max:5120',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            DB::beginTransaction();

            $customer_contract = new CustomerContract();
            $customer_contract->customer_id = $request->customer_id;
            $customer_contract->attorney_id = $request->attorney_id;
            $customer_contract->case_id = $request->case_id;
            if($request->convictee_full_name !== null)
            {
                $customer_contract->convictee_full_name = $request->convictee_full_name;
                $customer_contract->convictee_date = $request->convictee_date;
                $customer_contract->convictee_relationship = $request->convictee_relationship;
            }
            $customer_contract->contract_id = $request->contract_id;
            $customer_contract->contract_date = $request->contract_date;

            if ($request->hasFile('signature_image')) {
                    /** Upload new image */
                    $upload_location = '/storage/customer-contract-signatures/';
                    $file = $request->signature_image;
                    $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    $customer_contract->signature_image = $save_url;
            }

            $customer_contract->save();

            //get attorney bid and update payment plan according to that starts
            $attorney_bid = CaseAttornies::where('case_id',$customer_contract->case_id)
            ->where('attorney_id',$customer_contract->attorney_id)
            ->where('status','Interested')
            ->first();
                //updating payment plan
                $paymentPlan = PaymentPlan::where('customer_id',$customer_contract->customer_id)
                ->where('case_id',$customer_contract->case_id)
                ->first();
                $paymentPlan->total_amount = $attorney_bid->attorney_bid;
                $paymentPlan->save();
            //get attorney bid and update payment plan according to that ends

            $user = User::where('id',$request->customer_id)->first();

            //triggering notifications
            $notification = $this->sendNotification([$customer_contract->attorney_id],'Congratulations, You got a new contract.',null,null);

            if($user->restricted_steps == 14)
            {
                $user->restricted_steps = 17;
                $user->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Customer contract submitted successfully',
                'customer_contract' => $customer_contract,
            ], 200);

        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function scheduleAppointment(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_sr_no' => 'required',
                'customer_id' => 'required',
                'attorney_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                'case_type' => 'required',
                'summary' => 'nullable',
            ], [
                'attorney_id.required' => 'The attorney field is required.',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if($request->case_sr_no){
                $check_sr_no = CaseDetail::where('sr_no',$request->case_sr_no)->exists();
                if(!$check_sr_no){
                    return response()->json([
                        'status' => false,
                        'message' => 'Case_sr_no did not exists, kindly enter valid case_sr_no.'
                    ], 500);
                }
            }

            $appointment = new Appointment();
            $appointment->case_sr_no = $request->case_sr_no;
            $appointment->customer_id = $request->customer_id;
            $appointment->attorney_id = $request->attorney_id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->case_type = $request->case_type;
            $appointment->summary = $request->summary;
            $appointment->status = 'Approved';
            $appointment->save();

            $user = User::where('id',$request->customer_id)->first();

            //triggering notifications
            $notification = $this->sendNotification([$appointment->attorney_id],'Your appointment scheduled successfully.',null,null);

            if($user->restricted_steps == 18)
            {
                $user->restricted_steps = 20;
                $user->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Schedule appointment successfully',
                'appointment' => $appointment,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getUsersAppointments(Request $request)
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

            $appointments = Appointment::where('customer_id', $request->user_id)->where('status','Approved')->get();

            return response()->json([
                'status' => true,
                'message' => 'Fetched appointments successfully',
                'appointment' => $appointments,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function getContractDetails(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_type' => 'nullable',
                'lawyer_type' => 'nullable'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $contract = CaseContracts::where('cat_id',$request->case_type)->where('type',$request->lawyer_type)->where('status','Enable')->first();

            return response()->json([
                'status' => true,
                'message' => 'Fetched Contract successfully',
                'contract' => $contract,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function getContractCheck(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $contract_sent = null;
            $contract = CustomerContract::where('case_id',$request->case_id)->where('status','!=','Rejected')->first();

            if($contract)
            {
                $contract_sent = true;
            }else{
                $contract_sent = false;
            }

            return response()->json([
                'status' => true,
                'contract_sent' => $contract_sent,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }




}
