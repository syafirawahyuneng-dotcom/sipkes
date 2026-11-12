<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('profiles');
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Teaching Factory Inovasi Kesehatan (TeFa V-Kes)');
            $table->string('institution')->default('Politeknik Negeri Jember');
            $table->string('tagline')->nullable();
            $table->text('about_tefa')->nullable();
            $table->text('about_sipkes')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('goals')->nullable();
            $table->text('background')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
