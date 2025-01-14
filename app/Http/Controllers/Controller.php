<?php

namespace App\Http\Controllers;

use App\Http\Traits\EmailTrait;
use App\Http\Traits\NotificationTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, EmailTrait, NotificationTrait;
}
