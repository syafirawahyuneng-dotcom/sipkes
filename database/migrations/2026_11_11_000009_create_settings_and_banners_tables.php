<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable(); // e.g. "Sistem Informasi Pelayanan Kesehatan"
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('primary_btn_text')->default('Lihat Fitur & Demo');
            $table->string('primary_btn_url')->default('#fitur');
            $table->string('secondary_btn_text')->default('Hubungi Kami');
            $table->string('secondary_btn_url')->default('#kontak');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        Schema::create('target_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Praktik Dokter Mandiri, Klinik Pratama, Klinik Rawat Inap, Puskesmas, Laboratorium Medis
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_facilities');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('banners');
    }
};

