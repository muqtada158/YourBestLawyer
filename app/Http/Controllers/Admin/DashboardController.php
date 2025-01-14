<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseDetail;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page in the admin panel.
     *
     * This method returns the view for displaying the dashboard in the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
            return view('admin.dashboard');
    }

    /**
     * Update the status of a user.
     *
     * This method validates the request, updates the status of a user to either 'Enabled' or 'Disabled',
     * and returns an appropriate alert message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_status(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:Enabled,Disabled',
        ]);

        try {
            // Get the authenticated user
            $user = User::find($request->user_id);
            $user->status = $request->status;
            $user->save();

            $alert = [
                'message' => 'Status updated successfully',
                'alert-type' => 'success'
            ];
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
    /**
     * Perform a search based on the user's input.
     *
     * This method searches for a case by its SR number and for users by their first or last name.
     * It returns the search results in an admin panel view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        try {
            // Initialize an empty collection
            $search = collect();

            // Search exact via number
            $exactMatch = CaseDetail::where('sr_no', (int)$request->search)->get();

            // If no exact match found, perform wildcard search
            if ($exactMatch->isEmpty()) {
                $wildcardMatch = CaseDetail::where('sr_no', 'like', '%' . $request->search . '%')->get();
                $search = $search->merge($wildcardMatch);
            } else {
                $search = $search->merge($exactMatch);
            }

            // Search via text in UserDetail
            $textMatch = UserDetail::where('first_name', 'like', '%' . $request->search . '%')->orwhere('last_name', 'like', '%' . $request->search . '%')->get();
            $search = $search->merge($textMatch);

            return view('admin.search-ajax', compact('search'));

        } catch (\Throwable $th) {
            $search = collect();
            return view('admin.search-ajax', compact('search'));
        }

    }

}
