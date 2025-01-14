<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\EmailTrait;
use App\Http\Traits\NotificationTrait;
use App\Mail\GlobalMail;
use App\Models\AttorneyAgreement;
use App\Models\AttorneyApplication;
use App\Models\AttorneyReviews;
use App\Models\AttorneyType;
use App\Models\LawCategory;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminAttorniesController extends Controller
{
    // Import traits to add email and notification functionalities to this class.
    use EmailTrait;        // Provides methods to send emails to users.
    use NotificationTrait; // Provides methods to send notifications to users or systems.

/**
 * Display a paginated list of attorneys with their details.
 *
 * @return \Illuminate\View\View
 */
    public function attornies()
    {
        $attornies = User::with('getUserDetails')->where('user_type','attorney')->orderby('id','DESC')->paginate(10);
        $getAttorneyTypes = AttorneyType::orderby('id', 'DESC')->pluck('user_id');
        $attorneyTypes = [];
        if($getAttorneyTypes)
        {
            $collectAttorneyTypes = collect($getAttorneyTypes);
            $attorneyTypes = $collectAttorneyTypes->toArray();
        }
        return view('admin.attornies',compact('attornies','attorneyTypes'));

    }
/**
 * Display detailed information for a specific attorney.
 *
 * @param int $attorney The ID of the attorney to retrieve details for.
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */
    public function attornies_details($attorney)
    {
        try{
            $application = AttorneyApplication::with('getUser.getUserDetails','getAttorneyApplicationMedia')->where('user_id',$attorney)->first();
            $agreement = AttorneyAgreement::where('user_id',$attorney)->first();

            $attorneyLaws = json_decode($agreement->area_of_law);

            $getLaws = LawCategory::whereIn('id',$attorneyLaws)->get();
            $getPackage = Lawyer::orderby('id','ASC')->get();
            $assignedAttornies = AttorneyType::with('getCaseLaw','getCasePackage')->where('user_id',$attorney)->get();

            $attorneyReviews = AttorneyReviews::where('attorney_id',$attorney)->first();

            return view('admin.attornies-details',compact('application','agreement','getLaws','getPackage','assignedAttornies','attorneyReviews'));
        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Assign attorneys to specific cases with associated law categories and packages.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing attorney assignment details.
 * @return \Illuminate\Http\RedirectResponse
 */
    public function assign_attornies(Request $request)
    {
        $request->validate([
            'attorney_id' => 'nullable|integer',
            'application_id' => 'required|integer',
            'law_cat_id' => 'required|array',
            'law_cat_id.*' => 'required|integer|distinct',
            'package_id' => 'required|array',
            'package_id.*' => 'required|integer',
        ], [
            'law_cat_id.required' => 'Each law category must be selected.',
            'law_cat_id.*.required' => 'The law category ID is required.',
            'law_cat_id.*.integer' => 'The law category ID must be a valid integer.',
            'law_cat_id.*.distinct' => 'Duplicate law category IDs are not allowed.',
            'package_id.required' => 'Each package ID must be selected.',
            'package_id.*.required' => 'The package ID is required for each law category.',
            'package_id.*.integer' => 'The package ID must be a valid integer for each law category.',
        ]);

        // Ensure that each law_cat_id has a corresponding package_id
        $lawCatIds = $request->input('law_cat_id');
        $packageIds = $request->input('package_id');

        if (count($lawCatIds) !== count($packageIds)) {
            return redirect()->back()->withErrors(['message' => 'Each law category must have a corresponding package.'])->withInput();
        }

        foreach ($lawCatIds as $index => $lawCatId) {
            if (!isset($packageIds[$index])) {
                return redirect()->back()->withErrors(['message' => 'Each law category must have a corresponding package.'])->withInput();
            }
        }

        try {
            //fetch profile data
            $attorney = User::with('getUserDetails')->where('id',$request->attorney_id)->first();
            //updating status of application data
            $update_application_data = AttorneyApplication::where('id',$request->application_id)->update(['status'=>'Accepted']);

            //automating super admin process
            foreach($request->package_id as $key => $package_id){
                if($package_id !== '0')
                {
                    $makeAttorneyType =new AttorneyType();
                    $makeAttorneyType->user_id = $request->attorney_id;
                    $makeAttorneyType->law_cat_id = $request->law_cat_id[$key];
                    $makeAttorneyType->lawyer_id = $request->package_id[$key];
                    $makeAttorneyType->save();
                }
            }

            //updating steps
            if($attorney->restricted_steps == 12)
            {
                $attorney->restricted_steps = 13;
                $attorney->save();
            }

            //sending email
            $this->sendEmail($attorney->email, 'Registration with YourBestLawyer.com successful.', 'Your registration with YourBestLawyer.com has been successful.');

            //triggering notifications
            $notification = $this->sendNotification([$request->attorney_id],'Congratulations, Your registration with YourBestLawyer.com has been successful.',null,null);

            $alert = [
                'message' => 'Attorney assigned successfully',
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
 * Reject an attorney application by changing its status to 'Rejected'.
 *
 * @param int $attorney The ID of the attorney application to reject.
 * @return \Illuminate\Http\RedirectResponse
 */
    public function reject_attorney_application($attorney)
    {
        try{

            $application = AttorneyApplication::where('id',$attorney)->first();
            $application->status = 'Rejected';
            $application->save();

            //sending email
            $this->sendEmail($application->getUser->email, 'Application rejected.', 'We regret to inform you that your application has been rejected.');
            //triggering notifications
            $notification = $this->sendNotification([$application->getUser->id],'We regret to inform you that your application has been rejected.',null,null);

            $alert = [
                'message' => 'Application rejected successfully',
                'alert-type' => 'success'
            ];
            return to_route('admin_application_attornies',['Rejected'])->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Submit or update attorney reviews for Google, Yelp, and Avvo platforms.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing review details.
 * @return \Illuminate\Http\RedirectResponse
 */
    public function attorney_review(Request $request)
    {
        $request->validate([
            'attorney_id' => 'required|integer',
            'google_review' => 'nullable|numeric',
            'google_date' => 'nullable|date',
            'yelp_review' => 'nullable|numeric',
            'yelp_date' => 'nullable|date',
            'avvo_review' => 'nullable|numeric',
            'avvo_date' => 'nullable|date',
        ]);
        try {
            // Check if the review for the given attorney already exists
            $review = AttorneyReviews::where('attorney_id', $request->attorney_id)->first();

            if ($review) {
                // Update the existing review
                $review->google_review = $request->google_review;
                $review->google_date = $request->google_review == null ? null : $request->google_date;
                $review->yelp_review = $request->yelp_review;
                $review->yelp_date = $request->yelp_review == null ? null : $request->yelp_date;
                $review->avvo_review = $request->avvo_review;
                $review->avvo_date = $request->avvo_review == null ? null : $request->avvo_date;
                $review->save();

                $alert = [
                    'message' => 'Attorney review updated successfully',
                    'alert-type' => 'success'
                ];
            } else {
                // Create a new review
                $review = new AttorneyReviews();
                $review->attorney_id = $request->attorney_id;
                $review->google_review = $request->google_review;
                $review->google_date = $request->google_review == null ? null : $request->google_date;
                $review->yelp_review = $request->yelp_review;
                $review->yelp_date = $request->yelp_review == null ? null : $request->yelp_date;
                $review->avvo_review = $request->avvo_review;
                $review->avvo_date = $request->avvo_review == null ? null : $request->avvo_date;
                $review->save();

                $alert = [
                    'message' => 'Attorney review submitted successfully',
                    'alert-type' => 'success'
                ];
            }

            return back()->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error: ' . $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert)->withInput();
        }
    }


}
