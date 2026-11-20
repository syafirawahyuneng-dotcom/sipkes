@extends('admin.layout')

@section('title', 'Tambah Informasi')
@section('page_title', 'Tambah Informasi Baru')

@section('content')

<div class="max-w-3xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Formulir Informasi</h3>
        <p class="text-xs text-slate-500">Informasi tampil di menu Fitur & Layanan → Informasi pada portal publik.</p>
    </div>

    <form action="{{ route('admin.information.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        @include('admin.information._form', ['information' => null])

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.information.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Simpan Informasi
            </button>
        </div>
    </form>
</div>

@endsection
