<?php

namespace ErfanMasboogh\Laran\Models;

use DateTimeInterface;
use \Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    public $primaryKey = 'ID';
    protected $dateFormat = 'U';

    public static $snakeAttributes = false;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $casts = [
        'created' => 'integer',
        'updated' => 'integer',
    ];

    public function getForeignKey(): string
    {
        return lcfirst(class_basename($this)) . $this->getKeyName();
    }
    
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('U');
    }
}
