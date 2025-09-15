<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Cek kalau ada index lama
            try {
                DB::statement('ALTER TABLE invoices DROP INDEX invoices_member_id_period_unique');
            } catch (\Exception $e) {
                // kalau index tidak ada, biarin aja
            }

            // Tambahkan index baru dengan vehicle_id
            $table->unique(['member_id', 'vehicle_id', 'period'], 'invoices_member_vehicle_period_unique');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            try {
                DB::statement('ALTER TABLE invoices DROP INDEX invoices_member_vehicle_period_unique');
            } catch (\Exception $e) {
                //
            }

            $table->unique(['member_id', 'period'], 'invoices_member_id_period_unique');
        });
    }
};
