<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Praktik Mandiri, Klinik Pratama, Klinik Rawat Inap & Puskesmas
            $table->string('slug')->unique();
            $table->decimal('price', 12, 2);
            $table->string('period')->default('bulan');
            $table->string('badge')->nullable(); // e.g. Populer, Rekomendasi
            $table->text('description')->nullable();
            $table->json('features_list')->nullable(); // array of features
            $table->json('terms')->nullable(); // ketentuan
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};

