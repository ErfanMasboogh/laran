<?php

namespace ErfanMasboogh\Laran\Models;

use ErfanMasboogh\Laran\Models\Traits\HasStorage;

class User extends Model 
{
    use HasStorage;

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
