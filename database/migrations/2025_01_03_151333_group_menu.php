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
        Schema::create('group_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('top_menu_id')->nullable();
            $table->string('order')->nullable();              // Order of the sidebar
            $table->string('group_label');              // Order of the sidebar
            $table->timestamps();                             // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_menus');
    }
};
