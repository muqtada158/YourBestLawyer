<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
 * Display the dashboard for the logged-in attorney.
 *
 * This method retrieves the number of "Pending" contracts associated with the logged-in attorney
 * and passes that count to the dashboard view.
 *
 * @return \Illuminate\View\View
 */
    public function dashboard()
    {
        $contracts = CustomerContract::where('attorney_id',auth()->user()->id)->where('status','Pending')->count();
        return view('attorney.dashboard',compact('contracts'));
    }
/**
 * Search for a case based on the case serial number.
 *
 * This method performs a search for the specified case serial number within the logged-in attorney's
 * cases. It first attempts an exact match search and then a wildcard search if no exact match is found.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\View\View
 */
    public function search(Request $request)
    {
        try {
            //get only logged in attorney case
            $contracts = CustomerContract::where('attorney_id',auth()->user()->id)->pluck('case_id');

            //search exact
            $search = CaseDetail::where('sr_no', (int)$request->search)->whereIn('id',$contracts)->get();

            // If no exact match found, perform wildcard search
            if ($search->isEmpty()) {
                $search = CaseDetail::where('sr_no', 'like', '%' . $request->search . '%')->whereIn('id',$contracts)->get();
            }

            return view('attorney.search-ajax', compact('search'));

        } catch (\Throwable $th) {
            $search = [];
            return view('attorney.search-ajax', compact('search'));
        }
    }
}
