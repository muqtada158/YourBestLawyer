<?php

namespace App\Http\Controllers;

use App\Http\Traits\NotificationTrait;
use App\Models\LawCategory;
use App\Models\LawSubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use NotificationTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

/**
 * Displays the 'coming-soon' view.
 *
 * @return \Illuminate\View\View
 */
    public function index2()
    {
        return view('coming-soon');
    }
/**
 * Fetches all enabled LawCategories and passes them to the 'index' view.
 *
 * @return \Illuminate\View\View
 */
    public function index()
    {
        $cases_all =  LawCategory::where('status','Enable')->get();
        return view('index',compact('cases_all'));
    }

/**
 * Displays the 'lawyers' view.
 *
 * @return \Illuminate\View\View
 */
    public function lawyers()
    {
        return view('lawyers');
    }
/**
 * Displays the 'customers' view.
 *
 * @return \Illuminate\View\View
 */
    public function customers()
    {
        return view('customers');
    }
/**
 * Displays the success page after attorney onboarding process with Stripe.
 *
 * @return \Illuminate\View\View
 */
    public function stripe_onboarding_app_success()
    {
        return view('attorney.app.success');
    }

/**
 * Displays the failure page if attorney onboarding fails with Stripe.
 *
 * @return \Illuminate\View\View
 */
    public function stripe_onboarding_app_failed()
    {
        return view('attorney.app.failed');
    }

 /**
 * Searches for LawSubCategories based on the search term, filtering by LawCategory status,
 * and returns the results in 'search-ajax' view.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\View\View
 */
    public function homepage_search(Request $request)
    {
        try {
            $main_cat = LawCategory::where('status','Enable')->orWhere('status','Pending')->pluck('id');
            $search = LawSubCategory::where('title', 'like', '%' . $request->search . '%')
            ->whereIn('cat_id',$main_cat)
            ->orderby('title','ASC')
            ->get();

            return view('search-ajax', compact('search'));

        } catch (\Throwable $th) {
            $search = [];
            return view('search-ajax', compact('search'));
        }
    }
/**
 * Sends a test notification and returns a success or failure response in JSON format.
 *
 * @return \Illuminate\Http\JsonResponse
 */
    public function testNotification()
    {
        try {

            $notification = $this->sendNotification(null,'Welcome to YourBestLawyer.com. Empowering You with legal clarity! ',null,null);

            return response()->json([
                'status' => true,
                'message' => 'Test Notification sent successfully',
                'notification' => $notification
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
/**
 * Displays the password verification page.
 *
 * @return \Illuminate\View\View
 */
    public function check_password()
    {
        return view('check-password');
    }

    /**
 * Validates the entered password and grants access if correct.
 * Otherwise, shows an error.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
 */
    public function check_password_validate(Request $request)
    {
        try {
            $password = config('services.password.APP_PASSWORD');
            if ($request->input('password') === $password) {

                $request->session()->put('site_password_checked', true);
                return redirect()->intended('/');

            }else{
                $alert = [
                    'message' => 'Incorrect password please tryagain.',
                    'alert-type' => 'error'
                ];
                return back()->with($alert);
            }
        } catch (\Throwable $th) {
            $alert = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
