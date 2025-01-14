<?php

namespace App\Http\Controllers\Apis\Attorney;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AttorneyProfileApisController extends Controller
{

        /**
     * Fetches attorney details based on the provided attorney_id.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing attorney_id.
     * @return \Illuminate\Http\JsonResponse JSON response containing the attorney's details.
     */
    public function getAttorney(Request $request)
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
                ], 422);
            }

            $attorney = User::with('getUserDetails','getUserPaymentDetails')->findOrFail($request->attorney_id);

            if(!$attorney)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Attorney not found.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Attorney fetched successfully',
                'attorney' => $attorney
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Updates the profile information for an attorney.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the attorney's updated details.
     * @return \Illuminate\Http\JsonResponse JSON response containing success or failure message.
     */
    public function updateProfile(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required|exists:user_details,user_id',
                'bio' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'image' => 'nullable|image|max:5120',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $user_detail = UserDetail::where('user_id',$request->attorney_id)->first();
            $user_detail->user_id = $request->attorney_id;
            $user_detail->bio = $request->bio;
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

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully.',
                'profile' => $user_detail
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Updates the password of the user (attorney).
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the current and new passwords.
     * @return \Illuminate\Http\JsonResponse JSON response containing success or failure message.
     */
    public function updatePassword(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'current_password' => 'required',
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|string|same:new_password',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $user = User::findOrFail($request->user_id);

            if(!$user)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User user not found.',
                ], 422);
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect.',
                ], 422);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            $notification = $this->sendNotification([$request->user_id],'Password has been update successfully.',null,null);
            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully.',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
