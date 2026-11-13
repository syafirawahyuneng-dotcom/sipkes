@extends('admin.layout')

@section('title', 'Tulis Berita')
@section('page_title', 'Tulis Berita Baru')

@section('content')

<div class="max-w-3xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Formulir Berita</h3>
        <p class="text-xs text-slate-500">Terbitkan berita kegiatan implementasi, pelatihan, atau informasi TeFa V-Kes.</p>
    </div>

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        @include('admin.galleries._form', ['gallery' => null])

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.galleries.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Terbitkan Berita
            </button>
        </div>
    </form>
</div>

@endsection
