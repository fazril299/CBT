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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('proof_image')->nullable()->after('status');
            $table->text('proof_note')->nullable()->after('proof_image');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('proof_note');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['proof_image', 'proof_note', 'verified_by', 'verified_at']);
        });
    }
};
