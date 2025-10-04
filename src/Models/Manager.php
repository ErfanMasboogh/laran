<?php

namespace ErfanMasboogh\Laran\Models;

use ErfanMasboogh\Laran\Models\Traits\HasStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    use HasFactory, Notifiable, HasStorage;

    public $primaryKey = 'ID';
    public $timestamps = false;
    protected $guard = 'manager';

    protected $fillable = [
        'name',
        'family',
        'mobile',
        'status',
        'imageSID',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ID' =>'integer',
            'password' => 'hashed',
            'name' => 'string',
            'family' => 'string',
            'mobile' => 'string',
            'status' => 'string',
            'imageSID' => 'string',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->family;
    }
}
