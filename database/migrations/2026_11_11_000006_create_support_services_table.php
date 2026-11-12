<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_services', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. Pendampingan Klaim BPJS, Pendampingan Akreditasi Klinik
            $table->string('icon')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description');
            $table->json('benefits')->nullable(); // array of benefits/points
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_services');
    }
};

