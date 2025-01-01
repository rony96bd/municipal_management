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
        Schema::create('banner_slidders', function (Blueprint $table) {
            $table->id();
            $table->string('order')->nullable();             // Order of the banner
            $table->string('title');             // Topic for the gallery
            $table->string('image')->nullable(); // Path to uploaded image (optional)
            $table->timestamps();               // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_slidders');
    }
};
