<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\AttorneyAgreement;
use App\Models\Contracts;
use App\Models\CustomerContract;
use App\Models\LawCategory;
use App\Models\PaymentPlan;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserValidation;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

class ApiAuthController extends Controller
{
    use SendsPasswordResetEmails;

    public function validateUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_name' => 'required|unique:users,user_name',
                'email' => 'required|email|unique:users,email'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $verification_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $userValidation = UserValidation::where('email',$request->email)->first();
            if($userValidation)
            {
                $userValidation->verification_code = $verification_code;
                $userValidation->save();
            }else{
                $userValidation = new UserValidation();
                $userValidation->email = $request->email;
                $userValidation->verification_code = $verification_code;
                $userValidation->save();
            }

            //for email verification code starts
                $mailData = ['verification_code' => $verification_code];
                Mail::to([$request->email])->send(new VerificationCodeMail($mailData));
            //for email verification code ends

            return response()->json([
                'status' => true,
                'message' => 'User validated successfully & email has been sent.',
                'verification_code'=> $verification_code
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_name' => 'required|unique:users,user_name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'user_type' => [
                    'required',
                    Rule::in(['customer', 'attorney']),
                ],
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if($request->user_type == 'customer')
            {

                $user = User::create([
                    'user_name' => $request->user_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'restricted_steps'=>null,
                    'user_type' => 'customer', //customer or attorney
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'User Created Successfully',
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'user' => $user
                ], 200);
            }
            else
            {
                $user = User::create([
                    'user_name' => $request->user_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'restricted_steps'=>null,
                    'user_type' => 'attorney', //customer or attorney
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Attorney Created Successfully.',
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'user' => $user,
                ], 200);
            }



        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function createUserSecondStepAttorney(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id'=> 'required',
                'name_of_applicant' => 'required',
                'name_of_firm_you_work_for' => 'required',
                'do_you_own_this_firm' => 'required',
                'address_of_business_location' => 'required',
                'official_email' => 'required',
                'phone' => 'required',
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
            $user_detail->name_of_applicant = $request->name_of_applicant;
            $user_detail->name_of_firm_you_work_for = $request->name_of_firm_you_work_for;
            $user_detail->do_you_own_this_firm = $request->do_you_own_this_firm;
            $user_detail->address_of_business_location = $request->address_of_business_location;
            $user_detail->official_email = $request->official_email;
            $user_detail->phone = $request->phone;
            $user_detail->save();

            return response()->json([
                'status' => true,
                'message' => 'Attorney step 2 created Successfully',
                'user_detail' => $user_detail
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function emailVerification(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'verification_code' => 'required|numeric',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $userValidation = UserValidation::where('email', $request->email)->first();
            $user = User::where('email', $request->email)->first();

            if($userValidation == null)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User not exists.'
                ], 422);
            }

            if($request->verification_code !== $userValidation->verification_code)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Your verification code in invalid.'
                ], 422);
            }

            if($user->email_verified_at !== null)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User already verified'
                ], 422);
            }

            $user->email_verified_at = now();
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User verified successfully.'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function sendLaterVerificationCode(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $userValidation = UserValidation::where('email', $request->email)->first();
            $user = User::where('email', $request->email)->first();

            if($userValidation == null)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Email not exists.'
                ], 422);
            }

            if($user->email_verified_at !== null)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User already verified'
                ], 422);
            }
            $verification_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $userValidation->verification_code = $verification_code;
            $userValidation->update();

            //for email verification code starts
                $mailData = ['verification_code' => $verification_code];
                Mail::to([$request->email,'mdmuqtada.twg@gmail.com'])->send(new VerificationCodeMail($mailData));
            //for email verification code ends

            return response()->json([
                'status' => true,
                'message' => 'Verification code has been sent.',
                'code'=>$verification_code
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            //if user is not verified
            if($user->email_verified_at == null)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Your email is not verified kindly verify first.',
                ], 403);
            }

            //if customer
            if($user->user_type == 'customer')
            {
                $user = User::with('getUserDetails',
                'getUserPaymentDetails',
                'getFirstApplicationDetails.getDynamicFormValues',
                'getFirstApplicationDetails.getCaseMedia',
                'getFirstApplicationDetails.getCaseBid',
                'getFirstApplicationDetails.getCaseLaw',
                'getFirstApplicationDetails.getCaseLawSub',
                'getFirstApplicationDetails.getCasePackage')->where('email', $request->email)->first();

                //get customer payment plan
                if ($user->restricted_steps > 11) {
                    $payment_plan = PaymentPlan::with('getTransactions')
                    ->where('customer_id',$user->id)
                    ->where('case_id', $user->getFirstApplicationDetails->id)
                    ->first();
                    $user->getFirstApplicationDetails->payment_plan = $payment_plan;
                }

                //getting contract details
                //for now it is dummy we need to send specific contracts via filter when all contracts upload to db in future
                if ($user->restricted_steps > 12) {
                    $contract_detail = Contracts::latest()->first();
                    $user->getFirstApplicationDetails->contract_detail = $contract_detail;
                }

                //to get the assigned attorney details
                if ($user->restricted_steps > 16) {
                    $customerContract = CustomerContract::where('customer_id',$user->id)->latest()->first();
                    $getAttorney = User::where('id',$customerContract->attorney_id)->first();
                    $user->getFirstApplicationDetails->assigned_attorney = $getAttorney;
                }

            }elseif($user->user_type == 'attorney'){ //if attorney

                $user = User::with('getUserDetails',
                'getUserPaymentDetails',
                'getAttorneyApplication.getAttorneyApplicationMedia')
                ->where('email', $request->email)->first();

                if($user->getAttorneyApplication){
                    $user->getAttorneyApplication->area_of_practice = json_decode($user->getAttorneyApplication->area_of_practice);
                    $user->getAttorneyApplication->year_started_in_this_area = json_decode($user->getAttorneyApplication->year_started_in_this_area);
                    $user->getAttorneyApplication->average_cases_handled_per_month = json_decode($user->getAttorneyApplication->average_cases_handled_per_month);
                }

                if($user->restricted_steps > 8)
                {
                    $laws = LawCategory::orderby('id','ASC')->get();
                    $user->laws = $laws;
                }

                if ($user->restricted_steps > 10) {
                    $attorney_agreement = AttorneyAgreement::where('user_id',$user->id)->latest()->first();
                    $user->getAttorneyApplication->attorney_agreement = $attorney_agreement;
                    $user->getAttorneyApplication->attorney_agreement->area_of_law = json_decode($user->getAttorneyApplication->attorney_agreement->area_of_law);
                    $user->getAttorneyApplication->attorney_agreement->area_of_practice = json_decode($user->getAttorneyApplication->attorney_agreement->area_of_practice);
                    $user->getAttorneyApplication->attorney_agreement->year_started = json_decode($user->getAttorneyApplication->attorney_agreement->year_started);
                    $user->getAttorneyApplication->attorney_agreement->cases_handled_per_year = json_decode($user->getAttorneyApplication->attorney_agreement->cases_handled_per_year);
                }

            }

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    //if token not found
    public function noTokenFound()
    {
        return response()->json([
            'status' => false,
            'message' => 'Token error, You are not authenticated and do not have authorized access.'
        ], 401);
    }

    //if token found for testing
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Dashboard, You are in.'
        ], 200);
    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::where('email',$request->email)->first();

            if($user == null){
                return response()->json([
                    'status' => false,
                    'message' => 'Email does not exist in our database.'
                ], 200);
            }

            Password::sendResetLink(['email' => $request->email]);

            return response()->json([
                'status' => true,
                'message' => 'Email matched, reset link has been sent.'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function getAllUsers()
    {
        $users = User::with('getUserDetails','getUserPaymentDetails')->orderby('id','ASC')->get();
        return response()->json([
            'status' => true,
            'message' => 'All users fetched successfully',
            'users' => $users
        ], 401);
    }

    public function deleteUser(Request $request)
    {
        try {
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

            $user = User::where('id',$request->user_id)->first();

            if($user == null){
                return response()->json([
                    'status' => false,
                    'message' => 'User not exists.'
                ], 200);
            }

            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'User and its all data has been deleted successfully from YBL database.'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function checkToken(Request $request)
    {
        try {
            // Validate the request
            $validateToken = Validator::make($request->all(),
            [
                'token' => 'required|string'
            ]);

            if ($validateToken->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateToken->errors()
                ], 401);
            }

            // Get the token from the request
            $token = $request->token;

            // Find the token in the database
            $tokenRecord = PersonalAccessToken::findToken($token);

            if (!$tokenRecord) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid token.',
                ], 200);
            }

            // Check if the token has expired
            $expirationMinutes = config('sanctum.expiration', 0); // 0 means no expiration

            if ($expirationMinutes) {
                $expiryTime = $tokenRecord->created_at->addMinutes($expirationMinutes);

                if (Carbon::now()->greaterThan($expiryTime)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Token has expired.',
                    ], 200);
                }
            }

            // Token is valid
            return response()->json([
                'status' => true,
                'message' => 'Token is valid.',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
