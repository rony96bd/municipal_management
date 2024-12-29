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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('site_name');
            $table->string('meta_description', 150)->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_banner')->nullable();
            $table->string('primary_color', 7)->default('#000325'); // Hex color
            $table->string('secondary_color', 7)->default('#3361d9'); // Hex color
            $table->string('paragraph_color', 7)->default('#333333'); // Hex color
            $table->string('danger_color', 7)->default('#e74c3c'); // Hex color
            $table->string('alert_color', 7)->default('#f39c12'); // Hex color
            $table->string('success_color', 7)->default('#4fff00'); // Hex color
            $table->string('warning_color', 7)->default('#f39c12'); // Hex color
            $table->string('background_gray', 7)->default('#f2f2f2'); // Hex color
            $table->string('google_font')->nullable(); // Add the google_font column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
