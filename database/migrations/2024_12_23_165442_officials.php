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
        Schema::create('officials', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->integer('order')->nullable();
            $table->string('offificial_name'); // Official's name
            $table->string('designation'); // Official's designation
            $table->string('bcs')->nullable(); // BCS batch (optional)
            $table->string('bcsid')->nullable(); // BCS ID (optional)
            $table->string('edu')->nullable(); // Education qualification (optional)
            $table->string('office_phone')->nullable(); // Office phone
            $table->string('home_phone')->nullable(); // Home phone
            $table->string('fax')->nullable(); // Fax (optional)
            $table->string('mobile'); // Mobile phone
            $table->string('email')->nullable(); // Email address (can be shared municipal email or optional)
            $table->string('nid')->nullable(); // NID number (optional)
            $table->date('first_joining')->nullable(); // First joining date (optional)
            $table->date('prl_date')->nullable(); // PRL date (optional)
            $table->string('first_designation')->nullable(); // First designation (optional)
            $table->string('home_district')->nullable(); // Home district (optional)
            $table->date('joining_date')->nullable(); // Joining date (optional)
            $table->string('page_url')->unique(); // Unique URL for the page
            $table->string('image')->nullable(); // Path to uploaded image (optional)
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};
