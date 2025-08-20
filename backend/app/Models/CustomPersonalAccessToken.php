<?php

namespace App\Models;

use App\Traits\HasUlid;
use Laravel\Sanctum\PersonalAccessToken;

class CustomPersonalAccessToken extends PersonalAccessToken
{
     use HasUlid;

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'id',
        'name',
        'tokenable_type',
        'tokenable_id',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];
}
