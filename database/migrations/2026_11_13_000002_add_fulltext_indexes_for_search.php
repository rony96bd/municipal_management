<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();
        if (!in_array($driver, ['mysql', 'mariadb'], true)) {
            return;
        }

        if (Schema::hasTable('notices') && Schema::hasColumn('notices', 'topic')) {
            Schema::table('notices', function (Blueprint $table) {
                $table->fullText('topic', 'notices_topic_fulltext');
            });
        }
        if (Schema::hasTable('news') && Schema::hasColumn('news', 'topic')) {
            Schema::table('news', function (Blueprint $table) {
                $table->fullText('topic', 'news_topic_fulltext');
            });
        }
        if (Schema::hasTable('pages') && Schema::hasColumn('pages', 'page_name')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->fullText('page_name', 'pages_page_name_fulltext');
            });
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if (!in_array($driver, ['mysql', 'mariadb'], true)) {
            return;
        }

        if (Schema::hasTable('notices')) {
            Schema::table('notices', function (Blueprint $table) {
                $table->dropFullText('notices_topic_fulltext');
            });
        }
        if (Schema::hasTable('news')) {
            Schema::table('news', function (Blueprint $table) {
                $table->dropFullText('news_topic_fulltext');
            });
        }
        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropFullText('pages_page_name_fulltext');
            });
        }
    }
};
