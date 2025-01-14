<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerInviteController extends Controller
{
    public function invite()
    {
        return view('customer.invite');
    }
    public function invite_received()
    {
        return view('customer.invite-received');
    }
    public function invite_sent()
    {
        return view('customer.invite-sent');
    }
    public function invite_send()
    {
        return view('customer.invite-send');
    }
}
