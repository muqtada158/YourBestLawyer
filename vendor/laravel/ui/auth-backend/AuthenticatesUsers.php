<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // return view('auth.login');
        return redirect()->route('login_view');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        //----------------------------------------------------------Remove this before 1st january as customers will login
        // if ($this->guard()->user()->user_type == 'customer') {
        //     // Alert message for customers
        //     $alert = [
        //         'message' => "We're excited to have you here! Our platform is currently in the process of signing up top attorneys to serve your needs. Get ready to place your bids starting December 1st!",
        //         'alert-type' => 'modal'
        //     ];
        //     auth()->logout();
        //     // Redirect the customer with the alert
        //     return redirect()->route('login_view')->with($alert);
        // }
        //----------------------------------------------------------Remove this before 1st january as customers will login


        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        //admin
        if($this->guard()->user()->user_type == 'admin')
        {
            return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('admin_dashboard'));
        }
        //customer
        if($this->guard()->user()->user_type == 'customer')
        {

            switch ($this->guard()->user()->restricted_steps) {
                case null:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_update_profile'));
                    break;
                case 9:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_application_form'));
                    break;
                case 10:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_payment_bid_form'));
                    break;
                case 11:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_payment_plans'));
                    break;
                case 12:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_preview'));
                    break;
                case 13:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_thankyou'));
                    break;
                case 14:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_thankyou'));
                    break;
                case 17:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_contract_thank_you'));
                    break;
                case 18:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_contract_thank_you'));
                    break;
                default:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('customer_dashboard'));
                    break;
            }
        }
        //attorney
        if($this->guard()->user()->user_type == 'attorney')
        {
            switch ($this->guard()->user()->restricted_steps) {
                case null:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('attorney_update_profile'));
                    break;
                case 7:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('attorney_application_form'));
                    break;
                case 8:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('attorney_agreement_form'));
                    break;
                case 9:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('attorney_payment_form'));
                    break;
                case 10:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('attorney_application_preview'));
                    break;
                case 12:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('attorney_application_processing_thankyou'));
                    break;
                case 13:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('attorney_dashboard'));
                    break;
                default:
                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended(route('attorney_dashboard'));
                    break;
            }

        }

        //default
        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->email_verified_at) {
            // Log the user out
            Auth::logout();

            // Redirect the user to the verification page with a message
            $notification = [
                'message' => 'Your email is not verified, Please verify your email to continue.',
                'alert-type' => 'error'
            ];
            return back()->with($notification);
        }

        // Check if the user's status is "Enabled"
        if ($user->status !== 'Enabled') {
            // Log the user out
            Auth::logout();

            // Redirect the user to the login page with a message
            $notification = [
                'message' => 'Your account is disabled. Please contact support.',
                'alert-type' => 'error'
            ];
            return back()->with($notification);
        }

        return null;
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
