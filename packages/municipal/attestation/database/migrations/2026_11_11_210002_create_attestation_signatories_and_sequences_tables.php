<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attestation_signatories', function (Blueprint $t) {
            $t->id();
            $t->string('preset_key', 10)->nullable()->index(); // A..F preset identifier
            $t->string('name')->nullable();          // ব্যক্তির নাম (ফাঁকা হতে পারে)
            $t->string('designation');               // পদবী
            $t->string('office_line')->nullable();   // "আলমডাঙ্গা পৌরসভা"
            $t->string('extra_line')->nullable();    // "আলমডাঙ্গা, চুয়াডাঙ্গা"
            $t->string('signature_image')->nullable();
            $t->boolean('is_active')->default(true);
            $t->unsignedInteger('order')->default(0);
            $t->timestamps();
        });

        Schema::create('attestation_sequences', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('attestation_type_id');
            $t->unsignedSmallInteger('year');
            $t->unsignedInteger('last_number')->default(0);
            $t->timestamps();
            $t->unique(['attestation_type_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attestation_sequences');
        Schema::dropIfExists('attestation_signatories');
    }
};
