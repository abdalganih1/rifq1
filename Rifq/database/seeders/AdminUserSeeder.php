<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('role_name', 'Admin')->first();

        if (!$adminRole) {
            $this->command->error('Admin role not found! Please run RoleSeeder first.');
            return;
        }

        $admin = User::create([
            'role_id' => $adminRole->id,
            'organization_id' => null,
            'first_name' => 'System',
            'last_name' => 'Admin',
            'username' => 'admin',
            'gender' => 'Male',
            'national_id' => '1234567890',
            'birth_date' => '1990-01-01',
            'email' => 'admin@rifq.com',
            'password' => Hash::make('admin123'),
            'phone_number' => '+9647700000000',
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@rifq.com');
        $this->command->info('Username: admin');
        $this->command->info('Password: admin123');
    }
}
