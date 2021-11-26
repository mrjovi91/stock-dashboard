<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MagicLinkType;
use App\Models\MagicLink;
use Illuminate\Support\Str;
 
class MagicLinkController extends Controller
{
    public function generate_email_validation_link(User $user){
        $link_type = MagicLinkType::where('name', "Email Validation")->get()->first();
        return $this->generate_new_magic_link($user, $link_type);
    }

    public function generate_email_validation_link_test($user_id){
        $user = User::findOrFail($user_id);
        $link_type = MagicLinkType::where('name', "Email Validation")->get()->first();
        return $this->generate_new_magic_link($user, $link_type);
    }

    public function verify_email(Request $request, $user_slug, $magic_link_slug, $hashed_magic_link){
        if (Auth::check()){
            $magic_link = MagicLink::findBySlugOrFail($magic_link_slug);
            $user = $magic_link->user();
            if (! auth()->user()->is($user)) {
                return redirect('/');
            }
        }

        $link_type = MagicLinkType::where('name', "Email Validation")->get()->first() ;
        if(!$this->link_is_valid($link_type, $user_slug, $magic_link_slug, $hashed_magic_link)){
            return redirect('/');
        }
        $user = User::findBySlugOrFail($user_slug);
        $now = new \DateTime();
        $user->email_verified_at = $now;
        $user->save();
        $this->consume_magic_link($magic_link_slug);

        flash("Account verification success!")->success();
        if (Auth::check()){
            return redirect('/');
        }
        return redirect('/login');
    }

    private function link_is_valid(MagicLinkType $link_type, $user_slug, $magic_link_slug, $provided_hashed_magic_link){
        // $test = array(
        //     "link_type" => $link_type,
        //     "user_slug" => $user_slug,
        //     "magic_link_slug" => $magic_link_slug,
        //     "hashed_magic_link" => $provided_hashed_magic_link
        // );
        // dd($test);

        $magic_link = MagicLink::findBySlugOrFail($magic_link_slug);
        if(!$magic_link->enabled === 1){
            return false;
        }

        $now = new \DateTime();
        $expiry_at = new \DateTime($magic_link->expires_at);
        if($now > $expiry_at){
            return false;
        }

        if(! is_null($magic_link->consumed_at)) {
            return false;
        }
        
        if(! $magic_link->magic_link_type()->is($link_type)){
            return false;
        }

        $provided_user = User::findBySlugOrFail($user_slug);
        if (! $magic_link->user()->is($provided_user)) {
            return false;
        }

        $hashed_magic_link = $this->generate_link_hash_for_url($magic_link);
        if ($provided_hashed_magic_link != $hashed_magic_link){
            return false;
        }
        return true;

    }

    private function consume_magic_link($magic_link_slug){
        $magic_link = MagicLink::findBySlugOrFail($magic_link_slug);
        $now = new \DateTime();
        $magic_link->consumed_at = $now;
        $magic_link->enabled = 0;
        $magic_link->save();
    }

    private function generate_new_magic_link(User $user, MagicLinkType $link_type){
       // Deactivate any existing link of same type and user before generating link
       $existing_links = MagicLink::where([
            'user_id' => $user->id,
            'magic_link_type_id' => $link_type->id,
            'enabled' => 1
        ])->get();
        if($existing_links->isNotEmpty()){
            foreach($existing_links as $existing_link){
                $existing_link->enabled = 0;
                $existing_link->save();
            }
        }

        $app_url = config('app.url');
        $base_url = config('magiclink.email_verification_base_url');

        $link = new MagicLink();
        $link->user_id = $user->id;
        $link->magic_link_type_id = $link_type->id;
        $link->enabled = 1;
        $link->random_secret = str_random(30);

        $expiry = new \DateTime();
        $expiry->modify(config('magiclink.default_expiry'));
        $link->expires_at = $expiry;

        $link->save();
        $user_slug = $user->slug();
        $magic_link_slug = $link->slug();
        $magic_link = MagicLink::findBySlugOrFail($magic_link_slug);

        $hashed_magic_link = $this->generate_link_hash_for_url($magic_link);

        return "$app_url/$base_url/$user_slug/$magic_link_slug/$hashed_magic_link";
    }

    private function generate_link_hash_for_url(MagicLink $link){
        $serialized_link = $link->toJson();
        $sig = hash_hmac('sha256', $serialized_link, $link->random_secret);
        if ($sig === false){
            return '';
        }
        return $this->base64_url_friendly_encode($sig);
    }

    private function base64_url_friendly_encode($data) {
        return str_replace(['+', '/'], ['-', '_'], base64_encode($data));
    }
    
    private function base64_url_friendly_decode($data) {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

}
