<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view_dashboard',
            'manage_students',
            'manage_teachers',
            'manage_subjects',
            'view_reports',
            'manage_schedule',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $ownerRole = Role::where('name', 'owner')->first();
        if ($ownerRole) {
            $ownerRole->syncPermissions($permissions);
        }
    }
}
