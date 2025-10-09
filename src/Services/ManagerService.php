<?php

namespace ErfanMasboogh\Laran\Services;

use ErfanMasboogh\Laran\Models\Manager;
use ErfanMasboogh\Laran\Models\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ManagerService
{
    /**
     * @param array $data
     * @return Manager
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

    /**
     * @param Manager $manager
     * @param array $data
     * @return Manager
     */
    public function updateManager(Manager $manager, array $data)
    {
        $shouldUpdatePassword = isset($data['password']);

        if ($shouldUpdatePassword) {
            if (!Hash::check($data['currentPassword'], $manager->password)) {
                throw ValidationException::withMessages([
                    'currentPassword' => lt('Wrong current password'),
                ]);
            }
        }

        $hasImage = isset($data['image']);

        if ($hasImage) {
            Storage::deleteBySID($manager->imageSID);

            $storage = Storage::upload($data['image']);
        }

        $manager->update([
                'name' => $data['name'],
                'family' => $data['family'],
                'mobile' => $data['mobile'],
                'password' => isset($data['password']) ? Hash::make($data['password']) : $manager->password,
                'imageSID' => $hasImage ? $storage->SID : $manager->imageSID,
            ]);

        if ($hasImage) {
            $storage->useFor($manager);
        }

        return $manager;
    }

    /**
     * @param Manager $manager
     * @return void
     */
    public function deleteManager(Manager $manager)
    {
        $hasImage = isset($manager->imageSID);

        if ($hasImage) {
            Storage::deleteBySID($manager->imageSID);
        }

        $manager->delete();
    }
}
