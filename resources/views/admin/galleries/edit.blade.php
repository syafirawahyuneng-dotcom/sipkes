@extends('admin.layout')

@section('title', 'Edit Berita')
@section('page_title', 'Edit Berita')

@section('content')

<div class="max-w-3xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-start justify-between gap-3">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Edit Berita</h3>
            <p class="text-xs text-slate-500">Perbarui judul, gambar, ringkasan, atau isi berita.</p>
        </div>
        <a href="{{ $gallery->detail_url }}" target="_blank" class="text-xs font-bold text-primary-600 hover:underline shrink-0">
            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Lihat di Portal
        </a>
    </div>

    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.galleries._form', ['gallery' => $gallery])

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.galleries.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Perbarui Berita
            </button>
        </div>
    </form>
</div>

@endsection
