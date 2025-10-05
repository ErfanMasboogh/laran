<?php

namespace ErfanMasboogh\Laran\Services;

use ErfanMasboogh\Laran\Models\Manager;
use ErfanMasboogh\Laran\Models\Storage;
use Illuminate\Support\Facades\Hash;

class ManagerService
{
    /**
     * @param array $data
     * @return Manager|\Illuminate\Database\Eloquent\Model
     */
    public function createManager(array $data)
    {
        $hasImage = isset($data['image']);

        if ($hasImage) {
            $storage = Storage::upload($data['image']);
        }

        $manager = Manager::query()
            ->create([
                'name' => $data['name'],
                'family' => $data['family'],
                'mobile' => $data['mobile'],
                'password' => Hash::make($data['password']),
                'imageSID' => $hasImage ? $storage->SID : null,
            ]);

        if ($hasImage) {
            $storage->useFor($manager);
        }

        return $manager;
    }
}
