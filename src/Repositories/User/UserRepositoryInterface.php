<?php

namespace ErfanMasboogh\Laran\Repositories\User;

interface UserRepositoryInterface
{
    public function create(array $data, $isPasswordHashed = false);
    public function findByMobile(string $mobile);
}
