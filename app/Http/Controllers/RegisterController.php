<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    function index(){
        if (Auth::check()){
            return redirect('/');
        }
        return view('custom_auth.register', ['title' => 'Register']);
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'vpassword' => ['required'],

        ]);

        if ($this->user_exists($credentials['email'])){
            flash('Email Address has been registered before.')->error();
            return back();
        }

        if ($credentials['password'] != $credentials['vpassword']){
            flash('Password does not match!')->error();
            return back();
        }

        $new_user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password'])
        ]);

        if (!$new_user->exists) {
            flash('An error occured during creation.\nPlease try again later.')->error();
            return back();
        } 
        flash('Account created! Login to get started.');
        return redirect('/login');
    }

    private function user_exists($email_address){
        if (User::where('email', '=', $email_address)->exists()) {
            return true;
         }
         return false;
    }

}
