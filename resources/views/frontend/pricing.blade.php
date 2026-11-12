@extends('layouts.frontend')

@section('title', 'Pilihan Paket & Biaya Berlangganan SIP-Kes')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Paket & Harga Resmi</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Investasi Berlangganan SIP-Kes</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Tiga pilihan paket sesuai proposal TeFa V-Kes Polije untuk Praktik Mandiri, Klinik Pratama, hingga Klinik Rawat Inap & Puskesmas.
        </p>
    </div>
</section>

<!-- Pricing Plans -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
            @foreach($plans as $plan)
            <div class="relative bg-white rounded-3xl p-8 border {{ $plan->slug == 'klinik-pratama' ? 'border-primary-500 shadow-2xl ring-2 ring-primary-500/20' : 'border-slate-200 shadow-sm' }} flex flex-col justify-between">
                
                @if($plan->badge)
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ $plan->slug == 'klinik-pratama' ? 'bg-primary-600 text-white' : 'bg-slate-800 text-white' }} shadow-md">
                    {{ $plan->badge }}
                </div>
                @endif

                <div>
                    <h3 class="text-2xl font-black text-slate-900 mb-2">{{ $plan->name }}</h3>
                    <p class="text-xs text-slate-500 mb-6 leading-relaxed">{{ $plan->description }}</p>

                    <div class="mb-6 pb-6 border-b border-slate-100">
                        <span class="text-4xl font-black text-slate-900">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                        <span class="text-xs text-slate-500 font-medium">/ {{ $plan->period }}</span>
                    </div>

                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Cakupan Fitur Modul:</p>
                    <ul class="space-y-3 text-xs text-slate-600 mb-8">
                        @if(is_array($plan->features_list))
                            @foreach($plan->features_list as $item)
                            <li class="flex items-start gap-2.5">
                                <i class="fa-solid fa-circle-check text-primary-600 mt-0.5"></i>
                                <span>{{ $item }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>

                    @if(is_array($plan->terms) && count($plan->terms) > 0)
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-500 space-y-1 mb-6">
                        <p class="font-bold text-slate-700">Ketentuan Paket:</p>
                        @foreach($plan->terms as $term)
                            <p>• {{ $term }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div>
                    <a href="https://wa.me/6281335512803?text=Halo%20TeFa%20V-Kes%20Polije,%20saya%20ingin%20berlangganan%20Paket%20{{ urlencode($plan->name) }}" target="_blank" class="w-full block text-center py-3.5 px-4 rounded-xl font-bold text-sm {{ $plan->slug == 'klinik-pratama' ? 'bg-primary-600 hover:bg-primary-700 text-white shadow-lg shadow-primary-600/30' : 'bg-slate-100 hover:bg-slate-200 text-slate-800' }} transition">
                        Daftar Paket {{ $plan->name }}
                    </a>
                </div>

            </div>
            @endforeach
        </div>

        <!-- FAQ Ketentuan Proposal -->
        <div class="mt-16 bg-slate-50 border border-slate-200 rounded-3xl p-8 sm:p-12 space-y-6">
            <h3 class="text-2xl font-black text-slate-900 text-center">Ketentuan & Syarat Berlangganan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs sm:text-sm text-slate-600">
                <div class="space-y-2">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-circle-question text-primary-600"></i> Apakah ada biaya implementasi awal (Setup Fee)?
                    </h4>
                    <p class="text-slate-500 text-justify">Biaya setup, pembuatan database faskes, serta migrasi dasar sudah termasuk dalam program kemitraan TeFa V-Kes Politeknik Negeri Jember tanpa biaya tersembunyi.</p>
                </div>

                <div class="space-y-2">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-circle-question text-primary-600"></i> Bagaimana jika ada pembaruan SATUSEHAT dari Kemenkes?
                    </h4>
                    <p class="text-slate-500 text-justify">Seluruh klien aktif SIP-Kes mendapatkan pembaruan otomatis (update schema FHIR, endpoint baru Kemenkes) secara gratis tanpa biaya upgrade software.</p>
                </div>

                <div class="space-y-2">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-circle-question text-primary-600"></i> Apakah staf kami dilatih sampai bisa?
                    </h4>
                    <p class="text-slate-500 text-justify">Ya! Tim teknis dan dosen instruktur TeFa V-Kes memberikan pelatihan (training) langsung sampai seluruh dokter, perawat, apoteker, dan kasir mahir.</p>
                </div>

                <div class="space-y-2">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-circle-question text-primary-600"></i> Bagaimana cara pembayaran langganan?
                    </h4>
                    <p class="text-slate-500 text-justify">Pembayaran dapat dilakukan per bulan atau per tahun via transfer rekening resmi Teaching Factory Politeknik Negeri Jember dengan kwitansi dan invoice resmi.</p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

