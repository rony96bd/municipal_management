<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attestations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('application_id')->nullable()->constrained('attestation_applications')->nullOnDelete();
            $t->foreignId('attestation_type_id')->constrained('attestation_types');

            $t->string('memo_no')->unique();
            $t->unsignedSmallInteger('year');
            $t->unsignedInteger('serial');
            $t->date('issue_date');
            $t->string('verification_code', 32)->unique();

            // ইস্যুর মুহূর্তের snapshot — পরে টেমপ্লেট বদলালেও পুরনো সনদ অপরিবর্তিত
            $t->json('snapshot');
            // দ্রুত সার্চের জন্য
            $t->string('subject_name')->index();
            $t->string('id_no', 40)->nullable()->index();

            // ম্যানুয়াল পেমেন্ট
            $t->decimal('fee', 10, 2)->default(0);
            $t->string('payment_status', 10)->default('unpaid');
            $t->decimal('paid_amount', 10, 2)->nullable();
            $t->string('receipt_no')->nullable();
            $t->timestamp('paid_at')->nullable();

            $t->unsignedBigInteger('issued_by')->nullable();
            $t->unsignedInteger('printed_count')->default(0);
            $t->timestamp('last_printed_at')->nullable();
            $t->timestamp('handed_over_at')->nullable();
            $t->string('handed_over_to')->nullable();
            $t->boolean('is_cancelled')->default(false);
            $t->string('cancel_reason')->nullable();
            $t->timestamps();
            $t->softDeletes();

            $t->index('issue_date');
        });

        Schema::create('attestation_logs', function (Blueprint $t) {
            $t->id();
            $t->nullableMorphs('loggable');
            $t->string('action', 40);               // created|updated|approved|rejected|printed|...
            $t->json('changes')->nullable();
            $t->unsignedBigInteger('user_id')->nullable();
            $t->string('ip', 45)->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attestation_logs');
        Schema::dropIfExists('attestations');
    }
};
