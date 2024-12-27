<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['owner', 'student', 'teacher', 'admin', 'coach', 'koordinator guru', 'learning material'];
        
        $permissions = [
            'view_dashboard',
            'manage_students',
            'manage_teachers',
            'manage_subjects',
            'view_reports',
            'manage_schedule',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $ownerRole = Role::where('name', 'owner')->first();
        if ($ownerRole) {
            $ownerRole->syncPermissions($permissions);
        }

        $userOwner = User::firstOrCreate(
            ['email' => 'iqbalalyansyah3@gmail.com'],
            [
                'full_name' => 'Iqbal Alyansyah',
                'phone_number' => '08123456789',
                'password' => bcrypt('iqbaladmin1234'),
                'onboarding_completed' => true,
            ]
        );

        if (!$userOwner->hasRole('owner')) {
            $userOwner->assignRole('owner');
        }
    }
}
