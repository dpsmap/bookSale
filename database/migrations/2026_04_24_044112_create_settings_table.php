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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('order_open')->default(true);
            $table->boolean('book_published')->default(false);
            $table->string('pdf_file_key')->nullable(); // Private storage key for PDF
            $table->string('epub_file_key')->nullable(); // Private storage key for EPUB
            $table->string('pdf_filename')->nullable(); // User-friendly filename
            $table->string('epub_filename')->nullable(); // User-friendly filename
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
