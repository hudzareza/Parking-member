<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProofAndVerificationToInvoices extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('proof_file')->nullable()->after('status');
            $table->enum('proof_status', ['none', 'pending', 'accepted', 'rejected'])
                  ->default('none')
                  ->after('proof_file');
            $table->text('verification_note')->nullable()->after('proof_status');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('verification_note');
            $table->timestamp('proof_uploaded_at')->nullable()->after('verified_by');
            $table->timestamp('verified_at')->nullable()->after('proof_uploaded_at');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['proof_file','proof_status','verification_note','verified_by','proof_uploaded_at','verified_at']);
        });
    }
}
