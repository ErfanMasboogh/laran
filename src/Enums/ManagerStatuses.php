<?php

namespace ErfanMasboogh\Laran\Enums;

use ErfanMasboogh\Laran\Enums\Traits\HasEnumOptions;

enum ManagerStatuses: string
{
    use HasEnumOptions;
    
    case Active = 'active';
    case Inactive = 'inactive';
    case Deleted = 'deleted';
}
