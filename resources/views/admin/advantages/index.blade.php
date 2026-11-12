@extends('admin.layout')

@section('title', 'Kelola Keunggulan')
@section('page_title', 'Kelola Keunggulan Sistem SIP-Kes')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Daftar Keunggulan Kompetitif</h3>
        <p class="text-xs text-slate-500">6 Pilar keunggulan SIP-Kes berdasarkan proposal TeFa V-Kes.</p>
    </div>
    <a href="{{ route('admin.advantages.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
        <i class="fa-solid fa-plus"></i> Tambah Keunggulan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($advantages as $adv)
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-xl">
                    <i class="fa-solid {{ $adv->icon ?? 'fa-award' }}"></i>
                </div>
                <span class="text-xs font-bold text-slate-400">Urutan: #{{ $adv->order }}</span>
            </div>
            <h4 class="font-bold text-slate-900 text-base mb-2">{{ $adv->title }}</h4>
            <p class="text-xs text-slate-500 leading-relaxed">{{ $adv->description }}</p>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-3 text-xs">
            <a href="{{ route('admin.advantages.edit', $adv) }}" class="text-primary-600 hover:text-primary-800 font-bold">Edit</a>
            <form action="{{ route('admin.advantages.destroy', $adv) }}" method="POST" class="inline" onsubmit="return confirm('Hapus keunggulan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 text-slate-400 bg-white rounded-3xl border border-slate-200">
        Belum ada data keunggulan.
    </div>
    @endforelse
</div>

@endsection

