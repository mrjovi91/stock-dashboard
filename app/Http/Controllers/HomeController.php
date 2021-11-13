<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(){
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('home');
    }
}
