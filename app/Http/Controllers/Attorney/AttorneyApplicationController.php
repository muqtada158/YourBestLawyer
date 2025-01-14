<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttorneyApplicationController extends Controller
{
    /**
 * Displays the list of applications for attorneys.
 *
 * @return \Illuminate\View\View The view showing the applications list.
 */
    public function application()
    {
        return view('attorney.applications');
    }

    /**
 * Displays the form for adding a new application.
 *
 * @return \Illuminate\View\View The view for adding a new application.
 */
    public function add_application()
    {
        return view('attorney.applications-add');
    }

    /**
 * Displays the initial process of the application for attorneys.
 *
 * @return \Illuminate\View\View The view showing the initial process of the application.
 */
    public function application_initial_process()
    {
        return view('attorney.application-initial-process');
    }
}
