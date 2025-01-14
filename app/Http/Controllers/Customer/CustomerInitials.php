<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Traits\NumberGeneratorTrait;
use App\Models\Appointment;
use App\Models\AttorneyReviews;
use App\Models\CaseAttornies;
use App\Models\CaseBid;
use App\Models\CaseDetail;
use App\Models\CaseMedia;
use App\Models\Contracts;
use App\Models\CustomerContract;
use App\Models\LawCategory;
use App\Models\LawSubCategory;
use App\Models\Lawyer;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserPaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class CustomerInitials extends CustomerApplicationController
{
    use NumberGeneratorTrait;

    /**
 * Displays the profile update form for the currently authenticated user.
 *
 * @return \Illuminate\View\View The view for updating the user profile.
 */
    public function update_profile()
    {
        $userProfile = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        return view('customer.initials.update-profile',compact('userProfile'));
    }

    /**
 * Handles profile update requests for the authenticated user.
 *
 * @param \Illuminate\Http\Request $request The HTTP request object.
 * @return \Illuminate\Http\RedirectResponse Redirects to the next page or back with notifications.
 */
    public function updateProfile(Request $request)
    {
        //Validated
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'required|image|max:5120',
            'current_password' => 'nullable',
            'new_password' => 'required_with:current_password',
            'password_confirmation' => 'required_with:current_password|same:new_password'
        ]);

        try {
            $user_detail = UserDetail::where('user_id',auth()->user()->id)->firstOrNew();
            $user_detail->user_id = auth()->user()->id;
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

            $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();

            if($request->current_password)
            {
                if (Hash::check($request->current_password, $user->password)) {
                    $user->password = Hash::make($request->new_password);
                } else {
                    $notification = [
                        'message' => 'Your current password is invalid.',
                        'alert-type' => 'error'
                    ];
                    return back()->with($notification)->withInput();
                }
                $user->save();
            }

            $user_detail->save();

            if($user->restricted_steps == null)
            {
                $user->restricted_steps = 9;
                $user->save();
            }

            $alert = [
                'message' => 'Profile updated successfully.',
                'alert-type' => 'success'
            ];
            return redirect()->route('customer_application_form')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Fetches sub-categories of law based on the provided category ID.
 *
 * @param int $caseId The ID of the law category.
 * @return \Illuminate\Http\JsonResponse JSON response containing the sub-categories.
 */
    public function get_law_sub_cats($caseId)
    {
        try {
            $law_sub_cat = LawSubCategory::where('cat_id',$caseId)->get();
            return response()->json([
                'status' => true,
                'law_sub_cat' => $law_sub_cat,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Retrieves packages for a given sub-category of law.
 *
 * @param int $caseSubCatId The ID of the law sub-category.
 * @return \Illuminate\Http\JsonResponse JSON response containing the packages.
 */
    public function get_packages($caseSubCatId)
    {
        try {
            $package = Lawyer::where('sub_cat_id',$caseSubCatId)->get();
            return response()->json([
                'status' => true,
                'packages' => $package,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Displays the initial application form for customers.
 *
 * @return \Illuminate\View\View The view for the customer application form.
 */
    public function customer_application_form()
    {
        $cases = LawCategory::orderby('status','DESC')->get();
        $packages = Lawyer::where('sub_cat_id',null)->orderby('id','ASC')->get();
        return view('customer.initials.customer-application-form',compact('cases','packages'));
    }

    /**
 * Handles the submission of the customer intake application form.
 *
 * @param \Illuminate\Http\Request $request The HTTP request object.
 * @return \Illuminate\Http\JsonResponse JSON response with success or error messages.
 */
    public function customer_initial_intake_application_store_lego(Request $request)
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

        //NOTE: this controller is extended by CustomerAplicationController and these functions are there.

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

            //NOTE: this controller is extended by CustomerAplicationController and these functions are there.
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

            //updating restricted_step flag for mobile app
            $user = User::where('id',auth()->user()->id)->first();
            if($user->restricted_steps == 9)
            {
                $user->restricted_steps = 10;
                $user->save();
            }

            DB::commit();

            // Success response
            return response()->json(['success' => true, 'redirectUrl' => route('customer_payment_bid_form')]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Error response
            return response()->json(['errors' => ['exception' => $e->getMessage()]], 500);
        }
    }



/**
 * Handles the storage of a customer application.
 *
 * @param  \Illuminate\Http\Request  $request  The HTTP request containing customer application data.
 * @return \Illuminate\Http\RedirectResponse
 * @throws \Throwable If any error occurs during the transaction.
 */
    public function customer_application_store(Request $request)
    {
        //Validated
        $this->validate($request, [
            'image.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
            'video.*' => 'nullable|file|mimes:mp4,mov,avi,wmv,flv,mkv|max:102400',
            'document.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,odt,ods,txt|max:5120',

            'person_accused' => 'required|boolean',
            'convictee_name' => 'nullable|string|required_if:person_accused,0',
            'convictee_dob' => 'nullable|required_if:person_accused,0',
            'relation_with_convictee' => 'nullable|string|required_if:person_accused,0',

            'client_name' => 'required',
            'client_dob' => 'required',
            'preferred_language' => 'required',
            'court' => 'required',
            'case_number' => 'nullable',
            'charges' => 'required',
            'next_court_date' => 'nullable',
            'hearing_type' => 'required',
            'hearings_had' => 'required',
            'prior_criminal_convictions' => 'required',
            'case' => 'required',
            'case_sub_cat' => 'nullable',
            'package' => 'required',
            'application' => 'required',
            'bid' => 'required',
        ]);

        //using db transaction to avoid extra entry incase of error
        DB::beginTransaction();

        try {
            $case_detail = new CaseDetail();
            $case_detail->user_id = auth()->user()->id;

            $case_detail->sr_no = $this->uniqueNumberGenerator();

            $case_detail->client_name = $request->client_name;
            $case_detail->client_dob = $request->client_dob;
            $case_detail->preferred_language = $request->preferred_language;
            $case_detail->court_where_the_case_is_at = $request->court;
            $case_detail->case_or_citation_number = $request->case_number;
            $case_detail->charges = $request->charges;
            $case_detail->next_court_date = $request->next_court_date;
            $case_detail->type_of_hearing = $request->hearing_type;
            $case_detail->how_many_hearing_have_you_had = $request->hearings_had;
            $case_detail->list_all_prior_criminal_convictions = $request->prior_criminal_convictions;
            $case_detail->case_type = $request->case;
            $case_detail->case_sub_type = $request->case_sub_cat;
            $case_detail->package_type = $request->package;
            $case_detail->application = $request->application;
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
                    $case_media->case_id = $case_detail->id;
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
                    $case_media->case_id = $case_detail->id;
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
                   $case_media->case_id = $case_detail->id;
                   $case_media->type = 'document';
                   $case_media->media = $save_url;
                   $case_media->save();
                }
            }

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

            //storing casebid
            if ($case_detail) {

                $get_package = Lawyer::where('id',$case_detail->package_type)->first();

                if($request->bid > $get_package->max_amount)
                {
                    $alert = [
                        'message' => 'Kindly decrease case bid amount...',
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert)->withInput();
                }

                if($request->bid < $get_package->min_amount)
                {
                    $alert = [
                        'message' => 'Kindly increase case bid amount...',
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert)->withInput();
                }

                $case_bid = new CaseBid();
                $case_bid->user_id = auth()->user()->id;
                $case_bid->case_id = $case_detail->id;
                $case_bid->bid = number_format($request->bid, 2, '.', '');
                $case_bid->save();
            }


            //updating restricted_step flag for mobile app
            $user = User::where('id',auth()->user()->id)->first();
            if($user->restricted_steps == 9)
            {
                $user->restricted_steps = 10;
                $user->save();
            }

            DB::commit();

            $alert = [
                'message' => 'Application submitted successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_payment_bid_form')->with($alert);

        } catch (\Throwable $th) {
            DB::rollBack();
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert)->withInput();
        }
    }

    /**
 * Displays the payment and bid form for the customer.
 *
 * Fetches the first incomplete application for the logged-in customer
 * and the payment details to render the payment form.
 *
 * @return \Illuminate\Contracts\View\View
 */
    public function customer_payment_bid_form()
    {
        $case = CaseDetail::where('user_id',auth()->user()->id)
        ->where('application_status',null)
        ->orderby('created_at','ASC')
        ->first();
        $paymentDetails = UserPaymentDetails::where('user_id',auth()->user()->id)->where('status','Enabled')->first();
        return view('customer.initials.customer-payment-form',compact('paymentDetails','case'));
    }

    /**
 * Stores customer card information and creates a Stripe customer.
 *
 * This function creates a payment method, associates it with a Stripe customer,
 * and saves the payment details in the database.
 *
 * @param  \Illuminate\Http\Request  $request  The HTTP request containing card information.
 * @return \Illuminate\Http\RedirectResponse
 * @throws \Throwable If any error occurs during the transaction.
 */
    public function customer_card_store(Request $request)
    {
        try {
            DB::beginTransaction();

            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentMethod = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $request->stripeToken,
                ],
            ]);

            //creating customer in stripe
            $customer = Customer::create([
                'name' => $request->client_name,
                'email' => $request->client_email,
                'payment_method' => $paymentMethod->id,
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod->id,
                ],
                'description' => 'YBL Customer.',
            ]);
            //attaching payment to customer
            $paymentMethod->attach([
                'customer' => $customer->id,
            ]);

            $defaultPaymentMethodId = $customer->invoice_settings->default_payment_method;
            if ($defaultPaymentMethodId) {
                // Retrieve the PaymentMethod object
                $paymentMethod = PaymentMethod::retrieve($defaultPaymentMethodId);
                // Get the card details
                $card = $paymentMethod->card;
            }

            $userPaymentDetails = new UserPaymentDetails();
            $userPaymentDetails->user_id = auth()->user()->id;
            $userPaymentDetails->stripe_customer_id = $customer->id;
            $userPaymentDetails->card_expiry_month = isset($card) ? $card->exp_month : null;
            $userPaymentDetails->card_expiry_year = isset($card) ? $card->exp_year: null;
            $userPaymentDetails->card_last_four =isset($card) ? $card->last4: null;
            $userPaymentDetails->json_response = isset($card) ? $card: null;
            $userPaymentDetails->status = 'Enabled';
            $userPaymentDetails->save();

            DB::commit();

            //sending email
            $this->sendEmail(
                auth()->user()->email,
                'Card attached successfully.',
                'Your card has been attached to YBL successfully.'
            );

            $alert = [
                'message' => 'Your card has been added successfully.',
                'alert-type' => 'success'
            ];
            return back()->with($alert);

        } catch (\Throwable $th) {

            DB::rollBack();

            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Store the payment bid details for the customer.
 *
 * This function updates the user's restricted steps and redirects
 * the customer to the payment plans page with a success message.
 *
 * @param Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
    public function customer_payment_bid_store(Request $request)
    {
        try {

            $user = User::where('id',auth()->user()->id)->first();
            if($user->restricted_steps == 10)
            {
                $user->restricted_steps = 11;
                $user->save();
            }

            $alert = [
                'message' => 'Payment details added successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_payment_plans')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Display the payment plans available to the customer.
 *
 * Fetches the case details and associated installment information,
 * and displays the customer payment plans page.
 *
 * @return \Illuminate\Contracts\View\View
 */
    public function customer_payment_plans()
    {
        $case = CaseDetail::with('getCasePackage')
        ->where('user_id',auth()->user()->id)
        ->where('application_status',null)
        ->orderby('created_at','ASC')
        ->first();
        $installments = $case->getCaseLawSub->installments;
        return view('customer.initials.customer-payment-plans',compact('case','installments'));
    }

    /**
 * Store the customer's selected payment plan.
 *
 * Validates the customer's input, handles the creation of payment plans
 * and transactions, and updates user and case details. Ensures data
 * integrity using transactions.
 *
 * @param Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
    public function customer_payment_plans_store(Request $request)
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

            $user = User::where('id',auth()->user()->id)->first();
            if($user->restricted_steps == 11)
            {
                $user->restricted_steps = 12;
                $user->save();
            }

            // Commit the transaction
            DB::commit();

            $alert = [
                'message' => 'Payment plan submitted successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_preview')->with($alert);

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
 * Display the customer's application preview page.
 *
 * Fetches the customer's profile, application details,
 * payment plan, and dynamic form data for preview.
 *
 * @return \Illuminate\Contracts\View\View
 */
    public function customer_preview()
    {
        $profile = User::with('getUserDetails')
        ->where('id',auth()->user()->id)
        ->first();

        $application = CaseDetail::with('getCaseMedia','getCaseBid','getCaseLaw','getCaseLawSub','getCasePackage','getDynamicFormValues')
        ->where('user_id',auth()->user()->id)
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

        return view('customer.initials.customer-preview',compact('profile','application','paymentPlan','installment_amount','dynamicForms'));
    }

    /**
 * Handles customer case submission and updates the application and case status.
 *
 * @param Request $request The incoming HTTP request.
 * @return \Illuminate\Http\RedirectResponse Redirects to the thank you page on success or back with an error message on failure.
 */
    public function customer_case_submit(Request $request)
    {
        try {
            //fetch profile data
            $user = User::where('id',auth()->user()->id)->first();
            //fetch case data
            $case_data = CaseDetail::where('user_id',$user->id)->update(['application_status'=>'Accepted','case_status'=>'Pending']);

            if($user->restricted_steps == 12)
            {
                $user->restricted_steps = 13;
                $user->save();
            }

            $alert = [
                'message' => 'Application submitted successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_thankyou')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Displays the customer thank you page.
 *
 * @return \Illuminate\View\View Returns the thank you page with user and case data.
 */
    public function customer_thankyou()
    {
        $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        $case = CaseDetail::where('user_id',$user->id)->first();
        return view('customer.initials.customer-thankyou',compact('user','case'));
    }

/**
 * Fetches and displays a list of attorneys interested in a specific case.
 *
 * @param int $case_id The ID of the case.
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse The view with interested attorneys or an error response.
 */
    public function hired_attornies($case_id)
    {
        try {
            //fetch attornies data
            $interstedAttornies= CaseAttornies::with('getAttornies.getUserDetails','getAttornies.getRatings','getCaseDetails.getCaseBid')
            ->where('case_id',$case_id)
            ->where('status','Interested')
            ->get();

            $interstedAttornies->each(function ($attorney) {
                $ratings = $attorney->getAttornies->getRatings;
                $average_rating = $ratings->avg('rating');
                $attorney->average_ratings = round($average_rating);
            });

            return view('customer.initials.initial-hired-attornies',compact('interstedAttornies'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Displays details for a specific hired attorney.
 *
 * @param int $attorney_id The ID of the attorney.
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse The view with attorney details or an error response.
 */
    public function hired_attornies_details($attorney_id)
    {
        try {
            $interstedAttornies= CaseAttornies::where('id',$attorney_id)->first();
            //fetch attornies data
            $attorney = User::with('getUserDetails','getCaseCounts')->where('id',$interstedAttornies->attorney_id)->first();

            $ratings = $attorney->getRatings;
            $average_rating = round($ratings->avg('rating'));

            // Add the average_ratings field to the array
            $attorney['average_ratings'] = $average_rating;
            $attorneyReviews = AttorneyReviews::where('attorney_id',$attorney->id)->first();

            return view('customer.initials.initial-attornies-details',compact('attorney','interstedAttornies','attorneyReviews'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Displays the contract details for a specific attorney-case relationship.
 *
 * @param int $case_attorney_id The ID of the case-attorney relationship.
 * @return \Illuminate\View\View The view with contract details.
 */
    public function contracts($case_attorney_id)
    {
        $contract = CaseAttornies::with('getAttornies.getUserDetails','getCaseDetails.getCaseAttornies')
        ->where('id',$case_attorney_id)
        ->first();
        $getLawContract = Contracts::first();
        $paymentPlan = PaymentPlan::where('customer_id',auth()->user()->id)
        ->where('case_id',$contract->getCaseDetails->id)
        ->where('status','Enabled')
        ->where('payment_status','Unpaid')
        ->first();
        $getAttorneyBid = CaseAttornies::where('case_id',$contract->getCaseDetails->id)
        ->where('attorney_id',$contract->getAttornies->id)
        ->where('status','Interested')
        ->first();

        return view('customer.initials.initial-contract',compact('contract','getLawContract','paymentPlan','getAttorneyBid'));
    }

    /**
 * Stores customer contract data and updates related entities such as payment plans.
 *
 * @param Request $request The incoming HTTP request containing contract data.
 * @return \Illuminate\Http\RedirectResponse Redirects to the thank you page on success or back with an error message on failure.
 */
    public function customer_contracts_store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'attorney_id' => 'required',
            'case_id' => 'required',
            'contract_date' => 'required',
            'contract_id' => 'required',
            'customer_signature' => 'required|string',
            'agree_terms_and_conditions'=> 'required'
            ], [
                'customer_signature.required' => 'Please provide your signature and click on confirm button.',
                'agree_terms_and_conditions.required' => 'Please check agree terms and conditions.',
            ]);
        try {
            $customer_contract = new CustomerContract();
            $customer_contract->customer_id = $request->customer_id;
            $customer_contract->attorney_id = $request->attorney_id;
            $customer_contract->case_id = $request->case_id;
            $customer_contract->contract_id = $request->contract_id;
            $customer_contract->contract_date = $request->contract_date;

            if ($request->customer_signature) {
                // Extract base64 image data from the request
                $base64Image = preg_replace('/data:image\/(jpeg|jpg|png);base64,/', '', $request->customer_signature);
                // Decode the base64 image data
                $signature_image = base64_decode($base64Image);
                // Generate a unique filename for the image
                $filename = hexdec(uniqid()) . '.png';
                // Define the upload location relative to public directory
                $upload_location = '/storage/customer-contract-signatures/';
                // Save the image file to the specified upload location
                $file_path = public_path() . $upload_location . $filename;
                file_put_contents($file_path, $signature_image);
                // Save the URL to the signature image in the database or use as needed
                $save_url = $upload_location . $filename;
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

            if($user->restricted_steps == 14)
            {
                $user->restricted_steps = 17;
                $user->save();
            }

            //sending email
            $this->sendEmail(
                $customer_contract->getAttornies->email,
                'New YourBestLawyer.com Contract Received',
                'A customer has sent you a contract. Please review and take the necessary actions.'
            );

            $alert = [
                'message' => 'Contract submitted successfully',
                'alert-type' => 'success'
            ];
            return to_route('customer_contract_thank_you')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

/**
 * Displays the thank you page after contract submission.
 *
 * @return \Illuminate\View\View The view with user data.
 */
    public function customer_contract_thank_you()
    {
        $user = User::where('id',auth()->user()->id)->first();
        return view('customer.initials.customer-contract-thank-you',compact('user'));
    }

/**
 * Store a customer-scheduled appointment in the database.
 *
 * @param Request $request The incoming request object containing appointment details.
 * @return \Illuminate\Http\RedirectResponse Redirects to the customer dashboard with a success or error alert.
 */
    public function customer_schedule_appointment_store(Request $request)
    {
            $this->validate($request, [
                'case_sr_no' => 'required',
                'customer_id' => 'nullable',
                'attorney_id' => 'nullable',
                'date' => 'required',
                'time' => 'required',
                'case_type' => 'nullable',
                'summary' => 'nullable',
                ], [
                    'attorney_id.required' => 'The attorney field is required.',
                ]);

        try {

            $appointment = new Appointment();
            $appointment->case_sr_no = $request->case_sr_no;
            $appointment->customer_id = auth()->user()->id;
            $appointment->attorney_id = $request->attorney_id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->case_type = $request->case_type;
            $appointment->summary = $request->summary;
            $appointment->status = 'Approved';
            $appointment->save();

            $user = User::where('id',auth()->user()->id)->first();

            if($user->restricted_steps == 18)
            {
                $user->restricted_steps = 20;
                $user->save();
            }

            //sending email
            $this->sendEmail(
                $appointment->getAttornies->email,
                'New Appointment',
                'A customer has set an appointment. Please check your calendar for details.'
            );

            $alert = [
                'message' => 'appointment submitted successfully',
                'alert-type' => 'success'
            ];
            return to_route('customer_dashboard')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

/**
 * Display the application steps page.
 *
 * @return \Illuminate\View\View Renders the application steps view.
 */
    public function application_steps()
    {
        return view('customer.initials.application-steps');
    }
/**
 * Display the schedule page.
 *
 * @return \Illuminate\View\View Renders the schedule view.
 */
    public function schedule()
    {
        return view('customer.initials.schedule');
    }

    /**
 * Display the schedule appointment page with cases data.
 *
 * @return \Illuminate\View\View|RedirectResponse Renders the schedule appointment view or redirects back on error.
 */
    public function schedule_appointment()
    {
        try{

            $cases = CaseDetail::with('getCaseLaw','getCaseAttornies')
            ->where('user_id', auth()->user()->id)
            ->where('case_status','Accepted')
            ->orderby('id','ASC')
            ->get();

            return view('customer.initials.initial-schedule-appointment',compact('cases'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Fetch appointment details for a specific case.
 *
 * @param Request $request The incoming request containing case serial number and customer ID.
 * @return \Illuminate\Http\JsonResponse JSON response with appointment details or error message.
 */

    public function get_appointment_details(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_sr_no' => 'required',
                'customer_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $case = CaseDetail::where('sr_no', $request->case_sr_no)->first();

            $details = CustomerContract::with([
                'getCaseDetail.getCaseLaw',
                'getAttornies.getUserDetails'
            ])
            ->where('case_id', $case->id)
            ->where('customer_id', auth()->user()->id)
            ->first();

            if ($details && $case) {
                $attorney = $details->getAttornies->getUserDetails;
                $caseDetail = $details->getCaseDetail->getCaseLaw;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'appointee_id' => $attorney->user_id,
                        'appointee' => $attorney->first_name . ' ' . $attorney->last_name,
                        'case_type' => $caseDetail->title,
                    ]
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Case not found']);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
