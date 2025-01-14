<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerVideoController extends Controller
{
    public function videos()
    {
        return view('customer.videos');
    }
    public function video_details()
    {
        return view('customer.videos-details');
    }
}
