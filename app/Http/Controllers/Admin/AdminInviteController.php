<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminInviteController extends Controller
{
    public function invite()
    {
        return view('admin.invite');
    }
}
