<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\MagicLinkController;
use App\Mail\EmailVerification;
use Carbon\Carbon;

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
            'email' => 'required|email|unique:users,email',
            'password' => ['required'],
            'vpassword' => ['required'],

        ]);

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
        $magic_link_controller = new MagicLinkController();
        $link = $magic_link_controller->generate_email_validation_link($new_user);
        Mail::to($new_user)->send(new EmailVerification($link));

        flash('Account created! A verification link has been sent to your email ' . $new_user->email);
        return redirect('/login');
    }

    public function resend_validation_link(Request $request){
        if (!Auth::check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        if(! is_null(auth()->user()->email_verified_at)) {
            return redirect('/');
        }
        $magic_link_controller = new MagicLinkController();
        $link = $magic_link_controller->generate_email_validation_link($user);
        Mail::to($user)->send(new EmailVerification($link));
        flash('Verification link resent! Please check your email ' . $user->email);
        return redirect('/');
    }

    private function user_exists($email_address){
        if (User::where('email', '=', $email_address)->exists()) {
            return true;
         }
         return false;
    }

}
