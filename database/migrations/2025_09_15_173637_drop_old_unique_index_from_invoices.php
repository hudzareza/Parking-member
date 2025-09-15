<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Matikan sementara foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // Drop index lama kalau masih ada
        DB::statement('ALTER TABLE invoices DROP INDEX invoices_member_id_period_unique');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down(): void
    {
        // Kembalikan index lama
        DB::statement('ALTER TABLE invoices ADD UNIQUE invoices_member_id_period_unique (member_id, period)');
    }
};
