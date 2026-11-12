@extends('rme.layout')

@section('title', 'Integrasi SATUSEHAT & BPJS Kesehatan')
@section('header_title', '13. Pengaturan Integrasi Bridging SATUSEHAT & BPJS Kesehatan')

@section('content')
<div class="space-y-6">

    <!-- Hero Card Bridging -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 text-white rounded-2xl p-6 shadow-md flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="text-xs uppercase font-bold text-emerald-400">Bridging Engine Permenkes 24/2022</span>
            </div>
            <h2 class="text-xl font-bold">Pusat Konfigurasi API & Integrasi Faskes</h2>
            <p class="text-xs text-slate-300 mt-1">
                Konektivitas interoperabilitas data rekam medis elektronik standar HL7 FHIR Kemenkes dan klaim BPJS PCare.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('rme.pengaturan.integrasi.test', ['target' => 'satusehat']) }}" 
               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-2">
                <i class="fa-solid fa-satellite-dish"></i> Tes Ping SATUSEHAT
            </a>
            <a href="{{ route('rme.pengaturan.integrasi.test', ['target' => 'bpjs']) }}" 
               class="px-4 py-2 bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-2">
                <i class="fa-solid fa-network-wired"></i> Tes Ping BPJS PCare
            </a>
        </div>
    </div>

    <!-- Form Kredensial Integrasi -->
    <form action="{{ route('rme.pengaturan.integrasi.save') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @csrf

        <!-- Panel SATUSEHAT Kemenkes RI -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">SS</span>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Kemenkes SATUSEHAT (HL7 FHIR)</h3>
                            <p class="text-[11px] text-slate-400">OAuth2 Client Credentials</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                        {{ $config['satusehat_status'] }}
                    </span>
                </div>

                <div class="space-y-3.5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Organization ID (Org-ID) <span class="text-rose-500">*</span></label>
                        <input type="text" name="satusehat_org_id" value="{{ $config['satusehat_org_id'] }}" required
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Client ID (API Key) <span class="text-rose-500">*</span></label>
                        <input type="text" name="satusehat_client_id" value="{{ $config['satusehat_client_id'] }}" required
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Client Secret Key <span class="text-rose-500">*</span></label>
                        <input type="password" name="satusehat_client_secret" value="{{ $config['satusehat_client_secret'] }}" required
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Environment Server</label>
                        <select name="satusehat_env" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                            <option value="Sandbox Kemenkes" {{ $config['satusehat_env'] == 'Sandbox Kemenkes' ? 'selected' : '' }}>Sandbox Kemenkes (Development & Uji Coba)</option>
                            <option value="Production Kemenkes" {{ $config['satusehat_env'] == 'Production Kemenkes' ? 'selected' : '' }}>Production Kemenkes (Live FKTP)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] text-slate-400">Endpoint: https://api-satusehat.kemkes.go.id/fhir-r4/v1</span>
                <a href="{{ route('rme.pengaturan.integrasi.test', ['target' => 'satusehat']) }}" class="text-xs text-emerald-600 font-bold hover:underline">
                    Ping Sekarang &rarr;
                </a>
            </div>
        </div>

        <!-- Panel BPJS Kesehatan PCare -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center text-sm font-bold">BP</span>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">BPJS Kesehatan (PCare FKTP)</h3>
                            <p class="text-[11px] text-slate-400">Cons ID & HMAC-SHA256 Signature</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-sky-100 text-sky-800">
                        {{ $config['bpjs_status'] }}
                    </span>
                </div>

                <div class="space-y-3.5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Consumer ID (Cons ID) <span class="text-rose-500">*</span></label>
                        <input type="text" name="bpjs_cons_id" value="{{ $config['bpjs_cons_id'] }}" required
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Consumer Secret (Secret Key) <span class="text-rose-500">*</span></label>
                        <input type="password" name="bpjs_secret_key" value="{{ $config['bpjs_secret_key'] }}" required
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">User Key PCare <span class="text-rose-500">*</span></label>
                        <input type="text" name="bpjs_user_key" value="{{ $config['bpjs_user_key'] }}" required
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Mode Bridging</label>
                        <select name="bpjs_env" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                            <option value="Bridging Live BPJS" {{ $config['bpjs_env'] == 'Bridging Live BPJS' ? 'selected' : '' }}>Bridging Live BPJS (Produksi Aktif)</option>
                            <option value="Bridging Staging BPJS" {{ $config['bpjs_env'] == 'Bridging Staging BPJS' ? 'selected' : '' }}>Bridging Staging (Simulasi Uji Coba)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] text-slate-400">Service: Primary Care Web Service (PCare WS 2.0)</span>
                <a href="{{ route('rme.pengaturan.integrasi.test', ['target' => 'bpjs']) }}" class="text-xs text-sky-600 font-bold hover:underline">
                    Ping Sekarang &rarr;
                </a>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="lg:col-span-2 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Seluruh Kredensial Integrasi
            </button>
        </div>
    </form>

</div>
@endsection

