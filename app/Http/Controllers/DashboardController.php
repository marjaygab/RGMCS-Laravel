<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        if (session()->has('current_user')) {
            return view('dashboard',['current_user'=>session()->get("current_user")]);
        }else{
            return redirect('/')->withErrors(['msg'=>"Please login to continue."]);
        }
    }
}
