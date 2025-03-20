<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if(Auth::user()->isAdmin()){
            return view('dashboard.dashboard');
        }else{
            return view('dashboard.dashboard');
        }
    }
}
