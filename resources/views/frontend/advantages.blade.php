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

        <!-- Kepatuhan SIP-Kes Terhadap Standar Kemenkes RI (Sesuai Proposal Hal 5) -->
        <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8 sm:p-12">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-sky-100 text-sky-800 mb-2">Regulasi Resmi</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Kepatuhan SIP-Kes Terhadap Standar Kemenkes RI</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">Dukungan penuh terhadap kepatuhan regulasi Kementerian Kesehatan Republik Indonesia dan interoperabilitas data nasional.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base mb-1.5">Standar Data</h3>
                        <p class="text-xs text-slate-600 leading-relaxed mb-2">
                            SIP-Kes menerapkan kesesuaian data berdasarkan <strong>Kepmenkes No. HK.01.07/MENKES/1423/2022</strong> Tentang Pedoman Variabel dan Meta Data Pada Penyelenggaraan Rekam Medis Elektronik.
                        </p>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 font-medium">
                            <i class="fa-solid fa-check text-green-500"></i> Penggunaan format dan kode yang sesuai dengan HL7-FHIR.
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-network-wired"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base mb-1.5">Standar Interoperabilitas</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            SIP-Kes sebagai RME yang mampu berkomunikasi dan bertukar data dengan sistem lain, termasuk platform <strong>SATUSEHAT</strong> dan <strong>BPJS Kesehatan</strong>.
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base mb-1.5">Standar Keamanan Data</h3>
                        <p class="text-xs text-slate-600 leading-relaxed mb-2">
                            Perlindungan data pasien dari akses yang tidak sah dan kebocoran informasi.
                        </p>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 font-medium">
                            <i class="fa-solid fa-check text-green-500"></i> Server yang digunakan juga sudah teruji keamanannya dari kebocoran data.
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-user-lock"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base mb-1.5">Standar Otentikasi dan Otorisasi</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pengguna harus memiliki akses yang sesuai dengan peran dan tanggung jawab mereka (Role-Based Access Control) untuk menjamin kerahasiaan dan privasi data medis pasien.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection

