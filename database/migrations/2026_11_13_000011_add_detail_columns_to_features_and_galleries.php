<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Menambahkan kolom halaman detail:
 * - features  : slug, users, functions, benefits, workflow (detail Fitur & Modul)
 * - galleries : slug, content, author (Galeri diubah menjadi Berita)
 * Lalu mengisi slug & konten bawaan untuk data yang sudah ada (tanpa menghapus data).
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('features', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->text('users')->nullable()->after('description');
            $table->text('functions')->nullable()->after('users');
            $table->text('benefits')->nullable()->after('functions');
            $table->text('workflow')->nullable()->after('benefits');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->longText('content')->nullable()->after('description');
            $table->string('author')->nullable()->after('content');
        });

        $details = require database_path('data/feature_details.php');
        foreach (DB::table('features')->orderBy('id')->get() as $row) {
            $data = ['slug' => $this->uniqueSlug('features', $row->name, $row->id)];
            if (isset($details[$row->name])) {
                foreach (['users', 'functions', 'benefits', 'workflow'] as $key) {
                    $data[$key] = implode("\n", $details[$row->name][$key]);
                }
            }
            DB::table('features')->where('id', $row->id)->update($data);
        }

        $news = require database_path('data/news_contents.php');
        foreach (DB::table('galleries')->orderBy('id')->get() as $row) {
            $data = ['slug' => $this->uniqueSlug('galleries', $row->title, $row->id)];
            if (isset($news[$row->title])) {
                $data['content'] = $news[$row->title]['content'];
                $data['author'] = $news[$row->title]['author'];
            }
            DB::table('galleries')->where('id', $row->id)->update($data);
        }
    }

    public function down(): void
    {
        Schema::table('features', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'users', 'functions', 'benefits', 'workflow']);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'content', 'author']);
        });
    }

    private function uniqueSlug(string $table, string $text, int $id): string
    {
        $base = Str::slug($text) ?: $table . '-' . $id;
        $slug = $base;
        $i = 2;
        while (DB::table($table)->where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
};
