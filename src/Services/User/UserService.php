<?php

namespace ErfanMasboogh\Laran\Services\User;


use ErfanMasboogh\Laran\Models\User;
use ErfanMasboogh\Laran\Repositories\User\UserRepository;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param array $data
     * @param bool $isPasswordHashed
     * @return User
     */
    public function createUser(array $data, bool $isPasswordHashed = false)
    {
        return $this->userRepo->create($data, $isPasswordHashed);
    }
}
