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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('topic');             // Topic for the gallery
            $table->text('description')->nullable();  // Description of the gallery post
            $table->string('page_url');          // URL associated with the gallery
            $table->json('image_path')->nullable();         // Store image paths as JSON (multiple images)
            $table->timestamps();               // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
