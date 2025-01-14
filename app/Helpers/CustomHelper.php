<?php

use App\Models\CaseAttornies;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use App\Models\CustomerFeedback;
use App\Models\User;
use App\Models\YblFee;

if (!function_exists('getUser')) {
    /**
     * Format the given date.
     *
     * @param  string  $date
     * @return string
     */
    function getUser()
    {
        if(auth()->check())
        {
            $user = User::with('getUserDetails')->where('id',auth()->user()->id)->first();
        }else{
            $user = null;
        }
        return $user;
    }
}
if (!function_exists('truncate_text')) {
    function truncate_text($text, $limit = 150, $ellipsis = '...') {
        return strlen($text) > $limit ? substr($text, 0, $limit) . $ellipsis : $text;
    }
}
if (!function_exists('countCustomer')) {
    function countCustomer() {
        $user = User::where('user_type','customer')->count();
        return $user;
    }
}
if (!function_exists('countAttorney')) {
    function countAttorney() {
        $user = User::where('user_type','attorney')->count();
        return $user;
    }
}
if (!function_exists('countLeads')) {
    function countLeads() {
        try {
            //get attorney
            $attorney = User::with('getAttorneyType')->where('id',auth()->user()->id)->first();

            //case ids to reject
            $caseIdsToReject = CaseAttornies::where('attorney_id', auth()->user()->id)
                ->pluck('case_id')
                ->toArray();

            $attorneyTypes = $attorney->getAttorneyType;
            // Retrieve all cases matching the initial criteria
                $casesQuery = CaseDetail::with('getCaseMedia', 'getCaseBid', 'getCaseLaw', 'getCasePackage', 'getUser.getUserDetails')
                ->where('application_status', 'Accepted')
                ->where('case_status', 'Pending')
                ->whereNotIn('id', $caseIdsToReject); // Exclude the cases with IDs in $caseIdsToReject

            // Add the complex where condition for matching case_type and lawyer_type pairs
            $casesQuery->where(function ($query) use ($attorneyTypes) {
                foreach ($attorneyTypes as $attorneyType) {
                    $query->orWhere(function ($subQuery) use ($attorneyType) {
                        $subQuery->where('case_type', $attorneyType->law_cat_id)
                                ->where('lawyer_type', $attorneyType->lawyer_id);
                    });
                }
            });

            // Order by ID and paginate
            $cases = $casesQuery->count();

            return $cases;

        } catch (\Throwable $th) {
            return 0;
        }
    }
}
if (!function_exists('countHiredAttorney')) {
    function countHiredAttorney() {
        $hiredAttornies = CustomerContract::with('getAttornies.getUserDetails',
            'getCaseDetail.getCaseBid', 'getCaseDetail.getCaseLaw','caseAttorneyBid')
            ->where('customer_id', auth()->user()->id)
            ->where('status', 'Accepted')
            ->count();
        return $hiredAttornies;
    }
}
if (!function_exists('countCustomerCases')) {
    function countCustomerCases() {
        $totalCases = CaseDetail::where('user_id',auth()->user()->id)->where('case_status','!=',null)->count();
        return $totalCases;
    }
}
if (!function_exists('countAttorneyCases')) {
    function countAttorneyCases() {
        $contracts = CustomerContract::where('attorney_id',auth()->user()->id)->where('status','!=','Rejected')->pluck('case_id');
        $totalCases = CaseDetail::wherein('id',$contracts)->where('case_status','!=',null)->count();
        return $totalCases;
    }
}
if (!function_exists('yblFee')) {
    function yblFee() {
        $getYblFee = YblFee::find(1);
        $yblFee = $getYblFee->ybl_fee;
        return $yblFee;
    }
}

if (!function_exists('attorneyRatings')) {
    function attorneyRatings($attorney_id) {
        $ratings = CustomerFeedback::where('attorney_id',$attorney_id)->get()->pluck('rating')->toArray();
        if(!$ratings)
        {
            $ratings = [0];
        }
        $averageRating = round(array_sum($ratings) / count($ratings));
        return $averageRating;
    }
}
