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
        Schema::table('officials', function (Blueprint $table) {
            if (Schema::hasIndex('officials', 'officials_email_unique')) {
                $table->dropUnique('officials_email_unique');
            }

            $table->string('email')->nullable()->change();
            $table->string('office_phone')->nullable()->change();

            if (!Schema::hasColumn('officials', 'edu')) {
                $table->string('edu')->nullable()->after('bcsid');
            }
            if (!Schema::hasColumn('officials', 'nid')) {
                $table->string('nid')->nullable()->after('email');
            }
            if (!Schema::hasColumn('officials', 'first_joining')) {
                $table->date('first_joining')->nullable()->after('nid');
            }
            if (!Schema::hasColumn('officials', 'prl_date')) {
                $table->date('prl_date')->nullable()->after('first_joining');
            }
            if (!Schema::hasColumn('officials', 'first_designation')) {
                $table->string('first_designation')->nullable()->after('prl_date');
            }
        });

        Schema::table('stuffs', function (Blueprint $table) {
            if (Schema::hasIndex('stuffs', 'stuffs_email_unique')) {
                $table->dropUnique('stuffs_email_unique');
            }

            $table->string('email')->nullable()->change();
            $table->string('office_phone', 15)->nullable()->change();
            $table->string('home_phone', 15)->nullable()->change();

            if (!Schema::hasColumn('stuffs', 'first_joining')) {
                $table->date('first_joining')->nullable()->after('home_district');
            }
            if (!Schema::hasColumn('stuffs', 'first_designation')) {
                $table->string('first_designation')->nullable()->after('first_joining');
            }
            if (!Schema::hasColumn('stuffs', 'prl_date')) {
                $table->date('prl_date')->nullable()->after('joining_date');
            }
            if (!Schema::hasColumn('stuffs', 'grade')) {
                $table->string('grade')->nullable()->after('prl_date');
            }
            if (!Schema::hasColumn('stuffs', 'section')) {
                $table->string('section')->nullable()->after('grade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
