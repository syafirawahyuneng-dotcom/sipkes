@extends('admin.layout')

@section('title', 'Tulis Artikel')
@section('page_title', 'Tulis Artikel Baru')

@section('content')

<div class="max-w-6xl bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Formulir Artikel</h3>
        <p class="text-xs text-slate-500">Tulis artikel edukatif seputar rekam medis elektronik, regulasi, dan integrasi SATUSEHAT/BPJS.</p>
    </div>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        @include('admin.articles._form', ['article' => null])

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.articles.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Artikel
            </button>
        </div>
    </form>
</div>

@endsection
