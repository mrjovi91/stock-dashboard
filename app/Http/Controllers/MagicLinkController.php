<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MagicLinkType;
use App\Models\MagicLink;

class MagicLinkController extends Controller
{
    public function generate_email_validation_link(User $user){
        $app_url = env('APP_URL', "http://stock-dashboard.test");
        $base_url = env('EMAIL_VERIFICATION_BASE_URL', "email-verification");
        $email_validation_type = MagicLinkType::where('name', "Email Validation")->get();
        $link = new MagicLink();
        $link->user = $user;
        $link->magic_link_type = $email_validation_type;
        $link->enabled = 1;
        
        $expiry = new \DateTime();
        $expiry->modify(config('magiclink.default_expiry'));
        $link->expires_at = $expiry;

        $link->save();

        $user_slug = $user->slug();
        $magic_link_slug = $link->slug();
        return "$app_url/$base_url/$user_slug/$magic_link_slug";
    }

}
