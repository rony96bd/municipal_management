<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attestation_types', function (Blueprint $t) {
            $t->id();
            $t->string('name');                      // শিরোনাম: "অবিবাহিত প্রত্যয়ন পত্র"
            $t->string('slug')->unique();
            $t->string('memo_name');                 // স্মারক নং-এ ব্যবহৃত ধরনের নাম
            $t->text('description')->nullable();
            $t->string('subject_status')->default('either'); // living | deceased | either
            $t->json('person_fields')->nullable();   // কোন Person block ফিল্ড দেখাবে/বাধ্যতামূলক
            $t->json('fields')->nullable();          // অতিরিক্ত ডাইনামিক ফিল্ড (incl. repeater)
            $t->longText('body_template')->nullable();
            $t->string('closing_line')->nullable();  // "আমি তার সার্বিক মঙ্গল কামনা করি।"
            $t->json('signatories')->nullable();     // স্লট: [{label, designation, signatory_id}]
            $t->string('print_layout')->nullable();  // custom blade partial override
            $t->json('print_options')->nullable();   // with_header, watermark, ...
            $t->decimal('fee', 10, 2)->default(0);
            $t->boolean('is_public')->default(true); // নাগরিক আবেদন করতে পারবে কি না
            $t->boolean('is_active')->default(true);
            $t->unsignedInteger('order')->default(0);
            $t->timestamps();
            $t->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attestation_types');
    }
};
