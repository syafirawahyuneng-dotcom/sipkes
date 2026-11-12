@extends('admin.layout')

@section('title', 'Kelola Paket Harga')
@section('page_title', 'Kelola Paket & Biaya Langganan SIP-Kes')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Daftar Paket Berlangganan</h3>
        <p class="text-xs text-slate-500">3 Paket resmi berdasarkan proposal (Praktik Mandiri, Klinik Pratama, Rawat Inap/Puskesmas).</p>
    </div>
    <a href="{{ route('admin.pricing.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
        <i class="fa-solid fa-plus"></i> Tambah Paket
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @forelse($plans as $plan)
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400">Order #{{ $plan->order }}</span>
                @if($plan->badge)
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800">
                    {{ $plan->badge }}
                </span>
                @endif
            </div>

            <h4 class="text-lg font-black text-slate-900 mb-1">{{ $plan->name }}</h4>
            <p class="text-xs text-slate-500 mb-4">{{ $plan->description }}</p>

            <div class="mb-4 pb-4 border-b border-slate-100">
                <span class="text-2xl font-black text-primary-700">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                <span class="text-xs text-slate-500">/ {{ $plan->period }}</span>
            </div>

            <p class="text-[11px] font-bold text-slate-700 uppercase mb-2">Daftar Fitur:</p>
            <ul class="space-y-1.5 text-xs text-slate-600 mb-4">
                @if(is_array($plan->features_list))
                    @foreach($plan->features_list as $f)
                    <li class="flex items-start gap-1.5"><i class="fa-solid fa-check text-green-500 text-[11px] mt-0.5"></i> {{ $f }}</li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3 text-xs">
            <a href="{{ route('admin.pricing.edit', $plan) }}" class="text-primary-600 hover:text-primary-800 font-bold">Edit</a>
            <form action="{{ route('admin.pricing.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus paket ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 text-slate-400 bg-white rounded-3xl border border-slate-200">
        Belum ada paket harga.
    </div>
    @endforelse
</div>

@endsection

