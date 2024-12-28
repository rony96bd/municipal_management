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
        Schema::create('single_services', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('service_item_name');
            $table->text('service_item_description');
            $table->string('page_url')->unique();
            $table->timestamps();

            // Foreign key constraint
            $table->unsignedBigInteger('service_id');  // Foreign key column
            $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade'); // Reference 'id' in 'services' table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('single_services');
    }
};
