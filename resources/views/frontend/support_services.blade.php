@extends('layouts.frontend')

@section('title', 'Layanan Pendukung Faskes - Pendampingan BPJS & Akreditasi')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Layanan Profesional</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Layanan Pendukung Fasilitas Kesehatan</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Pendampingan ahli Manajemen Informasi Kesehatan Polije untuk optimalisasi klaim BPJS Kesehatan dan persiapan Akreditasi Klinik Paripurna.
        </p>
    </div>
</section>

<!-- Content Body -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        @foreach($services as $idx => $srv)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center {{ $idx % 2 == 1 ? 'lg:flex-row-reverse' : '' }}">
            
            <div class="lg:col-span-7 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-sky-100 text-sky-800">
                    <i class="fa-solid fa-handshake"></i> Program TeFa V-Kes Polije
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $srv->title }}</h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed text-justify">
                    {{ $srv->description }}
                </p>

                <div class="space-y-3 pt-2">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Cakupan Pendampingan Meliputi:</p>
                    @if(is_array($srv->benefits))
                        @foreach($srv->benefits as $benefit)
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fa-solid fa-circle-check text-teal-600 mt-1"></i>
                            <span class="text-xs sm:text-sm text-slate-700 font-medium">{{ $benefit }}</span>
                        </div>
                        @endforeach
                    @endif
                </div>

                <div class="pt-4">
                    <a href="https://wa.me/6281335512803?text=Halo%20TeFa%20V-Kes,%20saya%20tertarik%20dengan%20layanan%20{{ urlencode($srv->title) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs sm:text-sm shadow-md transition">
                        <i class="fa-brands fa-whatsapp text-base"></i> Konsultasikan Layanan Ini
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-gradient-to-tr from-slate-900 to-primary-900 p-8 rounded-3xl text-white shadow-xl space-y-6">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-3xl text-sky-400">
                        <i class="fa-solid {{ $srv->icon ?? 'fa-award' }}"></i>
                    </div>
                    <h3 class="text-xl font-bold">Mengapa Butuh Pendampingan Ini?</h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed text-justify">
                        Tata kelola rekam medis dan berkas penunjang yang tidak sesuai regulasi sering menyebabkan pending klaim BPJS atau penurunan skor elemen akreditasi. Bersama praktisi akademisi TeFa V-Kes Polije, faskes Anda mendapatkan telaah objektif dan solusi tuntas.
                    </p>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 text-xs text-sky-200 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info"></i> Didampingi langsung dosen Prodi Manajemen Informasi Kesehatan Polije.
                    </div>
                </div>
            </div>

        </div>
        @endforeach

    </div>
</section>

@endsection

