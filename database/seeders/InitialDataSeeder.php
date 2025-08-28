<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Branch, Member, Vehicle, Tariff};
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // === Roles & Permissions ===
        $roles = [
            'super-admin',
            'pusat',
            'cabang',
            'member'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name'       => $roleName,
                'guard_name' => 'web'
            ]);
        }

        $permissions = [
            'manage branches',
            'manage members',
            'manage vehicles',
            'manage tariffs',
            'manage invoices',
            'manage payments',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name'       => $perm,
                'guard_name' => 'web'
            ]);
        }

        // Assign permissions ke masing-masing role
        $superAdmin = Role::where('name', 'super-admin')->first();
        $pusat      = Role::where('name', 'pusat')->first();
        $cabang     = Role::where('name', 'cabang')->first();

        if ($superAdmin) $superAdmin->syncPermissions($permissions); // full akses
        if ($pusat) $pusat->syncPermissions(['manage branches', 'manage members', 'manage tariffs']);
        if ($cabang) $cabang->syncPermissions(['manage members', 'manage vehicles', 'manage invoices', 'manage payments']);
        // role 'member' tidak diberi permission (cukup UI terbatas)

        // === Seed Data ===
        // 1. Cabang contoh
        $branch = Branch::firstOrCreate(
            ['code' => 'CBG-001'],
            [
                'name'    => 'Cabang Utama',
                'address' => 'Jl. Merdeka No.1',
                'city'    => 'Jakarta',
                'active'  => true
            ]
        );

        // 2. Super Admin
        $super = User::firstOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('password'),
                'branch_id' => null
            ]
        );
        $super->syncRoles(['super-admin']);

        // 3. User Pusat
        $pusatUser = User::firstOrCreate(
            ['email' => 'pusat@admin.com'],
            [
                'name'      => 'User Pusat',
                'password'  => Hash::make('password'),
                'branch_id' => null
            ]
        );
        $pusatUser->syncRoles(['pusat']);

        // 4. User Cabang
        $cabangUser = User::firstOrCreate(
            ['email' => 'cabang@admin.com'],
            [
                'name'      => 'User Cabang',
                'password'  => Hash::make('password'),
                'branch_id' => $branch->id
            ]
        );
        $cabangUser->syncRoles(['cabang']);

        // 5. Member + User
        $memberUser = User::firstOrCreate(
            ['email' => 'member@test.com'],
            [
                'name'      => 'Member Contoh',
                'password'  => Hash::make('password'),
                'branch_id' => $branch->id
            ]
        );
        $memberUser->syncRoles(['member']);

        $member = Member::firstOrCreate(
            ['user_id' => $memberUser->id],
            [
                'branch_id'      => $branch->id,
                'joined_at'      => Carbon::today(),
                'phone'          => '08123456789',
                'id_card_number' => '1234567890'
            ]
        );

        Vehicle::firstOrCreate(
            [
                'member_id'    => $member->id,
                'plate_number' => 'B1234XYZ'
            ],
            [
                'vehicle_type' => 'motor',
                'brand'        => 'Honda',
                'model'        => 'Vario 125'
            ]
        );

        // 6. Tarif Global
        Tariff::firstOrCreate(
            [
                'branch_id'       => null,
                'vehicle_type'    => 'motor',
                'effective_start' => Carbon::parse('2025-01-01')
            ],
            ['amount_cents' => 50000 * 100]
        );

        Tariff::firstOrCreate(
            [
                'branch_id'       => null,
                'vehicle_type'    => 'mobil',
                'effective_start' => Carbon::parse('2025-01-01')
            ],
            ['amount_cents' => 100000 * 100]
        );
    }
}
