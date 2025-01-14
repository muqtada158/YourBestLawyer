<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\AttorneyType;
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

class AttorneyProfileController extends Controller
{

/**
 * Displays the profile of the authenticated attorney.
 *
 * This method retrieves the user's profile information, including user details and their attorney type,
 * and passes it to the view for rendering the profile page.
 *
 * @return \Illuminate\View\View The view displaying the attorney's profile information.
 */
    public function profile()
    {
        $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        $type = AttorneyType::where('user_id',$user->id)->get();
        return view('attorney.my-profile',compact('user','type'));
    }
    /**
 * Shows the profile edit form for the authenticated attorney.
 *
 * This method retrieves the user's current profile information and displays the profile edit form
 * to allow the attorney to update their details.
 *
 * @return \Illuminate\View\View The view displaying the profile edit form.
 */
    public function profile_edit()
    {
        $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        return view('attorney.my-profile-edit',compact('user'));
    }
/**
 * Updates the profile details of the authenticated attorney.
 *
 * This method validates the incoming request data, updates the attorney's profile, including
 * their name, phone, address, image, and password (if provided), and then saves the changes to the database.
 * A success or error message is returned based on the outcome.
 *
 * @param  \Illuminate\Http\Request  $request The request containing the updated profile details.
 * @return \Illuminate\Http\RedirectResponse Redirects back to the profile edit page with a success or error message.
 */
    public function profile_update(Request $request)
    {
        //Validated
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'nullable|image|max:5120',
            'bio' => 'required',
            'current_password' => 'nullable',
            'new_password' => 'required_with:current_password',
            'password_confirmation' => 'required_with:current_password|same:new_password'
        ]);

        try {
            $user_detail = UserDetail::where('user_id',auth()->user()->id)->first();
            $user_detail->first_name = $request->first_name;
            $user_detail->last_name = $request->last_name;
            // $user_detail->dob = $request->dob;
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

            $user = User::where('id',auth()->user()->id)->first();

            if($request->current_password)
            {
                if (Hash::check($request->current_password, $user->password)) {
                    $user->password = Hash::make($request->password);
                } else {
                    $alert = [
                        'message' => 'Your current password is invalid.',
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert);
                }
                $user->save();
            }

            $alert = [
                'message' => 'Profile updated successfully.',
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
 * Initiates the process of connecting the attorney to Stripe's Connect platform.
 *
 * This method creates a new Stripe Connect account and generates an account link for onboarding.
 * It stores the account ID in the session and redirects the attorney to the Stripe onboarding page.
 *
 * @return \Illuminate\Http\RedirectResponse Redirects to Stripe's onboarding page for the attorney.
 */
    public function change_connect_id()
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
            'refresh_url' => route('attorney_validate_attorney_connect_account_via_dashboard',['refresh']),
            'return_url' => route('attorney_validate_attorney_connect_account_via_dashboard',['return']),
            'type' => 'account_onboarding',
        ]);
        $url = $accountLink->url;

        return redirect($url);
    }

    /**
 * Validates the Stripe Connect account of the attorney via the dashboard.
 *
 * This method checks the status of the Stripe Connect account, ensuring that all necessary steps
 * in the onboarding process have been completed. If successful, it saves the account details to
 * the database and updates the payment details for the user.
 *
 * @return \Illuminate\View\View The view displaying the result of the Stripe Connect account validation.
 */
    public function validate_attorney_connect_account_via_dashboard()
    {
        // Set the Stripe secret key
        Stripe::setApiKey(config('services.stripe.secret'));
            // Retrieve the account ID from the session
            $accountId = Session::get('stripe_account_id');

            if (!$accountId) {
                $redirectionRoute = route('attorney_profile');
                $alert = [
                    'message' => 'Onboarding unsuccessfull kindly try again to change.',
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
                        route('attorney_profile'),
                        'Onboarding unsuccessful, please complete all required steps.',
                        'error'
                    );
                }

                foreach ($account->capabilities as $capability => $status) {
                    if ($status !== 'active') {
                        $redirectionRoute = route('attorney_profile');
                        $alert = [
                            'message' => 'Onboarding unsuccessfull kindly try again to change.',
                            'alert-type' => 'error'
                        ];

                        Session::forget('stripe_account_id');
                        return view('attorney.attorney-validate-connect-id',compact('redirectionRoute','alert'));
                    }
                }

                // Check if an external account (e.g., bank account) is added
                if (empty($account->external_accounts->data)) {
                    $redirectionRoute = route('attorney_profile');
                    $alert = [
                        'message' => 'Onboarding unsuccessfull kindly try again to change.',
                        'alert-type' => 'error'
                    ];
                    Session::forget('stripe_account_id');
                    return view('attorney.attorney-validate-connect-id',compact('redirectionRoute','alert'));
                }

                $redirectionRoute = route('attorney_profile');
                $alert = [
                    'message' => 'Onboarding Successfull',
                    'alert-type' => 'success'
                ];
                Session::forget('stripe_account_id');

                DB::beginTransaction();

                //saving account_id to db
                $paymentDetails = UserPaymentDetails::where('user_id',auth()->user()->id)->first();
                $paymentDetails->stripe_attorney_connect_id = $account->id;
                $paymentDetails->json_response = $account;
                $paymentDetails->status = 'Enabled';
                $paymentDetails->save();

                DB::commit();

                return view('attorney.attorney-validate-connect-id',compact('redirectionRoute','alert'));

            } catch (\Exception $e) {
                DB::rollBack();

                $redirectionRoute = route('attorney_profile');
                $alert = [
                    'message' => 'Onboarding unsuccessfull kindly try again to change.',
                    'alert-type' => 'error'
                ];
                Session::forget('stripe_account_id');

                return view('attorney.attorney-validate-connect-id',compact('redirectionRoute','alert'));
            }
    }
/**
 * Displays the form to update the attorney's card details.
 *
 * This method returns the view displaying the card details update form.
 *
 * @return \Illuminate\View\View The view displaying the card update form.
 */
    public function update_card_details()
    {
        return view('attorney.update-card');
    }

    /**
 * Stores the updated card details for the authenticated attorney.
 *
 * This method processes the updated card information from Stripe, attaches the payment method
 * to the customer's Stripe account, and saves the details in the database.
 * If successful, a success message is shown.
 *
 * @param  \Illuminate\Http\Request  $request The request containing the updated card details.
 * @return \Illuminate\Http\RedirectResponse Redirects back to the profile page with a success or error message.
 */
    public function update_card_details_store(Request $request)
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

            //attaching payment to customer
            $userPaymentDetails = UserPaymentDetails::where('user_id',auth()->user()->id)->where('status','Enabled')->first();
            $customer = Customer::retrieve($userPaymentDetails->stripe_customer_id);

            $paymentMethod->attach([
                'customer' => $customer->id,
            ]);

            $customer->invoice_settings = [
                'default_payment_method' => $paymentMethod->id,
            ];
            $customer->save();

            // Retrieve the list of all payment methods for the customer
            $paymentMethods = PaymentMethod::all([
                'customer' => $customer->id,
                'type' => 'card',
            ]);
            // Detach the previous default payment method
            foreach ($paymentMethods->data as $method) {
                if ($method->id !== $paymentMethod->id) {
                    $method->detach();
                }
            }

            $defaultPaymentMethodId = $customer->invoice_settings->default_payment_method;
            if ($defaultPaymentMethodId) {
                // Retrieve the PaymentMethod object
                $paymentMethod = PaymentMethod::retrieve($defaultPaymentMethodId);
                // Get the card details
                $card = $paymentMethod->card;
            }

            $userPaymentDetails->card_expiry_month = isset($card) ? $card->exp_month : null;
            $userPaymentDetails->card_expiry_year = isset($card) ? $card->exp_year: null;
            $userPaymentDetails->card_last_four =isset($card) ? $card->last4: null;
            $userPaymentDetails->json_response = isset($card) ? $card: null;
            $userPaymentDetails->status = 'Enabled';
            $userPaymentDetails->save();

            DB::commit();

            $alert = [
                'message' => 'Your card has been updated successfully.',
                'alert-type' => 'success'
            ];
            return to_route('attorney_profile')->with($alert);

        } catch (\Throwable $th) {

            DB::rollBack();

            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

}
