<?php

namespace ErfanMasboogh\Laran\Models;

use ErfanMasboogh\Laran\Models\Traits\HasStorage;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasStorage;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'family',
        'mobile',
        'email',
        'password',
    ];

    protected $casts = [
        'ID' => 'integer',
        'name' => 'string',
        'family' => 'string',
        'mobile' => 'string',
        'email' => 'string',
        'password' => 'string',
        'created' => 'integer',
        'updated' => 'integer',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
