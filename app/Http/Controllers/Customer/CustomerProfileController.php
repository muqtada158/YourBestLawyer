<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserPaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class CustomerProfileController extends Controller
{
    /**
 * Displays the profile page of the authenticated user.
 * Fetches the user's details and passes it to the view.
 *
 * @return \Illuminate\View\View The view displaying the user's profile.
 */
    public function profile()
    {
        $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        return view('customer.my-profile',compact('user'));
    }

    /**
 * Displays the profile edit page for the authenticated user.
 * Fetches the user's details and passes it to the view for editing.
 *
 * @return \Illuminate\View\View The view displaying the user's profile edit page.
 */
    public function profile_edit()
    {
        $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        return view('customer.my-profile-edit',compact('user'));
    }

    /**
 * Updates the profile information of the authenticated user.
 * Validates the request, processes the profile data, and updates it in the database.
 * Also updates the user's password if provided.
 *
 * @param \Illuminate\Http\Request $request The request containing the profile update data.
 * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
 */
    public function profile_update(Request $request)
    {
        //Validated
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'nullable|image|max:5120',
            'current_password' => 'nullable',
            'new_password' => 'required_with:old_password',
            'password_confirmation' => 'required_with:old_password|same:new_password'
        ]);

        try {
            $user_detail = UserDetail::where('user_id',auth()->user()->id)->first();
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
 * Returns the view to update the user's payment card details.
 * The user will be able to provide new card information on this page.
 *
 * @return \Illuminate\View\View The view to update card details.
 */
    public function update_card_details()
    {
        return view('customer.update-card');
    }

    /**
 * Processes the request to update the user's payment card details.
 * This method creates a new payment method via Stripe, attaches it to the user's account,
 * and updates the card details in the database.
 *
 * @param \Illuminate\Http\Request $request The request containing the new card details.
 * @return \Illuminate\Http\RedirectResponse Redirects with a success or error message.
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
            $userPaymentDetails = UserPaymentDetails::where('user_id',auth()->user()->id)->first();
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

            //sending email
            $this->sendEmail(
                auth()->user()->email,
                'Card updated successfully.',
                'Your card ends with '.$userPaymentDetails->card_last_four.' has been updated successfully.'
            );

            DB::commit();

            $alert = [
                'message' => 'Your card has been updated successfully.',
                'alert-type' => 'success'
            ];
            return to_route('customer_profile')->with($alert);

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
