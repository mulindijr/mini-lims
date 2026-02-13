<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage patients',
            'manage samples',
            'manage tests',
            'verify results',
            'release results',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $labTech = Role::firstOrCreate(['name' => 'Lab Technician']);
        $receptionist = Role::firstOrCreate(['name' => 'Receptionist']);
        $pathologist = Role::firstOrCreate(['name' => 'Pathologist']);

        // Assign permissions to roles

        // Admin gets everything
        $admin->givePermissionTo(Permission::all());

        //Receptionist permissions
        $receptionist->givePermissionTo([
            'manage patients',
            'manage samples',
        ]);

        $labTech->givePermissionTo([
            'manage samples',
            'manage tests',
        ]);

        // Pathologist permissions
        $pathologist->givePermissionTo([
            'verify results',
            'release results',
            'view reports',
        ]);
    }
}
