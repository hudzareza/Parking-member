<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // daftar permissions
        $permissions = [
            'manage branches',
            'manage tariffs',
            'manage members',
            'manage vehicles',
            'manage invoices',
            'manage payments',
            'view reports',
            'view dashboard',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $pusat      = Role::firstOrCreate(['name' => 'pusat']);
        $cabang     = Role::firstOrCreate(['name' => 'cabang']);
        $member     = Role::firstOrCreate(['name' => 'member']);

        // assign permissions
        $superAdmin->syncPermissions(Permission::all());

        $pusat->syncPermissions([
            'manage branches',
            'manage tariffs',
            'view reports',
            'view dashboard',
        ]);

        $cabang->syncPermissions([
            'manage members',
            'manage vehicles',
            'manage invoices',
            'manage payments',
            'view reports',
            'view dashboard',
        ]);

        $member->syncPermissions([
            'view dashboard',
            'manage payments',
        ]);
    }
}
