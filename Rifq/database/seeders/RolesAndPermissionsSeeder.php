<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage-users', 'manage-teams', 'manage-governorates',
            'manage-animals', 'enter-data', 'view-animals',
            'manage-adoptions', 'request-adoption', 'run-ai-scan',
            'manage-trash', 'generate-qr', 'print-qr',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $roles = [
            'admin' => $permissions,
            'data_entry' => ['enter-data', 'view-animals', 'generate-qr', 'print-qr', 'manage-animals'],
            'vet' => ['view-animals', 'enter-data', 'run-ai-scan', 'manage-animals'],
            'citizen' => ['view-animals', 'request-adoption'],
        ];

        foreach ($roles as $roleName => $rolePerms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($rolePerms);
        }
    }
}
