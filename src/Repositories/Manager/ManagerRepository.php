<?php

namespace ErfanMasboogh\Laran\Repositories\Manager;

use ErfanMasboogh\Laran\Models\Manager;
use Illuminate\Support\Facades\Hash;

class ManagerRepository implements ManagerRepositoryInterface
{
    public function create(array $data, string $imageSID = null)
    {
        return Manager::query()
            ->create([
                'name' => $data['name'],
                'family' => $data['family'],
                'mobile' => $data['mobile'],
                'password' => Hash::make($data['password']),
                'imageSID' => $imageSID,
            ]);
    }

    public function update(Manager $manager, array $data, string $imageSID = null)
    {
        return $manager->update([
            'name' => $data['name'],
            'family' => $data['family'],
            'mobile' => $data['mobile'],
            'password' => $data['password'],
            'imageSID' => $imageSID,
        ]);
    }

    public function delete(Manager $manager)
    {
        return $manager->delete();
    }
}
