<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttorneyMediaController extends Controller
{
    public function media()
    {
        return view('attorney.media');
    }
}
