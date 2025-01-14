<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class AttorneyFaqsController extends Controller
{
    /**
 * Fetches and displays a list of frequently asked questions (FAQs) that are enabled.
 *
 * This method retrieves all FAQs that are marked as 'Enabled' and orders them
 * in ascending order by their ID. The FAQs are then passed to the view for display.
 *
 * @return \Illuminate\View\View The view displaying the list of FAQs.
 */
    public function faqs()
    {
        $faqs = Faq::where('faq_status','Enabled')->orderby('id','ASC')->get();
        return view('attorney.faqs',compact('faqs'));
    }
}
