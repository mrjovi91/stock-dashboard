<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    function index(){
        if (!Auth::check()) {
            return redirect('/login');
        }
        if( is_null(auth()->user()->email_verified_at)) {
            return view('custom_auth.email_not_verified', ['title' => 'Account Verification']);
        }
        return view('home');
    }
}
