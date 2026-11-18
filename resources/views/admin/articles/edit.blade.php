@extends('admin.layout')

@section('title', 'Edit Artikel')
@section('page_title', 'Edit Artikel')

@section('content')

<div class="max-w-6xl bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-start justify-between gap-3">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Edit Artikel</h3>
            <p class="text-xs text-slate-500">Perbarui isi, gambar, dan status publikasi artikel.</p>
        </div>
        <a href="{{ route('admin.articles.preview', $article) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
            <i class="fa-solid fa-eye"></i> Pratinjau
        </a>
    </div>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.articles._form', ['article' => $article])

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.articles.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Perbarui Artikel
            </button>
        </div>
    </form>
</div>

@endsection
