<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attestation_applications', function (Blueprint $t) {
            $t->id();
            $t->string('tracking_no')->unique();
            $t->foreignId('attestation_type_id')->constrained('attestation_types');

            // আবেদনকারী/প্রত্যয়ন-প্রাপক (Person block)
            $t->string('applicant_name');
            $t->string('mobile', 20)->nullable();
            $t->string('id_type', 20)->nullable();   // nid | birth_reg | death_reg
            $t->string('id_no', 40)->nullable();
            $t->string('father_name')->nullable();
            $t->string('mother_name')->nullable();
            $t->string('spouse_name')->nullable();
            $t->string('ward_no', 10)->nullable();
            $t->string('holding_no', 30)->nullable();
            $t->string('mohalla')->nullable();
            $t->string('upazila')->nullable();
            $t->string('district')->nullable();

            $t->json('data')->nullable();            // ডাইনামিক ফিল্ড + repeater
            $t->json('attachments')->nullable();

            $t->string('status', 20)->default('pending')->index();
            $t->text('reject_reason')->nullable();
            $t->text('admin_note')->nullable();

            // ম্যানুয়াল পেমেন্ট
            $t->decimal('fee', 10, 2)->default(0);
            $t->string('payment_status', 10)->default('unpaid'); // unpaid | paid | waived
            $t->decimal('paid_amount', 10, 2)->nullable();
            $t->string('receipt_no')->nullable();
            $t->timestamp('paid_at')->nullable();

            $t->unsignedBigInteger('created_by')->nullable()->index(); // null = পাবলিক
            $t->unsignedBigInteger('reviewed_by')->nullable();
            $t->timestamp('reviewed_at')->nullable();
            $t->timestamps();
            $t->softDeletes();

            $t->index('mobile');
            $t->index('id_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attestation_applications');
    }
};
