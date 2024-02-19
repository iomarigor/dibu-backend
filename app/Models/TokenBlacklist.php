<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenBlacklist extends Model
{
    protected $table = 'token_blacklist';

    protected $guarded = [];
}
