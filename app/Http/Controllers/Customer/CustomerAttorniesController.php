<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AttorneyReviews;
use App\Models\CaseAttornies;
use App\Models\CustomerContract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerAttorniesController extends Controller
{

        /**
     * Display a list of hired attorneys for the customer.
     *
     * This method retrieves all accepted contracts for the logged-in customer,
     * including associated attorney details, case bids, and case law information.
     * The data is paginated to display 10 results per page.
     *
     * @return \Illuminate\View\View
     */
    public function attornies()
    {
        try {
            $user_id = auth()->user()->id;

            $hiredAttornies = CustomerContract::with('getAttornies.getUserDetails',
            'getCaseDetail.getCaseBid', 'getCaseDetail.getCaseLaw','caseAttorneyBid')
            ->where('customer_id', $user_id)
            ->where('status', 'Accepted')
            ->paginate(10);

            return view('customer.attornies',compact('hiredAttornies'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

        /**
     * Display the details of a specific hired attorney.
     *
     * This method retrieves detailed information for a specific attorney's contract,
     * including associated case details, bid information, case status counts, ratings,
     * and reviews. It calculates the total, ongoing, pending, and ended case counts
     * for the given attorney.
     *
     * @param int $id The ID of the customer contract for the attorney
     * @return \Illuminate\View\View
     */
    public function attornies_details($id)
    {
        try {

            $hiredAttorneyDetails = CustomerContract::with('getAttornies.getUserDetails',
            'getCaseDetail.getCaseBid', 'getCaseDetail.getCaseLaw','caseAttorneyBid')
            ->where('id', $id)
            ->where('status', 'Accepted')
            ->first();

            $caseCounts = [];
            //case counts of attornies
            if ($hiredAttorneyDetails) {
                $casesTotal = CustomerContract::where('attorney_id',$hiredAttorneyDetails->getAttornies->id)
                ->get()
                ->count();

                $casesOngoing = CustomerContract::where('attorney_id',$hiredAttorneyDetails->getAttornies->id)
                ->where('status','Accepted')
                ->get()
                ->count();

                $casesPending = CustomerContract::where('attorney_id',$hiredAttorneyDetails->getAttornies->id)
                ->where('status','Pending')
                ->get()
                ->count();

                $casesEnded = CustomerContract::where('attorney_id',$hiredAttorneyDetails->getAttornies->id)
                ->where('status','Ended')
                ->get()
                ->count();

                $caseCounts = [
                    'total_cases' => $casesTotal,
                    'ongoing_cases' => $casesOngoing,
                    'pending_cases' => $casesPending,
                    'ended_cases' => $casesEnded,
                ];
            }

            $ratings = $hiredAttorneyDetails->getAttornies->getRatings;
            $average_rating = round($ratings->avg('rating'));

            $attorneyReviews = AttorneyReviews::where('attorney_id',$hiredAttorneyDetails->getAttornies->id)->first();

            return view('customer.attornies-detail',compact('hiredAttorneyDetails','caseCounts','average_rating','attorneyReviews'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
