<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_info', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->default('0813-3551-2803');
            $table->string('whatsapp')->default('6281335512803');
            $table->string('email')->default('vkes@polije.ac.id');
            $table->string('instagram')->default('@sipkes.co.id');
            $table->string('instagram_url')->default('https://instagram.com/sipkes.co.id');
            $table->text('address')->default('Jurusan Kesehatan, Program Studi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jalan Mastrip 164, Jember.');
            $table->text('maps_embed')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('faskes_name')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('contact_info');
    }
};

