<?php

namespace ErfanMasboogh\Laran\Services;

use ErfanMasboogh\Laran\Models\Manager;
use ErfanMasboogh\Laran\Models\Storage;
use ErfanMasboogh\Laran\Repositories\Manager\ManagerRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ManagerService
{
    protected $managerRepo;

    public function __construct(ManagerRepository $managerRepo)
    {
        $this->managerRepo = $managerRepo;
    }

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

        $manager = $this->managerRepo->create($data, $hasImage ? $storage->SID : null);

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

        $data['password'] = isset($data['password']) ? Hash::make($data['password']) : $manager->password;

        $this->managerRepo->update($manager, $data, $hasImage ? $storage->SID : $manager->imageSID);

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

        $this->managerRepo->delete($manager);
    }
}
