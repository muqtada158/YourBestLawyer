<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseAttornies;
use App\Models\Contracts;
use App\Models\CustomerContract;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;

class AdminContractController extends Controller
{

/**
 * Display a list of contracts filtered by status.
 *
 * This method retrieves contracts based on the provided filter. The available filter options are:
 * - 'Accepted': Contracts with 'Accepted' status.
 * - 'Pending': Contracts with 'Pending' status.
 * - 'Rejected': Contracts with 'Rejected' status.
 *
 * The contracts are paginated and ordered by the most recent.
 *
 * @param string $filter The status to filter contracts by. Default is 'Accepted'.
 * @return \Illuminate\View\View
 */
    public function contract($filter = 'Accepted')
    {
        try {

            if($filter === 'Accepted')
            {
                $contracts = CustomerContract::with('getAttornies.getUserDetails','getCaseDetail')
                ->where('status','Accepted')
                ->orderby('id','desc')
                ->paginate(10);
            }
            elseif($filter === 'Pending'){
                $contracts = CustomerContract::with('getAttornies.getUserDetails','getCaseDetail')
                ->where('status','Pending')
                ->orderby('id','desc')
                ->paginate(10);
            }
            else{
                $contracts = CustomerContract::with('getAttornies.getUserDetails','getCaseDetail')
                ->where('status','Rejected')
                ->orderby('id','desc')
                ->paginate(10);
            }

            return view('admin.contract',compact('contracts'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Display detailed information for a specific contract.
 *
 * Retrieves detailed information about a contract, including its associated case attorney,
 * case details, law contract, payment plan, and attorney's bid.
 *
 * @param int $contract_id The ID of the contract to retrieve details for.
 * @return \Illuminate\View\View
 */
    public function contracts_details($contract_id)
    {
        $case_attornies = CustomerContract::where('id',$contract_id)->first();
        $contract = CaseAttornies::with('getAttornies.getUserDetails','getCaseDetails')
        ->where('case_id',$case_attornies->case_id)
        ->where('attorney_id',$case_attornies->attorney_id)
        ->first();
        $getLawContract = Contracts::first();
        $paymentPlan = PaymentPlan::where('customer_id',$case_attornies->customer_id)
            ->where('case_id',$contract->getCaseDetails->id)
            ->where('status','Enabled')
            ->first();
        $getAttorneyBid = CaseAttornies::where('case_id',$contract->getCaseDetails->id)
        ->where('attorney_id',$case_attornies->getAttornies->id)
        ->first();
        return view('admin.contract-details',compact('contract','getLawContract','case_attornies','paymentPlan','getAttorneyBid'));
    }
}
