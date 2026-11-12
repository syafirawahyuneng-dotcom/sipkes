@extends('rme.layout')

@section('title', 'Informed Consent Tindakan Medis')
@section('header_title', '16. Informed Consent (Persetujuan Tindakan Kedokteran)')

@section('content')
<div class="space-y-6">

    <!-- Pilih Pasien & Kontrol -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 no-print">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Persetujuan Tindakan Kedokteran (Informed Consent)</h3>
                <p class="text-xs text-slate-500">Standar Permenkes No. 290/MENKES/PER/III/2008 tentang Persetujuan Tindakan Kedokteran</p>
            </div>

            <form action="{{ route('rme.informed.consent') }}" method="GET" class="flex items-center gap-2">
                <select name="patient_id" onchange="this.form.submit()" class="text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-medium">
                    @foreach($patients as $pt)
                        <option value="{{ $pt->id }}" {{ ($patient && $patient->id == $pt->id) ? 'selected' : '' }}>
                            {{ $pt->no_rm }} - {{ $pt->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" onclick="window.print()" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold flex items-center gap-2 transition shadow">
                    <i class="fa-solid fa-print"></i> Cetak Dokumen
                </button>
            </form>
        </div>
    </div>

    @if($patient)
        <!-- Dokumen Informed Consent Standar Medis -->
        <div class="bg-white rounded-2xl p-8 sm:p-12 shadow-sm border border-slate-200 max-w-4xl mx-auto space-y-6 text-slate-800">
            
            <!-- Kop Surat Resmi -->
            <div class="text-center border-b-2 border-slate-800 pb-4">
                <div class="flex items-center justify-center gap-3 mb-1">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                    <div class="text-left">
                        <h2 class="text-base font-black tracking-wide uppercase">KLINIK PRATAMA TEFA V-KES POLIJE</h2>
                        <p class="text-[11px] text-slate-500">Jl. Mastrip PO BOX 164 Jember • Telp. 0331-333532 • Unit Pelayanan Tindakan Medis</p>
                    </div>
                </div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-rose-800 mt-2">FORMULIR PERSETUJUAN TINDAKAN KEDOKTERAN (INFORMED CONSENT)</h3>
                <p class="text-[11px] text-slate-400">Nomor: IC/VKES/{{ date('Ym') }}/{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>

            <!-- Identitas Pasien & Rincian Tindakan -->
            <div class="text-xs space-y-3 leading-relaxed text-slate-700">
                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 grid grid-cols-2 gap-2 font-medium">
                    <div>Nama Pasien: <strong>{{ $patient->name }}</strong></div>
                    <div>No. Rekam Medis: <strong>{{ $patient->no_rm }}</strong></div>
                    <div>Usia / Gender: <strong>{{ \Carbon\Carbon::parse($patient->birth_date)->age }} tahun / {{ $patient->gender }}</strong></div>
                    <div>Dokter Pelaksana: <strong>dr. Ahmad Santoso</strong></div>
                </div>

                <div class="p-4 bg-rose-50/40 rounded-xl border border-rose-200 text-xs space-y-2">
                    <h4 class="font-bold text-rose-950 uppercase tracking-wide">Pemberian Informasi Tindakan Kedokteran:</h4>
                    <ul class="list-disc list-inside space-y-1 text-slate-700">
                        <li><strong>Diagnosis Kerja / Dasar Tindakan:</strong> Indikasi klinis memerlukan penanganan tindakan invasif minor.</li>
                        <li><strong>Tujuan Tindakan:</strong> Mengatasi keluhan, mencegah komplikasi infeksi, dan memperbaiki fungsi organ.</li>
                        <li><strong>Tata Cara Tindakan:</strong> Prosedur antiseptik, pemberian anestesi lokal/sedasi, tindakan operatif minor, hemostasis, dan penjahitan.</li>
                        <li><strong>Risiko & Komplikasi yang Mungkin Terjadi:</strong> Perdarahan minor, reaksi alergi obat anestesi, hematoma, nyeri pasca tindakan, atau infeksi sekunder.</li>
                        <li><strong>Alternatif Tindakan:</strong> Telah dijelaskan tindakan medis alternatif beserta kelebihan dan kekurangannya.</li>
                    </ul>
                </div>
            </div>

            <!-- Tanda Tangan Tersimpan -->
            @if($consent)
                <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="text-center sm:text-left">
                        <span class="text-xs text-slate-500 block">Dokter Penanggung Jawab:</span>
                        <div class="h-16 flex items-center justify-center sm:justify-start">
                            <span class="font-serif italic text-base text-slate-700">dr. Ahmad Santoso</span>
                        </div>
                        <p class="text-xs font-bold text-slate-800">dr. Ahmad Santoso</p>
                        <p class="text-[10px] text-slate-400">SIP. 198401012010121001</p>
                    </div>

                    <div class="text-center sm:text-right">
                        <span class="text-xs text-slate-500 block">Jember, {{ $consent->created_at->format('d F Y') }}</span>
                        <span class="text-xs text-slate-500 block">Yang Menyatakan Setuju ({{ $consent->signer_relation }}):</span>
                        <div class="h-16 my-1 flex items-center justify-center sm:justify-end">
                            <img src="{{ $consent->signature_data }}" alt="Tanda Tangan Informed Consent" class="h-14 w-auto object-contain">
                        </div>
                        <p class="text-xs font-bold text-slate-800 uppercase">{{ $consent->signer_name }}</p>
                        <span class="inline-flex items-center gap-1 text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                            <i class="fa-solid fa-file-shield"></i> Sah Secara Hukum Medis
                        </span>
                    </div>
                </div>
            @endif

            <!-- Form TTD Digital Informed Consent Baru -->
            <div class="no-print pt-6 border-t border-slate-200">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">
                    Bubuhkan Persetujuan Tindakan Medis (Informed Consent)
                </h4>

                <form action="{{ route('rme.informed.consent.store') }}" method="POST" id="icForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="signature_data" id="icSigData">

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Tindakan Medis yang Disetujui <span class="text-rose-500">*</span></label>
                        <input type="text" name="procedure_name" required value="{{ $consent ? $consent->procedure_name : 'Tindakan Eksisi Kista Ateroma & Debridement Luka' }}"
                               placeholder="Contoh: Ekstraksi Gigi Impaksi, Hecting Luka Robek..."
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-bold text-slate-800">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Penanda Tangan (Pemberi Persetujuan) <span class="text-rose-500">*</span></label>
                            <input type="text" name="signer_name" required value="{{ $consent ? $consent->signer_name : $patient->name }}"
                                   class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Hubungan dengan Pasien <span class="text-rose-500">*</span></label>
                            <select name="signer_relation" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                                <option value="Diri Sendiri">Diri Sendiri (Pasien Sadar)</option>
                                <option value="Orang Tua">Orang Tua (Ayah / Ibu)</option>
                                <option value="Suami / Istri">Suami / Istri</option>
                                <option value="Anak">Anak Kandung</option>
                                <option value="Wali">Wali Pasien</option>
                            </select>
                        </div>
                    </div>

                    <!-- Canvas Signature -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-semibold text-slate-700">Tanda Tangan Digital Pasien / Keluarga:</label>
                            <button type="button" onclick="clearIcCanvas()" class="text-xs text-rose-600 hover:underline">Hapus Goresan</button>
                        </div>
                        <canvas id="icCanvas" width="500" height="150" class="w-full h-36 border-2 border-dashed border-rose-300 rounded-xl bg-slate-50 cursor-crosshair"></canvas>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="button" onclick="saveIcSignature()" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center gap-2">
                            <i class="fa-solid fa-file-shield"></i> Sahkan Informed Consent
                        </button>
                    </div>
                </form>
            </div>

        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    const icCanvas = document.getElementById('icCanvas');
    let icCtx, icDrawing = false;
    if (icCanvas) {
        icCtx = icCanvas.getContext('2d');
        icCtx.strokeStyle = '#15803d';
        icCtx.lineWidth = 2.5;
        icCtx.lineCap = 'round';

        function icStart(e) { icDrawing = true; icDraw(e); }
        function icEnd() { icDrawing = false; icCtx.beginPath(); }
        function icDraw(e) {
            if (!icDrawing) return;
            const rect = icCanvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            icCtx.lineTo(clientX - rect.left, clientY - rect.top);
            icCtx.stroke();
            icCtx.beginPath();
            icCtx.moveTo(clientX - rect.left, clientY - rect.top);
        }

        icCanvas.addEventListener('mousedown', icStart);
        icCanvas.addEventListener('mouseup', icEnd);
        icCanvas.addEventListener('mousemove', icDraw);
        icCanvas.addEventListener('touchstart', icStart);
        icCanvas.addEventListener('touchend', icEnd);
        icCanvas.addEventListener('touchmove', icDraw);
    }

    function clearIcCanvas() {
        if (icCanvas && icCtx) {
            icCtx.clearRect(0, 0, icCanvas.width, icCanvas.height);
        }
    }

    function saveIcSignature() {
        if (icCanvas) {
            const dataURL = icCanvas.toDataURL('image/png');
            document.getElementById('icSigData').value = dataURL;
        }
        document.getElementById('icForm').submit();
    }
</script>
@endpush

