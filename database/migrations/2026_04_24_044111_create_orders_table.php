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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_code', 9)->unique(); // XXXX-XXXX format
            $table->string('magic_token')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('note')->nullable();
            $table->string('payment_proof_path')->nullable();
            $table->string('payment_proof_hash')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->boolean('is_read_by_admin')->default(false);
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
