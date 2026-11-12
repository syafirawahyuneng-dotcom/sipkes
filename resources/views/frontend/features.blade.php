@extends('layouts.frontend')

@section('title', 'Fitur & Modul Rekam Medis Elektronik SIP-Kes')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Katalog Fitur</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Fitur & Modul Lengkap SIP-Kes</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Seluruh fitur dirancang spesifik berdasarkan kebutuhan operasional dokter, perawat, apoteker, dan tata kelola faskes sesuai PMK 24/2022.
        </p>
    </div>
</section>

<!-- Filter Kategori & Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            <a href="{{ route('features') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ !request('category') ? 'bg-primary-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua Fitur ({{ count($features) }})
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('features', ['category' => $cat]) }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request('category') == $cat ? 'bg-primary-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($features as $feat)
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:border-primary-400 hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center text-xl">
                            <i class="fa-solid {{ $feat->icon ?? 'fa-circle-check' }}"></i>
                        </div>
                        @if($feat->category)
                        <span class="text-[10px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full bg-slate-100 text-slate-600">
                            {{ $feat->category }}
                        </span>
                        @endif
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">{{ $feat->name }}</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed text-justify">{{ $feat->description }}</p>
                </div>

                @if($feat->is_featured)
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-[11px] font-semibold text-sky-600">
                    <i class="fa-solid fa-star text-amber-400"></i> Modul Unggulan SIP-Kes
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-3 text-center py-12 text-slate-400">
                Belum ada fitur untuk kategori yang dipilih.
            </div>
            @endforelse
        </div>

        <!-- Proposal Specific List Callout -->
        <div class="mt-16 bg-slate-50 border border-slate-200 rounded-3xl p-8 sm:p-10">
            <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Daftar Modul Utama Berdasarkan Proposal Resmi TeFa V-Kes:</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 text-xs text-slate-700">
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Pendaftaran Pasien</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Antrian Suara (Text-to-Speech)</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Pemeriksaan SOAP (SO)</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Diagnosa & Tindakan (AP)</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Farmasi & E-Resep</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Kasir & Billing</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Rawat Inap & Bed Monitor</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Laporan & Morbiditas</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Dashboard Eksekutif</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Cetak Kartu Berobat QR</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Verifikasi SATUSEHAT Mobile</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Asuhan Keperawatan (SDKI)</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Integrasi SATUSEHAT & BPJS</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Odontogram Klinik Gigi</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> General Consent Digital</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Informed Consent Digital</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Surat Sehat & Sakit</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Laboratorium Penunjang</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Sedasi & Bedah Minor</div>
                <div class="p-2.5 bg-white rounded-lg border border-slate-200 flex items-center gap-2"><i class="fa-solid fa-check text-primary-600"></i> Free Custom Template RME</div>
            </div>
        </div>

    </div>
</section>

@endsection

