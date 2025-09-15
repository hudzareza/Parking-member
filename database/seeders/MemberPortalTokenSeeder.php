<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Member;

class MemberPortalTokenSeeder extends Seeder
{
    public function run(): void
    {
        Member::whereNull('portal_token')->chunk(100, function ($members) {
            foreach ($members as $member) {
                $member->update([
                    'portal_token' => Str::uuid()->toString(),
                ]);
            }
        });
    }
}
