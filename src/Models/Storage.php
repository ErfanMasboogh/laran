<?php

namespace ErfanMasboogh\Laran\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Storage extends Model
{
    public $primaryKey = 'SID';
    public $keyType = 'string';
    public $incrementing = false;
    public $table = 'storage';

    protected $fillable = [
        'SID',
        'userID',
        'storable_type',
        'storable_id',
        'fileType',
        'fileName',
        'fileExtension',
        'fileSize',
        'isUsed',
        'isPublic',
    ];

    protected $casts = [
      'SID' => 'string',
      'userID' => 'integer',
      'storable_type' => 'string',
      'storable_id' => 'integer',
      'fileType' => 'string',
      'fileName' => 'string',
      'fileExtension' => 'string',
      'fileSize' => 'integer',
      'isUsed' => 'boolean',
      'isPublic' => 'boolean',
      'created' => 'integer',
      'updated' => 'integer',
    ];
}
