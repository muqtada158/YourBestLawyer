<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminMediaController extends Controller
{
      /**
     * Display the media page in the admin panel.
     *
     * This method is responsible for rendering the media view for the admin to manage
     * the platform's media files.
     *
     * @return \Illuminate\View\View
     */
    public function media()
    {
        return view('admin.media');
    }
}
