<?php

namespace App\Models;

use App\Models\User;
use App\Models\MagicLinkType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class MagicLink extends Model
{
    use HasFactory, HasHashSlug;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function magic_link_type()
    {
        return $this->hasOne(User::class);
    }

}