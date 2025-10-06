<?php

namespace Database\Seeders;

use ErfanMasboogh\Laran\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managerInfo = [
            'name' => 'Laran',
            'family' => 'Admin',
            'mobile' => '9930000000',
            'password' => Hash::make('1234'),
        ];

        Manager::updateOrCreate($managerInfo);
    }
}
