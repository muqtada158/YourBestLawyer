<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseAttornies;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;

class AdminCasesController extends Controller
{
/**
 * Display a summary of cases grouped by their statuses.
 *
 * Retrieves the total number of cases and counts for cases categorized as ongoing, pending, and ended.
 * Returns a view with the summarized data.
 *
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */
    public function cases()
    {
        try {
            $casesTotal = CaseDetail::where('case_status','!=',null)->count();

            $casesOngoing = CaseDetail::where('case_status','Accepted')->count();

            $casesPending = CaseDetail::where('case_status','Pending')->count();

            $casesEnded = CaseDetail::where('case_status','Ended')->count();

            return view('admin.cases',compact('casesTotal','casesOngoing','casesPending','casesEnded'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Display a list of cases based on a specific filter.
 *
 * Filters include: all, ongoing, pending, and ended cases.
 * If an invalid filter is provided, an error alert is returned.
 *
 * @param string|null $filter The filter to apply (default is null).
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */
    public function all_cases($filter = null)
    {
        try {
            $attorney_id = auth()->user()->id;
            switch ($filter) {
                case 'all':
                    $cases = CaseDetail::where('application_status','Accepted')->where('case_status','!=',null)->orderby('id','DESC')->paginate(10);
                    break;
                case 'ongoing':
                    $cases = CaseDetail::where('application_status','Accepted')->where('case_status','Accepted')->orderby('id','DESC')->paginate(10);
                    break;
                case 'pending':
                    $cases = CaseDetail::where('application_status','Accepted')->where('case_status','Pending')->orderby('id','DESC')->paginate(10);
                    break;
                case 'ended':
                    $cases = CaseDetail::where('application_status','Accepted')->where('case_status','Ended')->orderby('id','DESC')->paginate(10);
                    break;
                default:
                    $alert = [
                        'message' => 'Error invalid filter used...',
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert);
                    break;
            }
            return view('admin.cases-all',compact('cases'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
        return view('admin.cases-all');
    }

    /**
 * Display a page for ongoing cases.
 *
 * This function currently returns a static view for ongoing cases.
 *
 * @return \Illuminate\View\View
 */
    public function ongoing_cases()
    {
        return view('admin.cases-ongoing');
    }

    /**
 * Display detailed information for a specific case.
 *
 * Retrieves case details including media, dynamic form values, user details, law categories, bids,
 * customer contracts, and payment plans associated with the case.
 * If the case is not found or an error occurs, an error alert is returned.
 *
 * @param int $case_id The ID of the case to display details for.
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */
    public function case_details($case_id)
    {
        try {

            $case = CaseDetail::with('getCaseMedia','getDynamicFormValues','getUser.getUserDetails','getCaseLaw','getCaseBid','getAcceptedCustomerContracts')
            ->where('application_status','Accepted')
            ->findOrFail($case_id);

            $interested_attornies = CaseAttornies::where('case_id',$case->id)->where('status','Interested')->get();

            $customer_contract = CustomerContract::where('case_id',$case->id)
            ->where('customer_id',$case->getUser->id)
            ->where('status','!=',"Rejected")
            ->first();

            $paymentPlan = PaymentPlan::where('customer_id',$case->user_id)
            ->where('case_id',$case->id)
            ->where('status','Enabled')
            ->first();

            $dynamicForms = null;
            if($case->getDynamicFormValues)
            {
                $dynamicForms = json_decode($case->getDynamicFormValues->form_values);
            }
            return view('admin.case-details',compact('case','interested_attornies','customer_contract','paymentPlan','dynamicForms'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
