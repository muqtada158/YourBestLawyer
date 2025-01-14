<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Traits\NumberGeneratorTrait;
use App\Models\CaseBid;
use App\Models\CaseDetail;
use App\Models\CaseMedia;
use App\Models\DynamicForms;
use App\Models\DynamicFormValues;
use App\Models\LawCategory;
use App\Models\Lawyer;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserPaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerApplicationController extends Controller
{
    use NumberGeneratorTrait;
/**
 * Display applications based on the filter (Accepted, Pending, Rejected).
 *
 * @param string|null $filter The status of the application to filter by (Accepted, Pending, Rejected).
 * @return \Illuminate\View\View The view showing the filtered applications.
 */
    public function applications($filter = null)
    {
        try {
            $user_id = auth()->user()->id;
            if(isset($filter) && $filter == "Accepted")
            {
                $applications = CaseDetail::with('getCaseMedia','getCaseLaw','getCaseLawSub','getCasePackage')
                ->where('user_id', $user_id)
                ->where('application_status','Accepted')
                ->orderby('id','DESC')
                ->paginate(10);

                return view('customer.applications',compact('applications'));
            }

            if(isset($filter) && $filter == "Pending")
            {
                $applications = CaseDetail::with('getCaseMedia','getCaseLaw','getCaseLawSub','getCasePackage')
                ->where('user_id', $user_id)
                ->where('application_status','Pending')
                ->orderby('id','DESC')
                ->paginate(10);

                return view('customer.applications',compact('applications'));
            }

            if(isset($filter) && $filter == "Rejected")
            {
                $applications = CaseDetail::with('getCaseMedia','getCaseLaw','getCaseLawSub','getCasePackage')
                ->where('user_id', $user_id)
                ->where('application_status','Rejected')
                ->orderby('id','DESC')
                ->paginate(10);

                return view('customer.applications',compact('applications'));
            }

            $applications = CaseDetail::with('getCaseMedia','getCaseLaw','getCaseLawSub','getCasePackage')
            ->where('user_id', $user_id)
            ->where('application_status','!=',null)
            ->paginate(10);

            return view('customer.applications',compact('applications'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Display the details of a specific application.
 *
 * @param int $application_id The ID of the application to fetch.
 * @return \Illuminate\View\View The view showing the application details.
 */
    public function detail_application($application_id)
    {
        try {
            $profile = User::with('getUserDetails')
            ->where('id',auth()->user()->id)
            ->first();

            $application = CaseDetail::with('getCaseMedia','getCaseBid','getCaseLaw','getCaseLawSub','getCasePackage','getDynamicFormValues')
            ->where('id',$application_id)
            ->first();

            $dynamicForms = null;
            if($application->getDynamicFormValues)
            {
                $dynamicForms = json_decode($application->getDynamicFormValues->form_values);
            }

            $paymentPlan = PaymentPlan::where('customer_id',$profile->id)
            ->where('case_id',$application->id)
            ->where('customer_id',auth()->user()->id)
            ->where('status','Enabled')
            ->orderby('created_at','ASC')
            ->first();

            $installment_amount = 0;
            if($paymentPlan->installments === "yes")
            {
                $installment_amount = round(($application->getCaseBid->bid - $paymentPlan->getTransactionDownpayment->amount) / $paymentPlan->installment_cycle);
            }
            return view('customer.application-details',compact('application','paymentPlan','installment_amount','dynamicForms'));
        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Delete an application, ensuring that accepted applications cannot be deleted.
 *
 * @param int $id The ID of the application to delete.
 * @return \Illuminate\Http\RedirectResponse Redirect back with a success or error message.
 */
    public function customer_delete_application($id)
    {
        try {

            $application = CaseDetail::findOrFail($id);
            if($application->case_status == 'Accepted')
            {
                $alert = [
                    'message' => "This application's case accepted already, and cannot be deleted.",
                    'alert-type' => 'error'
                ];
                return back()->with($alert);
            }

            $application->delete();
            $alert = [
                'message' => "Application Deleted Successfully.",
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
/**
 * Show the form for adding a new application.
 *
 * @return \Illuminate\View\View The view for adding a new application.
 */
    public function add_application()
    {
        $cases = LawCategory::orderby('status','DESC')->get();
        $packages = Lawyer::where('sub_cat_id',null)->orderby('id','ASC')->get();
        return view('customer.application-add.application-step-1',compact('cases','packages'));
    }
/**
 * Fetch dynamic form fields based on the selected case category.
 *
 * @param int $caseId The ID of the case category.
 * @return \Illuminate\Http\JsonResponse The dynamic form fields or error message.
 */
    public function dynamic_forms($caseId)
    {
        try {
            $form = DynamicForms::where('case_cat_id', $caseId)->first();

            if ($form) {
                return response()->json([
                    'success' => true,
                    'form' => json_decode($form->form)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Form not found.'
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error :'.$th->getMessage()
            ]);
        }
    }

/**
 * Store the intake application and handle related media uploads and validation.
 *
 * @param \Illuminate\Http\Request $request The request containing the application data.
 * @return \Illuminate\Http\JsonResponse Success or error response.
 */

    public function customer_dashboard_intake_application_store_lego(Request $request)
    {
        // Validation rules
        $rules = [
            'image.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
            'video.*' => 'nullable|file|mimes:mp4,mov,avi,wmv,flv,mkv|max:102400',
            'document.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,odt,ods,txt|max:5120',
            'case' => 'required',
            'case_sub_cat' => 'required',
            'package' => 'required',
            'bid' => 'required',
            'person_accused' => 'required|boolean',
            'convictee_name' => 'nullable|string|required_if:person_accused,0',
            'convictee_dob' => 'nullable|required_if:person_accused,0',
            'relation_with_convictee' => 'nullable|string|required_if:person_accused,0',
        ];

        // Handle validations
        $rules = array_merge($rules, $this->handleIntakeFormValidation($request)); //merging both arrays

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            // Save case detail
            $case_detail = new CaseDetail();
            $case_detail->user_id = auth()->user()->id;
            $case_detail->sr_no = $this->uniqueNumberGenerator();
            $case_detail->case_type = $request->case;
            $case_detail->case_sub_type = $request->case_sub_cat;
            $case_detail->package_type = $request->package;
            $case_detail->application_status = null;
            $case_detail->case_status = null;
            $case_detail->is_same_person = $request->person_accused;
            if($request->person_accused == 0)
            {
                $case_detail->convictee_name = $request->convictee_name;
                $case_detail->convictee_dob = $request->convictee_dob;
                $case_detail->convictee_relationship = $request->relation_with_convictee;
            }
            $case_detail->save();

            // Handle media uploads
            $this->handleMediaUploads($request, $case_detail->id);

            // Set lawyerType
            $this->setLawyerType($case_detail);

            // Handle case bid
            $bidErrors = $this->handleCaseBid($request, $case_detail);
            if ($bidErrors) {
                DB::rollBack(); // Rollback transaction if there are bid validation errors
                return response()->json(['errors' => $bidErrors], 422); // Return bid validation errors
            }

            // Store form values
            $this->storeFormValues($request, $case_detail);

            // Commit transaction
            DB::commit();

            // Check if the session 'case_sr_no' exists
            if (Session::has('case_sr_no')) {
                // Remove the existing session
                Session::forget('case_sr_no');
            }
            // Add the new session value
            Session::put('case_sr_no', $case_detail->sr_no);

            // Success response
            return response()->json(['success' => true, 'redirectUrl' => route('customer_dashboard_payment_bid_form')]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Error response
            return response()->json(['errors' => ['exception' => $e->getMessage()]], 500);
        }
    }

    /**
 * Handles the upload of media files (images, videos, documents) and saves them to the database.
 *
 * @param \Illuminate\Http\Request $request The incoming request object containing media files.
 * @param int $caseId The ID of the case to associate the media with.
 * @return void
 */
    public function handleMediaUploads($request, $caseId) {
        // Upload and save media files
        if ($request->hasFile('image')) {
            foreach ($request->image as $key => $image) {
                /** Upload new image */
                $upload_location = '/storage/case_media/';
                $file = $image;
                $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . $upload_location, $name_gen);
                $save_url = $upload_location . $name_gen;

                /** Saving in DB */
                $case_media = new CaseMedia();
                $case_media->user_id = auth()->user()->id;
                $case_media->case_id = $caseId;
                $case_media->type = 'image';
                $case_media->media = $save_url;
                $case_media->save();
            }
        }

        if ($request->hasFile('video')) {
            foreach ($request->video as $key => $video) {
                /** Upload new video */
                $upload_location = '/storage/case_media/';
                $file = $video;
                $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . $upload_location, $name_gen);
                $save_url = $upload_location . $name_gen;

                /** Saving in DB */
                $case_media = new CaseMedia();
                $case_media->user_id = auth()->user()->id;
                $case_media->case_id = $caseId;
                $case_media->type = 'video';
                $case_media->media = $save_url;
                $case_media->save();
            }
        }

        if ($request->hasFile('document')) {
            foreach ($request->document as $key => $image) {
               /** Upload new document */
               $upload_location = '/storage/case_media/';
               $file = $image;
               $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
               $file->move(public_path() . $upload_location, $name_gen);
               $save_url = $upload_location . $name_gen;

               /** Saving in DB */
               $case_media = new CaseMedia();
               $case_media->user_id = auth()->user()->id;
               $case_media->case_id = $caseId;
               $case_media->type = 'document';
               $case_media->media = $save_url;
               $case_media->save();
            }
        }
    }
/**
 * Sets the lawyer type for a given case detail based on the associated package.
 *
 * @param \App\Models\CaseDetail $caseDetail The case details for which the lawyer type is being set.
 * @return void
 */
    public function setLawyerType($caseDetail) {
        $package = $caseDetail->getCasePackage()->first();
        if ($package) {
            switch ($package->title) {
                case 'Novice':
                    $caseDetail->lawyer_type = 1;
                    break;
                case 'Experienced':
                    $caseDetail->lawyer_type = 2;
                    break;
                case 'Top Notch':
                    $caseDetail->lawyer_type = 3;
                    break;
            }
            $caseDetail->save();
        }
    }
/**
 * Handles the case bid validation and storage.
 *
 * @param \Illuminate\Http\Request $request The incoming request object containing the bid data.
 * @param \App\Models\CaseDetail $caseDetail The case for which the bid is being placed.
 * @return mixed|null Returns validation errors or null if validation passes.
 */

    public function handleCaseBid($request, $caseDetail)
    {
        $get_package = Lawyer::where('id', $caseDetail->package_type)->first();
        $rules = [
            'bid' => [
                'required',
                'numeric',
                'min:' . $get_package->min_amount,
                'max:' . $get_package->max_amount,
            ]
        ];

        // Define custom messages
        $messages = [
            'bid.min' => 'Kindly increase case bid amount.',
            'bid.max' => 'Kindly decrease case bid amount.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }
        // Proceed with saving the case bid if validation passes
        $case_bid = new CaseBid();
        $case_bid->user_id = auth()->user()->id;
        $case_bid->case_id = $caseDetail->id;
        $case_bid->bid = number_format($request->bid, 2, '.', '');
        $case_bid->save();

        return null; // Return null if there are no errors
    }

/**
 * Stores form values for a given case detail in the database.
 *
 * @param \Illuminate\Http\Request $request The incoming request object containing form data.
 * @param \App\Models\CaseDetail $caseDetail The case to store the form values for.
 * @return void
 */

    public function storeFormValues($request, $caseDetail) {
        $formValueData = $this->getFormValueData($request);

        $store = new DynamicFormValues();
        $store->case_id = $caseDetail->id;
        $store->user_id = $caseDetail->user_id;
        $store->form_values = json_encode($formValueData);
        $store->status = 'Enabled';
        $store->save();
    }
/**
 * Validates the intake form based on the selected case type.
 *
 * @param \Illuminate\Http\Request $request The incoming request object containing case data.
 * @return array Validation rules for the intake form based on the case type.
 */
    public function handleIntakeFormValidation($request) {
        switch ($request->case) {
            case 1: // Family Law
                return [
                    'person_accused' => 'required|boolean',
                    'convictee_name' => 'nullable|string|required_if:person_accused,0',
                    'convictee_dob' => 'nullable|required_if:person_accused,0',
                    'relation_with_convictee' => 'nullable|string|required_if:person_accused,0',
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
        switch ($request->case) {
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





    // public function customer_dashboard_application_store(Request $request)
    // {
    //     //Validated
    //     $this->validate($request, [
    //         'image.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
    //         'video.*' => 'nullable|file|mimes:mp4,mov,avi,wmv,flv,mkv|max:102400',
    //         'document.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,odt,ods,txt|max:5120',

    //         'person_accused' => 'required|boolean',
    //         'convictee_name' => 'nullable|string|required_if:person_accused,0',
    //         'convictee_dob' => 'nullable|required_if:person_accused,0',
    //         'relation_with_convictee' => 'nullable|string|required_if:person_accused,0',

    //         'client_name' => 'required',
    //         'client_dob' => 'required',
    //         'preferred_language' => 'required',
    //         'court' => 'required',
    //         'case_number' => 'nullable',
    //         'charges' => 'required',
    //         'next_court_date' => 'nullable',
    //         'hearing_type' => 'required',
    //         'hearings_had' => 'required',
    //         'prior_criminal_convictions' => 'required',
    //         'case' => 'required',
    //         'case_sub_cat' => 'nullable',
    //         'package' => 'required',
    //         'application' => 'required',
    //         'bid' => 'required',
    //     ]);

    //     //using db transaction to avoid extra entry incase of error
    //     DB::beginTransaction();

    //     try {
    //         $case_detail = new CaseDetail();
    //         $case_detail->user_id = auth()->user()->id;

    //         $case_detail->sr_no = $this->uniqueNumberGenerator();

    //         $case_detail->client_name = $request->client_name;
    //         $case_detail->client_dob = $request->client_dob;
    //         $case_detail->preferred_language = $request->preferred_language;
    //         $case_detail->court_where_the_case_is_at = $request->court;
    //         $case_detail->case_or_citation_number = $request->case_number;
    //         $case_detail->charges = $request->charges;
    //         $case_detail->next_court_date = $request->next_court_date;
    //         $case_detail->type_of_hearing = $request->hearing_type;
    //         $case_detail->how_many_hearing_have_you_had = $request->hearings_had;
    //         $case_detail->list_all_prior_criminal_convictions = $request->prior_criminal_convictions;
    //         $case_detail->case_type = $request->case;
    //         $case_detail->case_sub_type = $request->case_sub_cat;
    //         $case_detail->package_type = $request->package;
    //         $case_detail->application = $request->application;
    //         $case_detail->application_status = null;
    //         $case_detail->case_status = null;

    //         $case_detail->is_same_person = $request->person_accused;
    //         if($request->person_accused == 0)
    //         {
    //             $case_detail->convictee_name = $request->convictee_name;
    //             $case_detail->convictee_dob = $request->convictee_dob;
    //             $case_detail->convictee_relationship = $request->relation_with_convictee;
    //         }

    //         $case_detail->save();

    //         if ($request->hasFile('image')) {
    //             foreach ($request->image as $key => $image) {
    //                 /** Upload new image */
    //                 $upload_location = '/storage/case_media/';
    //                 $file = $image;
    //                 $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path() . $upload_location, $name_gen);
    //                 $save_url = $upload_location . $name_gen;

    //                 /** Saving in DB */
    //                 $case_media = new CaseMedia();
    //                 $case_media->user_id = auth()->user()->id;
    //                 $case_media->case_id = $case_detail->id;
    //                 $case_media->type = 'image';
    //                 $case_media->media = $save_url;
    //                 $case_media->save();
    //             }
    //         }

    //         if ($request->hasFile('video')) {
    //             foreach ($request->video as $key => $video) {
    //                 /** Upload new video */
    //                 $upload_location = '/storage/case_media/';
    //                 $file = $video;
    //                 $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path() . $upload_location, $name_gen);
    //                 $save_url = $upload_location . $name_gen;

    //                 /** Saving in DB */
    //                 $case_media = new CaseMedia();
    //                 $case_media->user_id = auth()->user()->id;
    //                 $case_media->case_id = $case_detail->id;
    //                 $case_media->type = 'video';
    //                 $case_media->media = $save_url;
    //                 $case_media->save();
    //             }
    //         }

    //         if ($request->hasFile('document')) {
    //             foreach ($request->document as $key => $image) {
    //                /** Upload new document */
    //                $upload_location = '/storage/case_media/';
    //                $file = $image;
    //                $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
    //                $file->move(public_path() . $upload_location, $name_gen);
    //                $save_url = $upload_location . $name_gen;

    //                /** Saving in DB */
    //                $case_media = new CaseMedia();
    //                $case_media->user_id = auth()->user()->id;
    //                $case_media->case_id = $case_detail->id;
    //                $case_media->type = 'document';
    //                $case_media->media = $save_url;
    //                $case_media->save();
    //             }
    //         }

    //         //setting lawyerType in case detail table for case feed
    //         $package = $case_detail->getCasePackage()->first();
    //         if ($package) {
    //             switch ($package->title) {
    //                 case 'Novice':
    //                     $case_detail->lawyer_type = 1;
    //                     break;
    //                 case 'Experienced':
    //                     $case_detail->lawyer_type = 2;
    //                     break;
    //                 case 'Top Notch':
    //                     $case_detail->lawyer_type = 3;
    //                     break;
    //             }
    //             $case_detail->save();
    //         }

    //         //storing casebid
    //         if ($case_detail) {

    //             $get_package = Lawyer::where('id',$case_detail->package_type)->first();

    //             if($request->bid > $get_package->max_amount)
    //             {
    //                 $alert = [
    //                     'message' => 'Kindly decrease case bid amount...',
    //                     'alert-type' => 'error'
    //                 ];
    //                 return back()->with($alert)->withInput();
    //             }

    //             if($request->bid < $get_package->min_amount)
    //             {
    //                 $alert = [
    //                     'message' => 'Kindly increase case bid amount...',
    //                     'alert-type' => 'error'
    //                 ];
    //                 return back()->with($alert)->withInput();
    //             }

    //             $case_bid = new CaseBid();
    //             $case_bid->user_id = auth()->user()->id;
    //             $case_bid->case_id = $case_detail->id;
    //             $case_bid->bid = number_format($request->bid, 2, '.', '');
    //             $case_bid->save();
    //         }

    //         // Check if the session 'case_sr_no' exists
    //         if (Session::has('case_sr_no')) {
    //             // Remove the existing session
    //             Session::forget('case_sr_no');
    //         }
    //         // Add the new session value
    //         Session::put('case_sr_no', $case_detail->sr_no);

    //         DB::commit();

    //         $alert = [
    //             'message' => 'Application submitted successfully.',
    //             'alert-type' => 'success'
    //         ];

    //         return to_route('customer_dashboard_payment_bid_form')->with($alert);

    //     } catch (\Throwable $th) {

    //         DB::rollBack();
    //         $alert = [
    //             'message' => 'Error :'.$th->getMessage(),
    //             'alert-type' => 'error'
    //         ];
    //         return back()->with($alert);
    //     }
    // }


        /**
     * Display the payment bid form for the customer dashboard.
     *
     * Retrieves the case details and payment information for the logged-in user
     * and passes it to the view for rendering the payment bid form.
     *
     * @return \Illuminate\View\View
     */
    public function customer_dashboard_payment_bid_form()
    {
        $case = CaseDetail::where('user_id',auth()->user()->id)
        ->where('sr_no',session()->get('case_sr_no'))
        ->where('application_status',null)
        ->first();
        $paymentDetails = UserPaymentDetails::where('user_id',auth()->user()->id)->where('status','Enabled')->first();
        return view('customer.application-add.application-step-2',compact('paymentDetails','case'));
    }
    /**
     * Store the payment bid details for the customer dashboard.
     *
     * This method handles the storage of payment bid details after the user
     * submits the payment bid form. It includes error handling and success messages.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function customer_dashboard_payment_bid_store(Request $request)
    {
        try {

            $alert = [
                'message' => 'Payment details added successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_dashboard_payment_plan')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    /**
     * Display the payment plans for the customer dashboard.
     *
     * Retrieves the case details along with the payment plan installment options
     * and passes them to the view for rendering.
     *
     * @return \Illuminate\View\View
     */
    public function customer_dashboard_payment_plans()
    {
        $case = CaseDetail::with('getCasePackage')
        ->where('user_id',auth()->user()->id)
        ->where('sr_no',session()->get('case_sr_no'))
        ->where('application_status',null)
        ->first();
        $installments = $case->getCaseLawSub->installments;
        return view('customer.application-add.application-step-3-payment-plan',compact('case','installments'));
    }
    /**
     * Store the payment plan details for the customer dashboard.
     *
     * This method handles the creation and validation of the payment plan, including
     * the downpayment and installment cycle. It processes the data and commits it to
     * the database, handling any errors with transaction rollback.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function customer_dashboard_payment_plans_store(Request $request)
    {
        // Validated
        $this->validate($request, [
            'payment_plan' => 'required|in:yes,no',
            'payment_cycle' => 'required_if:payment_plan,yes|nullable',
            'downpayment'  => 'required_if:payment_plan,yes|nullable',
        ]);
        try {
            // Begin a transaction
            DB::beginTransaction();

            $case = CaseDetail::where('user_id',auth()->user()->id)
            ->where('sr_no',session()->get('case_sr_no'))
            ->where('application_status',null)
            ->orderby('created_at','ASC')
            ->first();

            $case_payment_plan = new PaymentPlan();
            $case_payment_plan->customer_id = auth()->user()->id;
            $case_payment_plan->case_id = $case->id;
            $case_payment_plan->sub_cat_id = $case->getCaseLawSub->id;
            $case_payment_plan->package_id = $case->getCasePackage->id;
            $case_payment_plan->invoice_no = null;
            $case_payment_plan->total_amount = $case->getCaseBid->bid;
            $case_payment_plan->installments = $request->payment_plan;
            $case_payment_plan->installment_cycle = isset($request->payment_cycle) ? $request->payment_cycle : null;
            $case_payment_plan->status = 'Enabled';
            $case_payment_plan->payment_status = 'Unpaid';
            $case_payment_plan->save();


            if($case_payment_plan->installments == "yes")
            {

                $min_bid_amount = $case->getCasePackage->min_amount / 2;
                $max_bid_amount = $case->getCasePackage->min_amount * 0.90;

                if($request->downpayment < $min_bid_amount)
                {
                    $alert = [
                        'message' => 'Your downpayment is lower than 50% of selected package mininum amount.',
                        'alert-type' => 'error'
                    ];
                    DB::rollBack();
                    return back()->with($alert)->withInput();
                }
                if($request->downpayment > $max_bid_amount)
                {
                    $alert = [
                        'message' => 'Your downpayment is higher than 90% of selected package maximum amount.',
                        'alert-type' => 'error'
                    ];
                    DB::rollBack();
                    return back()->with($alert)->withInput();
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
                $transaction->amount = (int)$case->getCaseBid->bid;
                $transaction->date_of_charge = null;
                $transaction->status = 'Pending';
                $transaction->save();
            }

            // Commit the transaction
            DB::commit();

            $alert = [
                'message' => 'Payment plan submitted successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_dashboard_preview')->with($alert);

        } catch (\Throwable $th) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            $alert = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    /**
     * Display the customer dashboard preview.
     *
     * Retrieves the necessary data (profile, application, payment plan, etc.)
     * and passes them to the view for rendering the preview.
     *
     * @return \Illuminate\View\View
     */
    public function customer_dashboard_preview()
    {
        $profile = User::with('getUserDetails')
        ->where('id',auth()->user()->id)
        ->first();

        $application = CaseDetail::with('getCaseMedia','getCaseBid','getCaseLaw','getCaseLawSub','getCasePackage','getDynamicFormValues')
        ->where('user_id',auth()->user()->id)
        ->where('sr_no',session()->get('case_sr_no'))
        ->where('application_status',null)
        ->where('case_status',null)
        ->first();

        $dynamicForms = null;
        if($application->getDynamicFormValues)
        {
            $dynamicForms = json_decode($application->getDynamicFormValues->form_values);
        }

        $paymentPlan = PaymentPlan::where('customer_id',$profile->id)
        ->where('case_id',$application->id)
        ->where('customer_id',auth()->user()->id)
        ->where('status','Enabled')
        ->orderby('created_at','ASC')
        ->first();

        $installment_amount = 0;
        if($paymentPlan->installments === "yes")
        {
            $installment_amount = round(($application->getCaseBid->bid - $paymentPlan->getTransactionDownpayment->amount) / $paymentPlan->installment_cycle);
        }

        return view('customer.application-add.application-step-3',compact('profile','application','paymentPlan','installment_amount','dynamicForms'));
    }
    /**
     * Submit the case for the customer.
     *
     * Updates the case status to "Accepted" and case status to "Pending"
     * after the customer submits their application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function customer_dashboard_case_submit(Request $request)
    {
        try {
            //fetch profile data
            $user = User::where('id',auth()->user()->id)->first();
            //fetch case data
            $latestCaseDetail = CaseDetail::where('user_id', $user->id)
                ->latest()
                ->first();

            if ($latestCaseDetail) {
                // Update only the latest row
                $latestCaseDetail->application_status = "Accepted";
                $latestCaseDetail->case_status = "Pending";
                $latestCaseDetail->save();
            }

            $alert = [
                'message' => 'Application submitted successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_dashboard_thankyou')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    public function customer_dashboard_thankyou()
    {
        $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        $case = CaseDetail::where('user_id',$user->id)->first();
        return view('customer.application-add.application-step-4',compact('user','case'));
    }

    public function application_initial_process()
    {
        return view('customer.application-initial-process');
    }
}
