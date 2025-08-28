<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tariffs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('branch_id')->nullable()->constrained('branches'); // null= global
            $t->enum('vehicle_type', ['motor','mobil']);
            $t->unsignedBigInteger('amount_cents');
            $t->date('effective_start');
            $t->date('effective_end')->nullable();
            $t->timestamps();
            $t->unique(['branch_id','vehicle_type','effective_start']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
