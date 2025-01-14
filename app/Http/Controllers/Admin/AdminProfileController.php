<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
        /**
     * Display the user's profile page in the admin panel.
     *
     * This method returns the view for displaying the user's profile in the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('admin.my-profile');
    }
       /**
     * Display the profile edit page in the admin panel.
     *
     * This method returns the view for editing the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile_edit()
    {
        return view('admin.my-profile-edit');
    }
        /**
     * Update the user's profile information, including the password.
     *
     * This method handles the update of the user's password if provided.
     * It validates the input, checks the current password, and updates the user's password if correct.
     *
     * @param \Illuminate\Http\Request $request The request containing the current password, new password, and password confirmation.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profile_update(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'current_password' => 'required_with:new_password',
            'new_password' => 'required_with:current_password|min:8',
            'password_confirmation' => 'required_with:new_password|same:new_password'
        ]);

        try {
            // Get the authenticated user
            $user = User::find(auth()->user()->id);

            // Check if current password is provided
            if ($request->current_password) {
                // Verify the current password
                if (Hash::check($request->current_password, $user->password)) {
                    // Update the user's password
                    $user->password = Hash::make($request->new_password);
                    $user->save();

                    // Prepare a success alert message
                    $alert = [
                        'message' => 'Password updated successfully.',
                        'alert-type' => 'success'
                    ];
                } else {
                    // Prepare an error alert message for an invalid current password
                    $alert = [
                        'message' => 'Your current password is invalid.',
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert);
                }
            } else {
                // Prepare an error alert message if the current password is not provided
                $alert = [
                    'message' => 'Please provide your current password.',
                    'alert-type' => 'error'
                ];
                return back()->with($alert);
            }

            return back()->with($alert);
        } catch (\Throwable $th) {
            // Handle any exceptions
            $alert = [
                'message' => 'Error: ' . $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

}
