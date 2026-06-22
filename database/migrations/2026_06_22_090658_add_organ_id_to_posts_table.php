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
        if (!Schema::hasColumn('posts', 'organ_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->foreignId('organ_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('organs')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('posts', 'organ_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['organ_id']);
                $table->dropColumn('organ_id');
            });
        }
    }
};
