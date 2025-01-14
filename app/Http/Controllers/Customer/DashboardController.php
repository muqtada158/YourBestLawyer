<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
 * Display the customer dashboard.
 *
 * This function simply returns the view for the customer's dashboard page.
 * It does not retrieve or process any data but loads the customer dashboard view.
 *
 * @return \Illuminate\View\View
 */
    public function dashboard()
    {
        return view('customer.dashboard');
    }

    /**
 * Search for a case based on the customer's case number.
 *
 * This function handles the search functionality for the customer. It first searches
 * for an exact match on the case number (sr_no). If no exact match is found,
 * it performs a wildcard search using the provided search term.
 * The search is restricted to the cases associated with the logged-in customer.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\View\View
 */
    public function search(Request $request)
    {
        try {
            //get only logged in customer case
            $contracts = CustomerContract::where('customer_id',auth()->user()->id)->pluck('case_id');

            //search exact
            $search = CaseDetail::where('sr_no', (int)$request->search)->whereIn('id',$contracts)->get();

            // If no exact match found, perform wildcard search
            if ($search->isEmpty()) {
                $search = CaseDetail::where('sr_no', 'like', '%' . $request->search . '%')->whereIn('id',$contracts)->get();
            }

            return view('customer.search-ajax', compact('search'));

        } catch (\Throwable $th) {
            $search = [];
            return view('customer.search-ajax', compact('search'));
        }
    }
}
