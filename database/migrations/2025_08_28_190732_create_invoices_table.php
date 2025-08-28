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
        Schema::create('invoices', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->foreignId('member_id')->constrained('members');
            $t->foreignId('branch_id')->constrained('branches');
            $t->date('period'); // gunakan tgl 1 setiap bulan
            $t->unsignedBigInteger('amount_cents');
            $t->enum('status', ['unpaid','paid','void','expired'])->default('unpaid');
            $t->date('due_date');
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
            $t->unique(['member_id','period']);
            $t->index(['branch_id','period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
