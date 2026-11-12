<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Dokumentasi Kegiatan, Fasilitas & Ruangan, Pelatihan, Aktivitas TeFa
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('gallery_categories')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->date('date')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('gallery_categories');
    }
};

