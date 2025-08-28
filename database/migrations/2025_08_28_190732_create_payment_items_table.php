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
        Schema::create('payment_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $t->foreignId('invoice_id')->constrained('invoices');
            $t->unsignedBigInteger('amount_cents');
            $t->timestamps();
            $t->unique(['payment_id','invoice_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_items');
    }
};
