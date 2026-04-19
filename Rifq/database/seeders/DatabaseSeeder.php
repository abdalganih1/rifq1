<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            RolesAndPermissionsSeeder::class,
            GovernoratesSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
