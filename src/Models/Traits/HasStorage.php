<?php

namespace ErfanMasboogh\Laran\Models\Traits;

use App\Models\User;

trait HasStorage
{
    /**
     * This method will be override by models which have the non-public storage
     * @param User|null $user
     * @return true
     */
    public function haveAccessToMedia(?User $user = null)
    {
        return true;
    }
}
