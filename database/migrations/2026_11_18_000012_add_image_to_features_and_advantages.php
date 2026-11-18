<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Fase 2: gambar pendukung untuk Fitur & Modul dan Keunggulan Sistem.
 * Migrasi additive — data yang ada tidak diubah.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('features', 'image')) {
            Schema::table('features', function (Blueprint $table) {
                $table->string('image')->nullable()->after('icon');
            });
        }

        if (! Schema::hasColumn('advantages', 'image')) {
            Schema::table('advantages', function (Blueprint $table) {
                $table->string('image')->nullable()->after('icon');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('features', 'image')) {
            Schema::table('features', fn (Blueprint $table) => $table->dropColumn('image'));
        }

        if (Schema::hasColumn('advantages', 'image')) {
            Schema::table('advantages', fn (Blueprint $table) => $table->dropColumn('image'));
        }
    }
};
