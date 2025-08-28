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
        Schema::create('vehicles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $t->enum('vehicle_type', ['motor','mobil']);
            $t->string('plate_number');
            $t->string('brand')->nullable();
            $t->string('model')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
