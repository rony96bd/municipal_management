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
        Schema::create('representatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation');
            $table->integer('word_number')->nullable();
            $table->string('office_phone');
            $table->string('home_phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile');
            $table->string('email');
            $table->string('home_district')->nullable();
            $table->string('page_url');
            $table->string('elected_type')->nullable();
            $table->text('presentaddress');
            $table->text('permanentaddress');
            $table->date('joining_date')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representatives');
    }
};
