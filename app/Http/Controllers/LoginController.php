<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use App\Models\User;

class LoginController extends Controller
{
    function index(){
        if (Auth::check()){
            return redirect('/');
        }
        return view('custom_auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user()->email;
            flash("Login as $user")->success();
            return redirect('/');
        }

        flash('Login failed.')->error();
        return back();
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return redirect('/login');
    }

}
