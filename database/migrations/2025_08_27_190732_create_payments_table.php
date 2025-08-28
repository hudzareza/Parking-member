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
        Schema::create('payments', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->foreignId('member_id')->constrained('members');
            $t->foreignId('branch_id')->constrained('branches');
            $t->unsignedBigInteger('gross_amount_cents');
            $t->enum('status',['pending','settlement','expire','cancel','deny','failure'])->default('pending');
            $t->string('midtrans_order_id')->unique();
            $t->string('midtrans_transaction_id')->nullable();
            $t->string('payment_type')->nullable();
            $t->string('fraud_status')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->text('snap_token')->nullable();
            $t->text('snap_redirect_url')->nullable();
            $t->json('raw_request')->nullable();
            $t->json('raw_notification')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
