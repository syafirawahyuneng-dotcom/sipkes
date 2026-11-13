@extends('admin.layout')

@section('title', 'Dashboard')
@section('page_title', 'Ringkasan & Statistik Portal SIP-Kes')

@section('content')

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Fitur & Modul</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['features'] }}</h3>
            <a href="{{ route('admin.features.index') }}" class="text-xs text-primary-600 font-bold hover:underline mt-2 inline-block">Kelola Fitur &rarr;</a>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-list-check"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Keunggulan</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['advantages'] }}</h3>
            <a href="{{ route('admin.advantages.index') }}" class="text-xs text-primary-600 font-bold hover:underline mt-2 inline-block">Kelola Keunggulan &rarr;</a>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-award"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Paket Langganan</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['pricing_plans'] }}</h3>
            <a href="{{ route('admin.pricing.index') }}" class="text-xs text-primary-600 font-bold hover:underline mt-2 inline-block">Kelola Harga &rarr;</a>
        </div>
        <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-tags"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pesan Konsultasi</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">
                {{ $stats['messages_total'] }}
                @if($stats['messages_unread'] > 0)
                <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded-full ml-1">{{ $stats['messages_unread'] }} Baru</span>
                @endif
            </h3>
            <a href="{{ route('admin.contact.index') }}" class="text-xs text-primary-600 font-bold hover:underline mt-2 inline-block">Lihat Pesan &rarr;</a>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-envelope-open-text"></i>
        </div>
    </div>
</div>

<!-- Quick Action Shortcuts -->
<div class="bg-gradient-to-r from-primary-800 to-sky-700 rounded-3xl p-8 text-white mb-8 shadow-md">
    <div class="max-w-3xl">
        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 text-white mb-3 inline-block">Pusat Kendali Portal</span>
        <h3 class="text-2xl font-black tracking-tight mb-2">Kelola Seluruh Informasi Portal SIP-Kes TeFa V-Kes</h3>
        <p class="text-primary-100 text-xs sm:text-sm mb-6 leading-relaxed">
            Semua perubahan teks beranda, deskripsi modul RME, tarif paket langganan, dan berita yang Anda simpan di sini akan otomatis tampil secara dinamis pada halaman pengunjung publik.
        </p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.features.create') }}" class="px-4 py-2.5 rounded-xl bg-white text-primary-800 font-bold text-xs shadow hover:bg-primary-50 transition">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Fitur
            </a>
            <a href="{{ route('admin.home.index') }}" class="px-4 py-2.5 rounded-xl bg-primary-900/60 hover:bg-primary-900 text-white font-bold text-xs border border-white/20 transition">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Banner Beranda
            </a>
            <a href="{{ route('admin.profile.index') }}" class="px-4 py-2.5 rounded-xl bg-primary-900/60 hover:bg-primary-900 text-white font-bold text-xs border border-white/20 transition">
                <i class="fa-solid fa-id-card mr-1"></i> Edit Profil & Visi Misi
            </a>
        </div>
    </div>
</div>

<!-- Two Columns: Latest Messages & Quick Links -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left: Latest Messages -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Pesan & Permintaan Faskes Terbaru</h3>
                <p class="text-xs text-slate-500">Pesan formulir yang dikirim oleh pengunjung melalui website.</p>
            </div>
            <a href="{{ route('admin.contact.index') }}" class="text-xs font-bold text-primary-600 hover:underline">Lihat Semua &rarr;</a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($latestMessages as $msg)
            <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-slate-800">{{ $msg->name }}</span>
                        @if(!$msg->is_read)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700">Belum Dibaca</span>
                        @endif
                    </div>
                    <p class="text-xs text-primary-600 font-semibold">{{ $msg->faskes_name ?? 'Faskes Mandiri' }} • {{ $msg->email }} • {{ $msg->phone }}</p>
                    <p class="text-xs text-slate-500 mt-1 italic">"{{ Str::limit($msg->message, 80) }}"</p>
                </div>
                <div class="text-xs text-slate-400 shrink-0">
                    {{ $msg->created_at->diffForHumans() }}
                </div>
            </div>
            @empty
            <div class="py-8 text-center text-xs text-slate-400">
                Belum ada pesan masuk dari faskes.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Right: Proposal Reference Status -->
    <div class="lg:col-span-4 space-y-6">
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-base font-bold text-slate-800">Status Proposal SIP-Kes</h3>
            <div class="space-y-3 text-xs text-slate-600">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <span>Institusi</span>
                    <span class="font-bold text-slate-800">Politeknik Negeri Jember</span>
                </div>
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <span>Unit Usaha</span>
                    <span class="font-bold text-slate-800">TeFa Inovasi Kesehatan</span>
                </div>
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <span>Regulasi</span>
                    <span class="font-bold text-slate-800">PMK No. 24 Tahun 2022</span>
                </div>
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <span>Interoperabilitas</span>
                    <span class="font-bold text-slate-800">SATUSEHAT & BPJS</span>
                </div>
            </div>
            <div class="p-3 bg-sky-50 rounded-xl text-[11px] text-sky-800 border border-sky-100">
                <i class="fa-solid fa-circle-info mr-1"></i> Data proposal telah dimuat ke dalam database migration dan seeder.
            </div>
        </div>
    </div>

</div>

@endsection

