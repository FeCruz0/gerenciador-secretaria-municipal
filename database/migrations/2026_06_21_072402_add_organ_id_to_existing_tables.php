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
        $tables = [
            'users',
            'news',
            'biddings',
            'banners',
            'faqs',
            'shortcut_webs',
            'home_modules',
            'departaments',
            'posts'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('organ_id')->nullable()->after('id')->constrained('organs')->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'news',
            'biddings',
            'banners',
            'faqs',
            'shortcut_webs',
            'home_modules',
            'departaments',
            'posts'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['organ_id']);
                    $table->dropColumn('organ_id');
                });
            }
        }
    }
};
