<?php

namespace App\Http\Controllers;

use App\Models\LawCategory;
use App\Models\LawSubCategory;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
/**
 * Displays the main case details along with all enabled and pending LawCategories.
 *
 * @param int $id The ID of the LawCategory to fetch detailed data for.
 * @return \Illuminate\View\View
 */
    public function main_cases($id)
    {
        $cases_all = LawCategory::where('status', 'Enable')
                        ->orWhere('status', 'Pending')
                        ->get();

        $cases = LawCategory::with('subCategories.getLaywers')->where('id',$id)->first();
        return view('marketing.main-case',compact('cases','cases_all'));
    }
/**
 * Displays the child case details along with the related subcategories, court procedure videos,
 * and all enabled and pending LawCategories.
 *
 * @param int $id The ID of the LawSubCategory to fetch detailed data for.
 * @return \Illuminate\View\View
 */
    public function child_cases($id)
    {
        $cases_all = LawCategory::where('status', 'Enable')
                        ->orWhere('status', 'Pending')
                        ->get();

        $subCat = LawSubCategory::with('getCategory','getLaywers')->where('id',$id)->first();
        $getCourtProcedureVideos = LawSubCategory::where('cat_id',17)->get();

        $subCat_all =  LawSubCategory::where('cat_id',$subCat->cat_id)->where('id','!=',$subCat->id)->get();
        return view('marketing.child-case',compact('subCat','cases_all','subCat_all','getCourtProcedureVideos'));
    }

}
