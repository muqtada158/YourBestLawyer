<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminFaqsController extends Controller
{
    /**
 * Display the FAQ page.
 *
 * This method returns the view for the FAQ page in the admin panel.
 *
 * @return \Illuminate\View\View
 */
    public function faqs()
    {
        return view('admin.faqs');
    }
}
