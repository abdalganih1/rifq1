<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'Admin',
                'description' => 'System administrator with full access to all features and settings'
            ],
            [
                'role_name' => 'Vet',
                'description' => 'Veterinarian who can view animal profiles and add medical records'
            ],
            [
                'role_name' => 'Citizen',
                'description' => 'Regular citizen who can view available animals and submit adoption requests'
            ],
            [
                'role_name' => 'Organization_Rep',
                'description' => 'Organization representative who can manage animals and approve adoption requests'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
