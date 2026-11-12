@extends('rme.layout')

@section('title', 'Verifikasi SATUSEHAT Mobile')
@section('header_title', '11. Verifikasi Pasien dengan SATUSEHAT Mobile')

@section('content')
<div class="space-y-6">

    <!-- Top Card: Simulator Verifikasi QR / NIK SATUSEHAT -->
    <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 text-white rounded-2xl p-6 sm:p-8 shadow-lg">
        <div class="max-w-3xl">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs uppercase tracking-wider font-bold text-emerald-300">Kementerian Kesehatan Republik Indonesia</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black">Simulator Integrasi SATUSEHAT Mobile</h2>
            <p class="text-xs text-emerald-100 mt-1 leading-relaxed">
                Fitur verifikasi identitas pasien, status vaksinasi, dan rekam riwayat kesehatan lintas fasilitas pelayanan kesehatan (Faskes) menggunakan QR Code atau NIK SATUSEHAT.
            </p>

            <!-- Search / Scan Box -->
            <form action="{{ route('rme.verifikasi.satusehat') }}" method="GET" class="mt-5 flex flex-col sm:flex-row gap-2">
                <div class="relative flex-1">
                    <input type="text" name="identifier" id="identInput" value="{{ request('identifier') }}" required
                           placeholder="Masukkan NIK KTP (16 Digit) / IHS Number / No. RM Pasien..."
                           class="w-full text-xs pl-10 pr-4 py-3 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-emerald-200 outline-none focus:ring-2 focus:ring-emerald-400">
                    <i class="fa-solid fa-qrcode absolute left-3.5 top-3.5 text-emerald-300 text-sm"></i>
                </div>
                <button type="submit" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl text-xs transition shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-shield-halved"></i> Verifikasi Pasien
                </button>
            </form>

            <!-- Quick click sample buttons -->
            <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-emerald-200">
                <span class="text-[11px] font-semibold text-emerald-300">Contoh Cepat:</span>
                <button type="button" onclick="setQuery('3509012304850001')" class="px-2 py-0.5 rounded bg-white/10 hover:bg-white/20 text-[11px] font-mono transition">
                    NIK: 3509012304850001 (Budi)
                </button>
                <button type="button" onclick="setQuery('RM-2026-0002')" class="px-2 py-0.5 rounded bg-white/10 hover:bg-white/20 text-[11px] font-mono transition">
                    No. RM: RM-2026-0002 (Siti)
                </button>
            </div>
        </div>
    </div>

    <!-- Hasil Verifikasi -->
    @if($queryResult)
        @if($queryResult['found'])
            <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6 animate-fade-in">
                <!-- Status Badge Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-2xl shadow-md">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Status Identitas SATUSEHAT</span>
                            <h3 class="text-base font-extrabold text-emerald-950">{{ $queryResult['satusehat_status'] }}</h3>
                            <p class="text-[11px] text-emerald-700">Terakhir sinkronisasi: {{ $queryResult['last_sync'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-500 font-semibold block uppercase">IHS Number Kemenkes</span>
                        <span class="font-mono text-sm font-black px-3 py-1 bg-white rounded-lg border border-emerald-300 text-emerald-800">
                            {{ $queryResult['ihs_number'] }}
                        </span>
                    </div>
                </div>

                <!-- Detail Pasien Terverifikasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">Nama Lengkap</span>
                        <span class="text-sm font-bold text-slate-800">{{ $queryResult['patient']->name }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">NIK Dukcapil</span>
                        <span class="text-sm font-mono font-bold text-slate-800">{{ $queryResult['patient']->nik ?? '-' }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">No. Rekam Medis (RM)</span>
                        <span class="text-sm font-mono font-bold text-primary-700">{{ $queryResult['patient']->no_rm }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">Status BPJS</span>
                        <span class="text-xs font-bold text-sky-700">{{ $queryResult['patient']->bpjs_status }} ({{ $queryResult['patient']->bpjs_number ?? '-' }})</span>
                    </div>
                </div>

                <!-- Resume Vaksinasi & Riwayat Pelayanan Interoperabilitas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2">
                        <h4 class="text-xs font-bold uppercase tracking-wide text-slate-700 flex items-center gap-2">
                            <i class="fa-solid fa-syringe text-emerald-600"></i> Riwayat Vaksinasi Terintegrasi
                        </h4>
                        <div class="p-3 bg-white rounded-lg border border-slate-200 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between text-slate-700">
                                <span>Vaksin COVID-19 Dosis Primer:</span>
                                <span class="font-bold text-emerald-600"><i class="fa-solid fa-check"></i> Lengkap</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-700">
                                <span>Vaksin Booster Terakhir:</span>
                                <span class="font-bold text-emerald-600"><i class="fa-solid fa-check"></i> Pfizer (Tervalidasi)</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2">
                        <h4 class="text-xs font-bold uppercase tracking-wide text-slate-700 flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right-arrow-left text-blue-600"></i> Integrasi Rekam Medis Lintas Faskes
                        </h4>
                        <div class="p-3 bg-white rounded-lg border border-slate-200 text-xs text-slate-600 space-y-1">
                            <p>Resource: <strong>FHIR R4 Patient & Encounter</strong></p>
                            <p>Status Konsen: <span class="text-emerald-700 font-bold">Pasien Mengizinkan Akses Data Medis</span></p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('rme.pemeriksaan.so', ['patient_id' => $queryResult['patient']->id]) }}" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow">
                        <i class="fa-solid fa-stethoscope"></i> Mulai Pemeriksaan SO Pasien Ini
                    </a>
                </div>
            </div>
        @else
            <div class="bg-rose-50 border-l-4 border-rose-500 p-6 rounded-r-2xl">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-xmark text-rose-600 text-2xl"></i>
                    <div>
                        <h4 class="text-sm font-bold text-rose-900">Data Tidak Ditemukan</h4>
                        <p class="text-xs text-rose-700 mt-1">{{ $queryResult['message'] }}</p>
                    </div>
                </div>
            </div>
        @endif
    @endif

</div>
@endsection

@push('scripts')
<script>
    function setQuery(val) {
        document.getElementById('identInput').value = val;
    }
</script>
@endpush

