<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_type' => ['required', 'string', Rule::in(['customer', 'attorney'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $verification_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $mailData = ['verification_code' => $verification_code];

        //using a trait to send otp email
        $this->sendOtp($data['email'],$verification_code);
        // Mail::to([$data['email']])->send(new VerificationCodeMail($mailData));

        return User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'user_type' => $data['user_type'],
            'verification_code' => $verification_code,
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register_view()
    {
        return view('auth.registerNew');
    }
    public function verify_email()
    {
        return view('auth.verifyNew');
    }
    public function verifyEmail(Request $request)
    {
        $this->validate($request, [
            'verification_code' => 'required|array',
            'verification_code.*' => 'required', // Validates each element of the array
        ]);
        try {
            $verificationCodeAsString = (int)implode('', $request->verification_code);
            $user = User::where('email', $request->email)->first();

            if ($user == null) {
                $notification = [
                    'message' => 'User not exists.',
                    'alert-type' => 'error'
                ];
                return back()->with($notification);
            }

            if ($verificationCodeAsString !== $user->verification_code) {
                $notification = [
                    'message' => 'Your verification code in invalid.',
                    'alert-type' => 'error'
                ];
                return back()->with($notification);
            }

            if ($user->email_verified_at !== null) {
                $notification = [
                    'message' => 'User already verified',
                    'alert-type' => 'error'
                ];
                return back()->with($notification);
            }

            $user->email_verified_at = now();
            $user->save();

            $notification = [
                'message' => 'User verified successfully.',
                'alert-type' => 'success'
            ];
            return redirect()->route('verification',['type'=>$user->user_type])->with($notification);
        } catch (\Throwable $th) {
            $notification = [
                'message' => 'Error : ' . $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($notification);
        }
    }

    public function resendCode(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $user = User::where('email', $request->email)->first();

            if ($user == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email not exists.'
                ], 422);
            }

            if ($user->email_verified_at !== null) {
                return response()->json([
                    'status' => false,
                    'message' => 'User already verified'
                ], 422);
            }
            $verification_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $user->verification_code = $verification_code;
            $user->update();

            //for email verification code starts
            $mailData = ['verification_code' => $verification_code];
            $this->sendOtp($request->email,$verification_code);

            // Mail::to([$request->email, 'mdmuqtada.twg@gmail.com'])->send(new VerificationCodeMail($mailData));
            //for email verification code ends

            return response()->json([
                'status' => true,
                'message' => 'Verification code has been sent.',
                'code' => $verification_code
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verification()
    {
        return view('auth.verificationNew');
    }

    public function verify_now()
    {
        return view('auth.verify-now');
    }

    public function verify_email_outside(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {

                if ($user->email_verified_at !== null) {
                    $notification = [
                        'message' => 'User already verified',
                        'alert-type' => 'error'
                    ];
                    return back()->with($notification);
                } else {

                    $verification_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

                    $user->verification_code = $verification_code;
                    $user->save();

                    $mailData = ['verification_code' => $verification_code];
                    $mymail = $this->sendOtp($user->email,$verification_code);
                    // Mail::to($user->email)->send(new VerificationCodeMail($mailData));

                    $notification = [
                        'message' => 'Email sent to ' . $user->email . ' with otp successfully',
                        'alert-type' => 'success'
                    ];
                    return redirect()->route('verify_email',['email'=> $user->email])->with($notification);
                }
            } else {
                $notification = [
                    'message' => 'User not exists.',
                    'alert-type' => 'error'
                ];
                return back()->with($notification);
            }
        } catch (\Throwable $th) {
            $notification = [
                'message' => $th,
                'alert-type' => 'error'
            ];
            return back()->with($notification);
        }
    }
}
