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
        Schema::create('stuffs', function (Blueprint $table) {
            $table->id();
            $table->string('stuff_name');
            $table->string('designation');
            $table->string('office_phone', 15)->nullable();
            $table->string('home_phone', 15)->nullable();
            $table->string('mobile', 15);
            $table->string('email')->nullable();
            $table->string('home_district')->nullable();
            $table->date('first_joining')->nullable();
            $table->string('first_designation')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('prl_date')->nullable();
            $table->string('grade')->nullable();
            $table->string('section')->nullable();
            $table->string('page_url')->unique();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stuffs');
    }
};
