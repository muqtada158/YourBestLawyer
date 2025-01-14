<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    /**
     * Display the schedule page in the admin panel.
     *
     * This method returns the view for displaying the schedule in the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function schedule()
    {
        return view('admin.schedule');
    }
}
