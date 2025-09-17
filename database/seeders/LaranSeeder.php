<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(ManagerSeeder::class);
    }
}
