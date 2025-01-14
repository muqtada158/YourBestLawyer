<?php

namespace Illuminate\Foundation\Auth;

use App\Mail\VerificationCodeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // return view('auth.register');
        return redirect()->route('register_view');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));

        return $request->wantsJson()
        ? new JsonResponse([], 200)
        : redirect()->route('verify_email', ['email' => $request->email]);

        // $this->guard()->login($user);

        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }

        // //admin
        // if($this->guard()->user()->user_type == 'admin')
        // {
        //     return $request->wantsJson()
        //             ? new JsonResponse([], 204)
        //             : redirect()->intended(route('admin_dashboard'));
        // }
        // //customer
        // if($this->guard()->user()->user_type == 'customer')
        // {
        //     return $request->wantsJson()
        //             ? new JsonResponse([], 204)
        //             : redirect()->intended(route('customer_dashboard'));
        // }
        // //attorney
        // if($this->guard()->user()->user_type == 'attorney')
        // {
        //     return $request->wantsJson()
        //             ? new JsonResponse([], 204)
        //             : redirect()->intended(route('attorney_dashboard'));
        // }


        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
