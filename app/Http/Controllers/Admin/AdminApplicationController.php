<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttorneyAgreement;
use App\Models\AttorneyApplication;
use App\Models\AttorneyType;
use App\Models\CaseDetail;
use App\Models\LawCategory;
use App\Models\Lawyer;
use Illuminate\Http\Request;

class AdminApplicationController extends Controller
{
/**
 * Display the main applications view for the admin.
 *
 * @return \Illuminate\View\View
 */

    public function application()
    {
        return view('admin.applications');
    }

/**
 * Display filtered customer applications based on the provided filter.
 *
 * @param string|null $filter The filter criteria ('Accepted', 'Rejected', or 'All').
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */

    public function application_customers($filter = null)
    {
        try{
            if(isset($filter) && $filter == "Accepted")
            {
                $applications = CaseDetail::with('getUser.getUserDetails')
                ->where('application_status','Accepted')
                ->orderby('id','DESC')
                ->paginate(10);
            }

            if(isset($filter) && $filter == "Rejected")
            {
                $applications = CaseDetail::with('getUser.getUserDetails')
                ->where('application_status','Rejected')
                ->orderby('id','DESC')
                ->paginate(10);
            }

            if(isset($filter) && $filter == "All")
            {
                $applications = CaseDetail::with('getUser.getUserDetails')
                ->where('application_status','!=',null)
                ->orderby('id','DESC')
                ->paginate(10);
            }

            return view('admin.application-customers',compact('applications'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

/**
 * Display detailed information for a specific application.
 *
 * @param int $application_id The ID of the application to retrieve details for.
 * @return \Illuminate\View\View
*/
    public function application_details($application_id)
    {
        $application = CaseDetail::with('getUser.getUserDetails','getDynamicFormValues')
                ->where('id',$application_id)
                ->orderby('id','DESC')
                ->first();

        $dynamicForms = null;
        if($application->getDynamicFormValues)
        {
            $dynamicForms = json_decode($application->getDynamicFormValues->form_values);
        }
        return view('admin.application-details',compact('application','dynamicForms'));
    }

/**
 * Reject a specific application.
 *
 * @param int $application_id The ID of the application to reject.
 * @return \Illuminate\Http\RedirectResponse
 */
    public function application_reject_customer($application_id)
    {
        $alert = [
            'message' => 'You cannot reject this application.',
            'alert-type' => 'error'
        ];
        return back()->with($alert);
        try{

            $application = CaseDetail::where('id',$application_id)->first();
            if($application)
            {
                $application->application_status = 'Rejected';
                $application->save();
                $alert = [
                    'message' => 'Application rejected successfully',
                    'alert-type' => 'success'
                ];
                return to_route('admin_application_customers',['Rejected'])->with($alert);
            }else{
                $alert = [
                    'message' => 'Something went wrong application cannot rejected.',
                    'alert-type' => 'error'
                ];
                return back()->with($alert);
            }

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Display attorney applications based on the provided filter.
 *
 * @param string $filter The filter criteria ('Accepted', 'Rejected', 'Pending', or 'All').
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */
    public function application_attornies($filter = "All")
    {
        try{

            if(isset($filter) && $filter == "Accepted")
            {
                $applications = AttorneyApplication::with('getUser.getUserDetails')
                ->where('status','Accepted')
                ->orderby('id','DESC')
                ->paginate(10);
            }

            if(isset($filter) && $filter == "Rejected")
            {
                $applications = AttorneyApplication::with('getUser.getUserDetails')
                ->where('status','Rejected')
                ->orderby('id','DESC')
                ->paginate(10);
            }

            if(isset($filter) && $filter == "Pending")
            {
                $applications = AttorneyApplication::with('getUser.getUserDetails')
                ->where('status','Pending')
                ->orderby('id','DESC')
                ->paginate(10);
            }

            if(isset($filter) && $filter == "All")
            {
                $applications = AttorneyApplication::with('getUser.getUserDetails')
                ->where('status','!=',null)
                ->orderby('id','DESC')
                ->paginate(10);
            }

            $getAttorneyTypes = AttorneyType::orderby('id', 'DESC')->pluck('user_id');
            $attorneyTypes = [];
            if($getAttorneyTypes)
            {
                $collectAttorneyTypes = collect($getAttorneyTypes);
                $attorneyTypes = $collectAttorneyTypes->toArray();
            }
            return view('admin.application-attornies',compact('applications','attorneyTypes'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

/**
 * Display detailed information for a specific attorney application.
 *
 * @param int $application_id The ID of the attorney application to retrieve details for.
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */
    public function application_attorney_details($application_id)
    {
        try{
            $application = AttorneyApplication::with('getUser.getUserDetails','getAttorneyApplicationMedia')->where('id',$application_id)->first();
            $agreement = AttorneyAgreement::where('user_id',$application->user_id)->first();

            $attorneyLaws = json_decode($agreement->area_of_law);

            $getLaws = LawCategory::whereIn('id',$attorneyLaws)->get();
            $getPackage = Lawyer::where('sub_cat_id',null)->orderby('id','ASC')->get();
            $assignedAttornies = AttorneyType::with('getCaseLaw','getCasePackage')->where('user_id',$application->user_id)->get();

            return view('admin.application-attornies-detail',compact('application','agreement','getLaws','getPackage','assignedAttornies'));
        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
