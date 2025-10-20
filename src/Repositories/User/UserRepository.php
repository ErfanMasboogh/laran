<?php

namespace ErfanMasboogh\Laran\Repositories\User;

use ErfanMasboogh\Laran\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data, $isPasswordHashed = false)
    {
        return User::query()
            ->create([
                'mobile' => $data['mobile'],
                'password' => $isPasswordHashed ? $data['password'] : Hash::make($data['password']),
            ]);
    }

    public function findByMobile(string $mobile)
    {
        return User::query()
            ->where('mobile', $mobile)
            ->first();
    }
}
