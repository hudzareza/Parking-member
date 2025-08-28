<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role Super Admin
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);

        // Buat permission contoh (opsional, bisa tambah sesuai kebutuhan)
        $permissions = ['manage members', 'manage vehicles', 'manage invoices'];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign semua permission ke Super Admin
        $superAdmin->syncPermissions(Permission::all());

        // Assign role ke user id=1 (super admin pertama)
        $user = User::find(1);
        if ($user) {
            $user->assignRole($superAdmin);
        }
    }
}
