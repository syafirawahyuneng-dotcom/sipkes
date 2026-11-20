@extends('admin.layout')

@section('title', 'Edit Informasi')
@section('page_title', 'Edit Informasi')

@section('content')

<div class="max-w-3xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-start justify-between gap-3">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Edit Informasi</h3>
            <p class="text-xs text-slate-500">Perbarui judul, foto, keterangan, atau status tampil.</p>
        </div>
        <a href="{{ route('information') }}" target="_blank" class="text-xs font-bold text-primary-600 hover:underline shrink-0">
            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Lihat di Portal
        </a>
    </div>

    <form action="{{ route('admin.information.update', $information) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.information._form', ['information' => $information])

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.information.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Perbarui Informasi
            </button>
        </div>
    </form>
</div>

@endsection
