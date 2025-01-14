<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttorneyInviteController extends Controller
{
    public function invite()
    {
        return view('attorney.invite');
    }
    public function invite_received()
    {
        return view('attorney.invite-received');
    }
    public function invite_sent()
    {
        return view('attorney.invite-sent');
    }
    public function invite_send()
    {
        return view('attorney.invite-send');
    }
}
