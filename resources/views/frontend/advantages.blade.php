@extends('layouts.frontend')

@section('title', 'Keunggulan Sistem Rekam Medis Elektronik SIP-Kes')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Keunggulan Sistem</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Keunggulan Kompetitif SIP-Kes</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Mengapa faskes memilih SIP-Kes? Kami menghadirkan standar mutu rekam medis terpadu dengan biaya yang ramah bagi operasional klinik.
        </p>
    </div>
</section>

<!-- Advantages Detail -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($advantages as $adv)
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm hover:border-primary-400 hover:shadow-lg transition group">
                <div class="w-14 h-14 rounded-2xl bg-primary-50 text-primary-600 group-hover:bg-primary-600 group-hover:text-white flex items-center justify-center text-2xl mb-6 transition duration-300">
                    <i class="fa-solid {{ $adv->icon ?? 'fa-check' }}"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-3 group-hover:text-primary-700 transition">{{ $adv->title }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed text-justify">{{ $adv->description }}</p>
            </div>
            @endforeach
        </div>

        <!-- 6 Pillars Based on Proposal -->
        <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8 sm:p-12">
            <h2 class="text-2xl font-black text-slate-900 text-center mb-8">6 Pilar Keunggulan Berdasarkan Proposal Resmi:</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="p-5 bg-white rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-3 font-bold text-slate-800 text-sm mb-2">
                        <i class="fa-solid fa-check-circle text-sky-500"></i> Terintegrasi BPJS Kesehatan
                    </div>
                    <p class="text-xs text-slate-500">Koneksi data klaim, validasi status kepesertaan aktif pasien, dan bridging PCare otomatis tanpa kendala.</p>
                </div>

                <div class="p-5 bg-white rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-3 font-bold text-slate-800 text-sm mb-2">
                        <i class="fa-solid fa-check-circle text-sky-500"></i> Terintegrasi SATUSEHAT
                    </div>
                    <p class="text-xs text-slate-500">Interoperabilitas penuh standar HL7 FHIR Kemenkes RI mencakup Encounter, Diagnosis, Observation & Medication.</p>
                </div>

                <div class="p-5 bg-white rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-3 font-bold text-slate-800 text-sm mb-2">
                        <i class="fa-solid fa-check-circle text-sky-500"></i> Berbasis Website (Cloud)
                    </div>
                    <p class="text-xs text-slate-500">Dapat dibuka dari browser mana pun tanpa investasi server mahal. Bebas perawatan hardware mandiri.</p>
                </div>

                <div class="p-5 bg-white rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-3 font-bold text-slate-800 text-sm mb-2">
                        <i class="fa-solid fa-check-circle text-sky-500"></i> Free Training
                    </div>
                    <p class="text-xs text-slate-500">Bimbingan teknis gratis bagi dokter, perawat, loket, apotek, kasir hingga mahir mengoperasikan sistem.</p>
                </div>

                <div class="p-5 bg-white rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-3 font-bold text-slate-800 text-sm mb-2">
                        <i class="fa-solid fa-check-circle text-sky-500"></i> Free Custom RME
                    </div>
                    <p class="text-xs text-slate-500">Kustomisasi form anamnesis, template resep, odontogram, dan lembar asesmen sesuai SOP spesifik klinik Anda.</p>
                </div>

                <div class="p-5 bg-white rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-3 font-bold text-slate-800 text-sm mb-2">
                        <i class="fa-solid fa-check-circle text-sky-500"></i> Data Tersentralisasi
                    </div>
                    <p class="text-xs text-slate-500">Seluruh data riwayat pasien, mutasi stok obat, dan laporan keuangan terkonsolidasi dalam satu sistem aman.</p>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection

