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
        Schema::create('sub_menus', function (Blueprint $table) {
            $table->id();

            // Foreign key to the 'top_menus' table
            $table->unsignedBigInteger('top_menu_id')->nullable();
            $table->foreign('top_menu_id')->references('id')->on('top_menus')->onDelete('cascade');

            // Polymorphic relationship columns
            $table->unsignedBigInteger('forigen_id')->nullable();
            $table->string('forigen_type')->nullable();

            // Additional columns
            $table->string('order')->nullable();              // Order of the submenu
            $table->string('link_text')->nullable();          // Link text (optional)
            $table->string('link_url')->nullable();           // Link URL (optional)
            $table->string('tab')->nullable();                // Tab (optional)

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_menus');
    }
};
