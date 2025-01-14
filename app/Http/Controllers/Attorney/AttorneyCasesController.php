<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\CaseAttornies;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;

class AttorneyCasesController extends Controller
{

    /**
 * Displays the cases for the authenticated attorney, showing the total, ongoing, pending, and ended cases.
 *
 * @return \Illuminate\View\View The view displaying the case statistics for the attorney.
 */
    public function cases()
    {
        try {
            $attorney_id = auth()->user()->id;

            $contractsTotal = CustomerContract::where('attorney_id',$attorney_id)->where('status','!=','Rejected')->pluck('case_id');
            $casesTotal = CaseDetail::wherein('id',$contractsTotal)->where('case_status','!=',null)->count();

            $contractsOngoing = CustomerContract::where('attorney_id',$attorney_id)->where('status','Accepted')->pluck('case_id');
            $casesOngoing = CaseDetail::wherein('id',$contractsOngoing)->where('case_status','Accepted')->count();

            $contractsPending = CustomerContract::where('attorney_id',$attorney_id)->where('status','!=','Rejected')->pluck('case_id');
            $casesPending = CaseDetail::wherein('id',$contractsPending)->where('case_status','Pending')->count();

            $contractsEnded = CustomerContract::where('attorney_id',$attorney_id)->where('status','Accepted')->pluck('case_id');
            $casesEnded = CaseDetail::wherein('id',$contractsEnded)->where('case_status','Ended')->count();

            return view('attorney.cases',compact('casesTotal','casesOngoing','casesPending','casesEnded'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

/**
 * Displays all cases with the option to filter by total, ongoing, pending, or ended cases.
 *
 * @param string|null $filter The filter option for case status ('total', 'ongoing', 'pending', 'ended').
 * @return \Illuminate\View\View The view displaying all cases based on the selected filter.
 */
    public function all_cases($filter = null)
    {
        try {
            $attorney_id = auth()->user()->id;
            switch ($filter) {
                case 'total':
                    $contracts = CustomerContract::where('attorney_id',$attorney_id)->where('status','!=','Rejected')->pluck('case_id');
                    $cases = CaseDetail::wherein('id',$contracts)->where('case_status','!=',null)->orderby('id','DESC')->paginate(10);
                    break;
                case 'ongoing':
                    $contracts = CustomerContract::where('attorney_id',$attorney_id)->where('status','Accepted')->pluck('case_id');
                    $cases = CaseDetail::wherein('id',$contracts)->where('case_status','Accepted')->orderby('id','DESC')->paginate(10);
                    break;
                case 'pending':
                    $contracts = CustomerContract::where('attorney_id',$attorney_id)->where('status','!=','Rejected')->pluck('case_id');
                    $cases = CaseDetail::wherein('id',$contracts)->where('case_status','Pending')->orderby('id','DESC')->paginate(10);
                    break;
                case 'ended':
                    $contracts = CustomerContract::where('attorney_id',$attorney_id)->where('status','Accepted')->pluck('case_id');
                    $cases = CaseDetail::wherein('id',$contracts)->where('case_status','Ended')->orderby('id','DESC')->paginate(10);
                    break;
                default:
                    $alert = [
                        'message' => 'Error invalid filter used...',
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert);
                    break;
            }
            return view('attorney.cases-all',compact('cases'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Displays the ongoing cases page for the attorney.
 *
 * @return \Illuminate\View\View The view for displaying ongoing cases.
 */
    public function ongoing_cases()
    {
        return view('attorney.cases-ongoing');
    }

    /**
 * Displays the details of a specific case by its ID.
 *
 * @param int $case_id The ID of the case to view.
 * @return \Illuminate\View\View The view displaying the case details.
 */
    public function case_details($case_id)
    {
        try {

            $case = CaseDetail::with('getCaseMedia','getDynamicFormValues','getUser.getUserDetails','getCaseLaw','getCaseBid','getAcceptedCustomerContracts')->findOrFail($case_id);
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
            return view('attorney.case-details',compact('case','interested_attornies','customer_contract','paymentPlan','dynamicForms'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    /**
 * Ends a case by the attorney based on the case ID and attorney ID.
 *
 * @param int $case_id The ID of the case to end.
 * @param int $attorney_id The ID of the attorney ending the case.
 * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
 */
    public function end_case_by_attorney($case_id,$attorney_id)
    {
        try {
            $contract = CustomerContract::where('case_id',$case_id)
            ->where('attorney_id',$attorney_id)
            ->where('status','Accepted')
            ->first();

            if(isset($contract) && $contract->getCaseDetail->getCasePackage->sub_cat_id == 18 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 19 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 20)
            {
                $case = CaseDetail::findOrFail($contract->case_id);
                    $case->case_status = 'Ended';
                    $case->save();
                    $alert = [
                        'message' => 'Case ended successfully.',
                        'alert-type' => 'success'
                    ];
            }else{

                if($contract)
                {
                    $paymentPlan = PaymentPlan::where('case_id',$case_id)
                    ->where('attorney_id',$attorney_id)
                    ->first();
                    if($paymentPlan->payment_status != 'Paid')
                    {
                        $alert = [
                            'message' => 'Case payments are not paid / clear.',
                            'alert-type' => 'error'
                        ];
                        return back()->with($alert);
                    }
                    $case = CaseDetail::findOrFail($contract->case_id);
                    $case->case_status = 'Ended';
                    $case->save();
                    $alert = [
                        'message' => 'Case ended successfully.',
                        'alert-type' => 'success'
                    ];
                }else{
                    $alert = [
                        'message' => 'Case not found.',
                        'alert-type' => 'error'
                    ];
                }
            }
                //sending email to attorney
                $this->sendEmail(
                    $contract->getCustomer->email,
                    'Your Case has been ended.',
                    'Congratulations, Your Case Sr No # '.$contract->getCaseDetail->sr_no.' has been ended by attorney. Go to dashboard to review the attorney.'
                );
            return back()->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }


}
