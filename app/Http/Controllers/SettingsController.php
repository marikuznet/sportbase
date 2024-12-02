<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfile(){
        return view('profileExecutor.settings');
    }

    public function showNotification(){
        return view('profileExecutor.notification');
    }

    public function showSecurity(){
        return view('profileExecutor.security');
    }

    public function showPayment(){
        return view('profileExecutor.payment');
    }
}
