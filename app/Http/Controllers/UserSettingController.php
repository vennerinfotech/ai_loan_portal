<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function user_setting()
    {
        return view('user_setting');
    }
}
