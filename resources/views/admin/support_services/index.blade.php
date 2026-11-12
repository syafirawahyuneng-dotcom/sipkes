@extends('admin.layout')

@section('title', 'Kelola Layanan Pendukung')
@section('page_title', 'Kelola Layanan Pendukung Faskes')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Daftar Layanan Pendukung</h3>
        <p class="text-xs text-slate-500">Pendampingan Klaim BPJS dan Pendampingan Akreditasi Klinik oleh TeFa V-Kes.</p>
    </div>
    <a href="{{ route('admin.support-services.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
        <i class="fa-solid fa-plus"></i> Tambah Layanan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    @forelse($services as $srv)
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl mb-4">
                <i class="fa-solid {{ $srv->icon ?? 'fa-handshake' }}"></i>
            </div>
            <h4 class="text-xl font-bold text-slate-900 mb-2">{{ $srv->title }}</h4>
            <p class="text-xs text-slate-600 mb-4 leading-relaxed">{{ $srv->summary }}</p>

            <p class="text-[11px] font-bold text-slate-700 uppercase mb-2">Manfaat & Poin Layanan:</p>
            <ul class="space-y-1.5 text-xs text-slate-500 mb-6">
                @if(is_array($srv->benefits))
                    @foreach($srv->benefits as $b)
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-[11px]"></i> {{ $b }}</li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3 text-xs">
            <a href="{{ route('admin.support-services.edit', $srv) }}" class="text-primary-600 hover:text-primary-800 font-bold">Edit</a>
            <form action="{{ route('admin.support-services.destroy', $srv) }}" method="POST" class="inline" onsubmit="return confirm('Hapus layanan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-2 text-center py-12 text-slate-400 bg-white rounded-3xl border border-slate-200">
        Belum ada data layanan pendukung.
    </div>
    @endforelse
</div>

@endsection

