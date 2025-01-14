<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Http\Traits\EmailTrait;
use App\Models\AttorneyAgreement;
use App\Models\AttorneyApplication;
use App\Models\AttorneyMedia;
use App\Models\AttorneyTermsAndCondition;
use App\Models\AttorneyType;
use App\Models\CaseContracts;
use App\Models\LawCategory;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserPaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class AttorneyInitials extends Controller
{
    use EmailTrait;

    /**
     * Displays the user's profile for updating.
     *
     * Retrieves the authenticated user's profile details and passes them to the view for editing.
     *
     * @return \Illuminate\View\View The view displaying the user's profile update form.
     */
    public function update_profile()
    {
        $userProfile = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        return view('attorney.initials.update-profile',compact('userProfile'));
    }
    /**
     * Handles the profile update process.
     *
     * Validates the incoming request, updates the user's profile, and optionally changes the password and image.
     * Commits the changes and redirects to the next step in the application process.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the updated profile data.
     * @return \Illuminate\Http\RedirectResponse The response after attempting the profile update.
     */
    public function updateProfile(Request $request)
    {
            //Validated
            $this->validate($request, [
                'first_name' =>  'required',
                'last_name' =>  'required',
                'dob' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'image' => 'required|image|max:5120',
                'bio' => 'required',
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
                $user->restricted_steps = 7;
                $user->save();
            }

            $alert = [
                'message' => 'Profile updated successfully.',
                'alert-type' => 'success'
            ];
            return to_route('attorney_application_form')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert)->withInput();
        }
    }
    /**
     * Displays the initial application form.
     *
     * @return \Illuminate\View\View The view displaying the initial application form.
     */
    public function initial_application_form()
    {
        //this form is step form
        return view('attorney.initials.initial-application-form');
    }
    /**
     * Displays the attorney application form.
     *
     * @return \Illuminate\View\View The view displaying the attorney application form with available case types.
     */
    public function attorney_application_form()
    {
        $cases = LawCategory::orderby('status','DESC')->get();
        return view('attorney.initials.attorney-application-form',compact('cases'));
    }
    /**
     * Handles the submission of the attorney application form.
     *
     * Validates the incoming request, processes any file uploads (images and documents),
     * saves the application data, and updates the user’s status in the system.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the attorney application data.
     * @return \Illuminate\Http\RedirectResponse The response after attempting to save the application.
     */
    public function attorney_application_form_store(Request $request)
    {
        //Validated
        $this->validate($request, [
            'image.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
            'document.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,odt,ods,txt|max:5120',
            'name_of_applicant' => 'required|string',
            'name_of_firm_you_work_for' => 'required|string',
            'do_you_own_this_firm' => 'required|string',
            'how_long_have_you_been_in_service_to_the_public' => 'required|string',
            'website' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'languages_spoken' => 'required|string',
            'law_school_name' => 'required|string',
            'year_graduated' => 'required|string',
            'admitted_into_law_in_az' => 'required|string',
            'az_state_bar_number' => 'required|string',
            'any_special_certifications' => 'required|string',
            'area_of_practice' => 'nullable|array',
            'area_of_practice.*' => 'nullable',
            'year_started_in_this_area' => 'nullable|array',
            'year_started_in_this_area.*' => 'nullable',
            'average_no_of_cases_handled_per_year' => 'nullable|array',
            'average_no_of_cases_handled_per_year.*' => 'nullable',
            'signature_of_applicant' => 'required|string',
        ], [
            'signature_of_applicant.required' => 'Please provide your signature and click on confirm button.',
        ]);

        DB::beginTransaction();
        try {

            $attorney_application = new AttorneyApplication();
            $attorney_application->user_id = auth()->user()->id;
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
            $attorney_application->admitted_into_law_AZ = $request->admitted_into_law_in_az;
            $attorney_application->AZ_state_bar_name = $request->az_state_bar_number;
            $attorney_application->any_special_certification = $request->any_special_certifications;
            $attorney_application->counties_of_preference = json_encode($request->counties_of_preference);

            $attorney_application->area_of_practice = json_encode($request->area_of_practice);
            $attorney_application->year_started_in_this_area = json_encode($request->year_started_in_this_area);
            $attorney_application->average_cases_handled_per_month = json_encode($request->average_no_of_cases_handled_per_year);

            $attorney_application->signature_text = $request->signature_of_applicant;

            if ($request->signature_of_applicant) {
                // Extract base64 image data from the request
                $base64Image = preg_replace('/data:image\/(jpeg|jpg|png);base64,/', '', $request->signature_of_applicant);
                // Decode the base64 image data
                $signature_image = base64_decode($base64Image);
                // Generate a unique filename for the image
                $filename = hexdec(uniqid()) . '.png';
                // Define the upload location relative to public directory
                $upload_location = '/storage/attorney_application_signatures/';
                // Save the image file to the specified upload location
                $file_path = public_path() . $upload_location . $filename;
                file_put_contents($file_path, $signature_image);
                // Save the URL to the signature image in the database or use as needed
                $save_url = $upload_location . $filename;
                $attorney_application->signature_image = $save_url;
            }

            $attorney_application->save();

            if ($request->hasFile('image')) {
                foreach ($request->image as $key => $image) {
                    /** Upload new image */
                    $upload_location = '/storage/attorney_application_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $attorney_application_media = new AttorneyMedia();
                    $attorney_application_media->user_id = auth()->user()->id;
                    $attorney_application_media->attorney_application_id = $attorney_application->id;
                    $attorney_application_media->type = 'image';
                    $attorney_application_media->media = $save_url;
                    $attorney_application_media->save();
                }
            }

            if ($request->hasFile('document')) {
                foreach ($request->document as $key => $image) {
                    /** Upload new document */
                    $upload_location = '/storage/attorney_application_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $attorney_application_media = new AttorneyMedia();
                    $attorney_application_media->user_id = auth()->user()->id;
                    $attorney_application_media->attorney_application_id = $attorney_application->id;
                    $attorney_application_media->type = 'document';
                    $attorney_application_media->media = $save_url;
                    $attorney_application_media->save();
                }
            }

            //updating restricted_step flag for mobile app
            $user = User::where('id',auth()->user()->id)->first();
            if($user->restricted_steps == 7)
            {
                $user->restricted_steps = 8;
                $user->save();
            }

            DB::commit();

            $alert = [
                'message' => 'Attorney application submitted successfully',
                'alert-type' => 'success'
            ];

            return to_route('attorney_agreement_form')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($alert);
        }

    }

     /**
     * Displays the attorney agreement form.
     *
     * Retrieves the list of law categories ordered by status and passes it to the view for rendering.
     *
     * @return \Illuminate\View\View The view displaying the attorney agreement form with law categories.
     */
    public function attorney_agreement_form()
    {
        $laws = LawCategory::orderby('status','DESC')->get();
        return view('attorney.initials.attorney-agreement-form',compact('laws'));
    }
    /**
     * Displays the universal client-attorney agreements based on the law category ID.
     *
     * Retrieves the case contracts related to the given law category ID, filters by enabled status,
     * and passes them to the view.
     *
     * @param string $law_cat_id The law category IDs as a comma-separated string.
     * @return \Illuminate\View\View The view displaying the universal client-attorney agreements.
     */
    public function attorney_universal_client_attorney_agreements($law_cat_id)
    {
        $case_contracts = CaseContracts::whereIn('cat_id',explode(',',$law_cat_id))->where('status','Enable')->orderby('id','ASC')->get();
        return view('attorney.initials.universal-client-attorney-agreements',compact('case_contracts'));
    }
    /**
     * Displays the attorney's terms and conditions.
     *
     * Retrieves the first entry of the AttorneyTermsAndCondition model and passes it to the view.
     *
     * @return \Illuminate\View\View The view displaying the attorney terms and conditions.
     */
    public function attorney_terms_and_conditions()
    {
        $terms = AttorneyTermsAndCondition::first();
        return view('attorney.initials.terms-and-conditions',compact('terms'));
    }
    /**
     * Displays the attorney fee intake form.
     *
     * Retrieves law categories with subcategories and their associated lawyers based on the law category IDs
     * passed in the request, and returns the fee intake form view.
     *
     * @param string $law_cat_id The law category IDs as a comma-separated string.
     * @return \Illuminate\View\View The view displaying the attorney fee intake form.
     */
    public function attorney_fee_intake($law_cat_id)
    {
        $fees = LawCategory::with('subCategories.getLaywers')->whereIn('id',explode(',',$law_cat_id))->get();
        return view('attorney.initials.intake-fee',compact('fees'));
    }

    /**
     * Handles the submission of the attorney agreement form.
     *
     * Validates the incoming request, processes the attorney agreement data, saves it to the database,
     * uploads the signature image, and updates the user's restricted step status.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the attorney agreement data.
     * @return \Illuminate\Http\RedirectResponse The response after attempting to save the agreement.
     */

    public function attorney_agreement_form_store(Request $request)
    {
        $this->validate($request, [
            'attorney_name_agreement_1' => 'required',
            'law' => 'required|array',
            'law.*' => 'required',
            'malpractice_insurance' => 'required',
            'signature' => 'required',
            'termsAndConditions' => 'required',
            'feeIntake' => 'required',
            'universal_client_attorney_agreement' => 'required',
            'date' => 'required',
        ], [
            'signature.required' => 'Please provide your signature and click on confirm button.',
        ]);

        try {

            DB::beginTransaction();

            $attorney_agreement = new AttorneyAgreement();
            $attorney_agreement->user_id = auth()->user()->id;
            $attorney_agreement->attorney_name_1 = $request->attorney_name_agreement_1;
            $attorney_agreement->area_of_law = json_encode(array_map('intval', $request->input('law')));
            $attorney_agreement->malpractice = $request->malpractice_insurance;
            $attorney_agreement->date = $request->date;


            if ($request->signature) {
                // Extract base64 image data from the request
                $base64Image = preg_replace('/data:image\/(jpeg|jpg|png);base64,/', '', $request->signature);
                // Decode the base64 image data
                $signature_image = base64_decode($base64Image);
                // Generate a unique filename for the image
                $filename = hexdec(uniqid()) . '.png';
                // Define the upload location relative to public directory
                $upload_location = '/storage/attorney_agreement_signatures/';
                // Save the image file to the specified upload location
                $file_path = public_path() . $upload_location . $filename;
                file_put_contents($file_path, $signature_image);
                // Save the URL to the signature image in the database or use as needed
                $save_url = $upload_location . $filename;
                $attorney_agreement->signature = $save_url;
            }


            $attorney_agreement->save();

            //updating restricted_step flag for mobile app
            $user = User::where('id',auth()->user()->id)->first();
            if($user->restricted_steps == 8)
            {
                $user->restricted_steps = 9;
                $user->save();
            }

            DB::commit();

            $alert = [
                'message' => 'Attorney agreement submitted successfully',
                'alert-type' => 'success'
            ];

            return to_route('attorney_payment_form')->with($alert);

        } catch (\Throwable $th) {
            DB::rollBack();
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($alert);
        }
    }
    /**
     * Displays the attorney payment form and creates a Stripe account for the attorney.
     *
     * Sets the Stripe secret key, creates a Stripe Connect account, and generates an account onboarding link.
     * Passes the onboarding URL and the user's payment details to the view.
     *
     * @return \Illuminate\View\View The view displaying the attorney payment form.
     */
    public function attorney_payment_form()
    {
        // Set the Stripe secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create a new Stripe Connect account
        $account = Account::create([
            'type' => 'express', // or 'standard' depending on your needs
            'business_profile' => [
                'name' => auth()->user()->getUserDetails->first_name. ' '.auth()->user()->getUserDetails->last_name,
            ],
        ]);
        // Store the account ID in the session
        Session::put('stripe_account_id', $account->id);

        // Create an account link for onboarding
        $accountLink = AccountLink::create([
            'account' => $account->id,
            'refresh_url' => route('validate_attorney_connect_account',['refresh']),
            'return_url' => route('validate_attorney_connect_account',['return']),
            'type' => 'account_onboarding',
        ]);
        $url = $accountLink->url;

        $paymentDetails = UserPaymentDetails::where('user_id',auth()->user()->id)->first();

        return view('attorney.initials.attorney-payment-form',compact('url','paymentDetails'));
    }
    /**
     * Stores the attorney's card information for Stripe payments.
     *
     * Validates and processes the card details, creates a customer on Stripe, attaches the payment method,
     * and stores the payment details in the database. Sends email notifications for success or failure.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the card data.
     * @return \Illuminate\Http\RedirectResponse The response after attempting to store the card.
     */
    public function attorney_card_store(Request $request)
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

            //sending email
            $this->sendEmail($request->client_email, 'Card Added Successfully.', 'Your card has been added successfully to YourBestLaywer.com, You can now use it for transactions.');

            DB::commit();

            $alert = [
                'message' => 'Your card has been added successfully.',
                'alert-type' => 'success'
            ];
            return back()->with($alert);

        } catch (\Throwable $th) {

            DB::rollBack();
            //sending email
            $this->sendEmail($request->client_email, 'Card has been declined.', 'There was an issue adding your card. Please check the details and try again.');
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    /**
     * Validates the Stripe account connection for the attorney.
     *
     * Retrieves the Stripe account ID from the session and checks if the attorney's account has completed
     * the onboarding process. Updates the user's restricted steps and saves the Stripe account ID in the database.
     * Sends a success or error notification based on the result.
     *
     * @return \Illuminate\View\View The view displaying the redirection page after validation.
     */
    public function validate_attorney_connect_account()
    {
        // Set the Stripe secret key
        Stripe::setApiKey(config('services.stripe.secret'));
            // Retrieve the account ID from the session
            $accountId = Session::get('stripe_account_id');

            if (!$accountId) {
                $redirectionRoute = route('attorney_payment_form');
                $alert = [
                    'message' => 'Onboarding unsuccessfull kindly try again to proceed.',
                    'alert-type' => 'error'
                ];
            }
            $account = Account::retrieve($accountId);

            try {
                // Retrieve the account details
                $account = Account::retrieve($accountId);
                if($account->charges_enabled != true AND $account->payouts_enabled != true)
                {
                    return $this->redirectWithAlert(
                        route('attorney_payment_form'),
                        'Onboarding unsuccessful, please complete all required steps.',
                        'error'
                    );
                }

                foreach ($account->capabilities as $capability => $status) {
                    if ($status !== 'active') {
                        $redirectionRoute = route('attorney_payment_form');
                        $alert = [
                            'message' => 'Onboarding unsuccessfull kindly try again to proceed.',
                            'alert-type' => 'error'
                        ];

                        Session::forget('stripe_account_id');
                        return view('attorney.initials.attorney-redirection-page',compact('redirectionRoute','alert'));
                    }
                }

                // Check if an external account (e.g., bank account) is added
                if (empty($account->external_accounts->data)) {
                    $redirectionRoute = route('attorney_payment_form');
                    $alert = [
                        'message' => 'Onboarding unsuccessfull kindly try again to proceed.',
                        'alert-type' => 'error'
                    ];
                    Session::forget('stripe_account_id');
                    return view('attorney.initials.attorney-redirection-page',compact('redirectionRoute','alert'));
                }

                $redirectionRoute = route('attorney_application_preview');
                $alert = [
                    'message' => 'Onboarding Successfull',
                    'alert-type' => 'success'
                ];
                Session::forget('stripe_account_id');

                DB::beginTransaction();
                //updating steps
                $user = User::where('id',auth()->user()->id)->first();
                if($user->restricted_steps == 9)
                {
                    $user->restricted_steps = 10;
                    $user->save();
                }

                //saving account_id to db
                $paymentDetails = UserPaymentDetails::where('user_id', auth()->user()->id)->first();
                $paymentDetails->stripe_attorney_connect_id = $account->id;
                $paymentDetails->json_response = $account;
                $paymentDetails->status = 'Enabled';
                $paymentDetails->save();

                //sending email
                $this->sendEmail(
                    $user->email,
                    'YBL Connect Onboarding Successfully.',
                    'Congratulations, You have been onboarded for YourBestLawyer.com transactions successfully, You can now receive payments on your linked stripe account.'
                );

                DB::commit();

                return view('attorney.initials.attorney-redirection-page',compact('redirectionRoute','alert'));

            } catch (\Exception $e) {
                DB::rollBack();

                $redirectionRoute = route('attorney_payment_form');

                $alert = [
                    'message' => 'Onboarding unsuccessfull kindly try again to proceed.',
                    'alert-type' => 'error'
                ];
                Session::forget('stripe_account_id');

                return view('attorney.initials.attorney-redirection-page',compact('redirectionRoute','alert'));
            }
    }
/**
 * Handles the storage of the attorney's Stripe account information.
 *
 * This method checks if a `UserPaymentDetails` record exists for the authenticated user. If it does, it updates the
 * Stripe account ID; otherwise, it creates a new record with a default Stripe account ID ('test dummy data').
 * After updating or creating the payment record, the user's restricted steps are updated if needed.
 * Finally, a success or error alert is prepared based on the outcome.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing the Stripe account ID.
 * @return \Illuminate\Http\RedirectResponse A redirect back to the application preview or a back redirect in case of error.
 */
    public function attorney_payment_form_store(Request $request)
    {
        $this->validate($request, [
            'stripe_account_id' => 'nullable',
        ]);
        try {
            $userPayment = UserPaymentDetails::where('user_id', auth()->user()->id)->first();

            if ($userPayment) {
                // Update existing record
                $userPayment->stripe_account_id = $request->stripe_account_id;
                $userPayment->save();
            } else {
                // Create new record
                $userPayment = new UserPaymentDetails();
                $userPayment->user_id = auth()->user()->id;
                $userPayment->stripe_account_id = 'test dummy data';
                $userPayment->save();
            }

            //updating steps
            $user = User::where('id',auth()->user()->id)->first();
            if($user->restricted_steps == 9)
            {
                $user->restricted_steps = 10;
                $user->save();
            }

            $alert = [
                'message' => 'Attorney payments submitted successfully',
                'alert-type' => 'success'
            ];

            return to_route('attorney_application_preview')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($alert);
        }
    }
/**
 * Displays the attorney application preview page.
 *
 * This method fetches the authenticated user's profile, latest application, associated media, and the agreement.
 * It decodes the area of law from the agreement and retrieves the corresponding law categories.
 * All this data is passed to the view to present a detailed preview of the application.
 *
 * @return \Illuminate\View\View The view for the attorney application preview page.
 */
    public function attorney_application_preview()
    {
        $profile = User::with('getUserDetails','getUserPaymentDetailsOne')->where('id',auth()->user()->id)->first();
        $application = AttorneyApplication::where('user_id',auth()->user()->id)->latest()->first();
        $medias = AttorneyMedia::where('attorney_application_id',$application->id)->get();
        $agreement = AttorneyAgreement::where('user_id',auth()->user()->id)->latest()->first();

        $attorneyLaws = json_decode($agreement->area_of_law);
        $getLaws = LawCategory::whereIn('id',$attorneyLaws)->get();
        return view('attorney.initials.attorney-application-preview',compact('profile','application','medias','agreement','getLaws'));
    }
/**
 * Submits the attorney's application preview form.
 *
 * This method validates the incoming request, specifically ensuring that an application ID is provided. It updates
 * the application status to 'Pending' and changes the user's restricted step to the next stage (if applicable).
 * If everything succeeds, a success alert is prepared; otherwise, an error alert is returned.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing the application ID.
 * @return \Illuminate\Http\RedirectResponse A redirect to a thank you page upon successful submission.
 */
    public function attorney_application_preview_store(Request $request)
    {
        $this->validate($request, [
            'application_id' => 'required'
        ]);
        try {
            $user = User::where('id',auth()->user()->id)->first();
            //updating status of application data
            $application_data = AttorneyApplication::where('id',$request->application_id)->update(['status'=>'Pending']);

            //updating steps
            if($user->restricted_steps == 10)
            {
                $user->restricted_steps = 12;
                $user->save();
            }

            $alert = [
                'message' => 'Application submited successfully',
                'alert-type' => 'success'
            ];

            return to_route('attorney_application_processing_thankyou')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($alert);
        }
    }
/**
 * Displays the "Thank You" page after processing the attorney's application.
 *
 * This method retrieves the authenticated user's profile and the latest application data to be passed to the
 * view that displays the thank you message for submitting the application.
 *
 * @return \Illuminate\View\View The view for the attorney application processing thank you page.
 */
    public function attorney_application_processing_thankyou()
    {
        $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        $application = AttorneyApplication::where('user_id',auth()->user()->id)->latest()->first();
        return view('attorney.initials.attorney-application-processing-thankyou',compact('user','application'));
    }
/**
 * Automates the attorney application process by creating attorney types based on the areas of law in the agreement.
 *
 * This method fetches the authenticated user's profile and application data. It marks the application status as
 * 'Accepted' and loops through the areas of law defined in the agreement to create corresponding `AttorneyType` records.
 * After completing the automation, the user's restricted steps are updated accordingly.
 *
 * @param \Illuminate\Http\Request $request The incoming request for automation.
 * @return \Illuminate\Http\RedirectResponse A redirect to the attorney dashboard with a success alert.
 */
    public function attorney_application_automate(Request $request)
    {
        try {
            //fetch profile data
            $user = User::where('id',auth()->user()->id)->first();
            $application = AttorneyApplication::where('user_id',$user->id)->first();
            $application->status = 'Accepted';
            $application->save();

            $agreement = AttorneyAgreement::where('user_id',$user->id)->first();
            //automating super admin process
            foreach(json_decode($agreement->area_of_law) as $area_of_law){
                $makeAttorneyType =new AttorneyType();
                $makeAttorneyType->user_id = $user->id;
                $makeAttorneyType->law_cat_id = $area_of_law;
                $makeAttorneyType->lawyer_id = 2;
                $makeAttorneyType->save();
            }
            //updating steps
            if($user->restricted_steps == 12)
            {
                $user->restricted_steps = 13;
                $user->save();
            }

            $alert = [
                'message' => 'Application updated and automated successfully',
                'alert-type' => 'success'
            ];
            return to_route('attorney_dashboard')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($alert);
        }
    }
/**
 * Submits a new attorney application by resetting the user's restricted steps.
 *
 * This method clears the user's restricted steps and redirects them to the profile update page to submit a new application.
 * Any errors encountered during this process are caught and an error alert is returned.
 *
 * @return \Illuminate\Http\RedirectResponse A redirect to the attorney profile update page.
 */
    public function submit_new_application()
    {
        try{

            $user = User::where('id',auth()->user()->id)->first();
            $user->restricted_steps = null;
            $user->save();

            return to_route('attorney_update_profile');

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($alert);
        }
    }
}
