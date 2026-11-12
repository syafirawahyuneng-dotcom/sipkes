@extends('rme.layout')

@section('title', 'General Consent (Persetujuan Umum)')
@section('header_title', '15. General Consent Digital & Tanda Tangan Elektronik')

@section('content')
<div class="space-y-6">

    <!-- Kontrol Pilih Pasien & Status TTD -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 no-print">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Formulir Persetujuan Umum (General Consent)</h3>
                <p class="text-xs text-slate-500">Persetujuan pasien atas hak dan kewajiban pelayanan kesehatan di Faskes</p>
            </div>

            <form action="{{ route('rme.general.consent') }}" method="GET" class="flex items-center gap-2">
                <select name="patient_id" onchange="this.form.submit()" class="text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-medium">
                    @foreach($patients as $pt)
                        <option value="{{ $pt->id }}" {{ ($patient && $patient->id == $pt->id) ? 'selected' : '' }}>
                            {{ $pt->no_rm }} - {{ $pt->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" onclick="window.print()" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold flex items-center gap-2 transition shadow">
                    <i class="fa-solid fa-print"></i> Cetak Surat
                </button>
            </form>
        </div>
    </div>

    @if($patient)
        <!-- Dokumen General Consent Resmi (Siap Cetak / Siap TTD) -->
        <div class="bg-white rounded-2xl p-8 sm:p-12 shadow-sm border border-slate-200 max-w-4xl mx-auto space-y-6 text-slate-800">
            
            <!-- Kop Surat Resmi -->
            <div class="text-center border-b-2 border-slate-800 pb-4">
                <div class="flex items-center justify-center gap-3 mb-1">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                    <div class="text-left">
                        <h2 class="text-base font-black tracking-wide uppercase">KLINIK PRATAMA TEFA V-KES POLIJE</h2>
                        <p class="text-[11px] text-slate-500">Jl. Mastrip PO BOX 164 Jember • Telp. 0331-333532 • Email: tefa-vkes@polije.ac.id</p>
                    </div>
                </div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-primary-800 mt-2">SURAT PERSETUJUAN UMUM (GENERAL CONSENT)</h3>
                <p class="text-[11px] text-slate-400">Nomor Formulir: GC/VKES/{{ date('Y') }}/{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>

            <!-- Isi Pernyataan Hukum -->
            <div class="text-xs space-y-3 leading-relaxed text-slate-700">
                <p>Saya yang bertanda tangan di bawah ini menyatakan telah menerima informasi dan menyetujui ketentuan pelayanan di Klinik Pratama TeFa V-Kes Politeknik Negeri Jember:</p>

                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 grid grid-cols-2 gap-2 font-medium">
                    <div>Nama Pasien: <strong>{{ $patient->name }}</strong></div>
                    <div>No. Rekam Medis: <strong>{{ $patient->no_rm }}</strong></div>
                    <div>NIK KTP: <strong>{{ $patient->nik ?? '-' }}</strong></div>
                    <div>Tgl. Lahir / JK: <strong>{{ $patient->birth_date }} ({{ $patient->gender }})</strong></div>
                </div>

                <h4 class="font-bold text-slate-900 pt-2">Poin Persetujuan Umum:</h4>
                <ol class="list-decimal list-inside space-y-1.5 pl-2 text-slate-600">
                    <li><strong>Persetujuan Perawatan & Pengobatan:</strong> Menyetujui pemeriksaan fisik, pemeriksaan penunjang (laboratorium), pemberian obat-obatan, dan tindakan medis dasar sesuai pertimbangan dokter.</li>
                    <li><strong>Pelepasan Informasi Rekam Medis:</strong> Memberikan wewenang kepada Faskes untuk mentransmisikan data klinis ke platform SATUSEHAT Kemenkes RI dan BPJS Kesehatan sesuai Permenkes 24/2022.</li>
                    <li><strong>Hak & Kewajiban Pasien:</strong> Memahami hak untuk memperoleh penjelasan medis serta berkewajiban memberikan riwayat kesehatan yang jujur dan benar.</li>
                    <li><strong>Kewajiban Keuangan:</strong> Bersedia melunasi seluruh biaya pelayanan rawat jalan / rawat inap sesuai tarif yang berlaku.</li>
                </ol>
            </div>

            <!-- Tanda Tangan Elektronik Section -->
            @if($consent)
                <!-- TTD Sudah Tersimpan -->
                <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="text-center sm:text-left">
                        <span class="text-xs text-slate-500 block">Petugas Penerima Konsen:</span>
                        <div class="h-16 flex items-center justify-center sm:justify-start">
                            <span class="font-serif italic text-base text-slate-700">dr. Ahmad Santoso</span>
                        </div>
                        <p class="text-xs font-bold text-slate-800">dr. Ahmad Santoso</p>
                        <p class="text-[10px] text-slate-400">SIP. 198401012010121001</p>
                    </div>

                    <div class="text-center sm:text-right">
                        <span class="text-xs text-slate-500 block">Jember, {{ $consent->created_at->format('d F Y') }}</span>
                        <span class="text-xs text-slate-500 block">Pemberi Persetujuan ({{ $consent->signer_relation }}):</span>
                        <div class="h-16 my-1 flex items-center justify-center sm:justify-end">
                            <img src="{{ $consent->signature_data }}" alt="Tanda Tangan Digital" class="h-14 w-auto object-contain">
                        </div>
                        <p class="text-xs font-bold text-slate-800 uppercase">{{ $consent->signer_name }}</p>
                        <span class="inline-flex items-center gap-1 text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                            <i class="fa-solid fa-circle-check"></i> Tanda Tangan Terverifikasi Digital
                        </span>
                    </div>
                </div>
            @endif

            <!-- Form TTD Digital Canvas (Jika Belum TTD atau Ingin TTD Ulang) -->
            <div class="no-print pt-6 border-t border-slate-200">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">
                    {{ $consent ? 'Perbarui Tanda Tangan Digital' : 'Bubuhkan Tanda Tangan Digital Pasien / Wali' }}
                </h4>

                <form action="{{ route('rme.general.consent.store') }}" method="POST" id="gcForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="signature_data" id="gcSigData">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Penanda Tangan <span class="text-rose-500">*</span></label>
                            <input type="text" name="signer_name" required value="{{ $consent ? $consent->signer_name : $patient->name }}"
                                   class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Hubungan dengan Pasien <span class="text-rose-500">*</span></label>
                            <select name="signer_relation" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                                <option value="Diri Sendiri">Diri Sendiri (Pasien)</option>
                                <option value="Orang Tua">Orang Tua (Ayah / Ibu)</option>
                                <option value="Suami / Istri">Suami / Istri</option>
                                <option value="Anak">Anak Kandung</option>
                                <option value="Wali">Wali / Keluarga Penanggung Jawab</option>
                            </select>
                        </div>
                    </div>

                    <!-- Signature Pad Canvas -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-semibold text-slate-700">Goreskan Tanda Tangan pada Kotak di Bawah:</label>
                            <button type="button" onclick="clearCanvas()" class="text-xs text-rose-600 hover:underline">Hapus / Reset Goresan</button>
                        </div>
                        <canvas id="sigCanvas" width="500" height="150" class="w-full h-36 border-2 border-dashed border-slate-400 rounded-xl bg-slate-50 cursor-crosshair"></canvas>
                        <p class="text-[10px] text-slate-400 mt-1">Gunakan mouse atau jari Anda pada layar sentuh untuk menandatangani secara digital.</p>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="button" onclick="saveGcSignature()" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold transition shadow-md flex items-center gap-2">
                            <i class="fa-solid fa-file-signature"></i> Simpan General Consent Sah
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
    const canvas = document.getElementById('sigCanvas');
    let ctx, drawing = false;
    if (canvas) {
        ctx = canvas.getContext('2d');
        ctx.strokeStyle = '#1e3a8a';
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';

        function startPos(e) { drawing = true; draw(e); }
        function endPos() { drawing = false; ctx.beginPath(); }
        function draw(e) {
            if (!drawing) return;
            const rect = canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            ctx.lineTo(clientX - rect.left, clientY - rect.top);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(clientX - rect.left, clientY - rect.top);
        }

        canvas.addEventListener('mousedown', startPos);
        canvas.addEventListener('mouseup', endPos);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('touchstart', startPos);
        canvas.addEventListener('touchend', endPos);
        canvas.addEventListener('touchmove', draw);
    }

    function clearCanvas() {
        if (canvas && ctx) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    }

    function saveGcSignature() {
        if (canvas) {
            const dataURL = canvas.toDataURL('image/png');
            document.getElementById('gcSigData').value = dataURL;
        }
        document.getElementById('gcForm').submit();
    }
</script>
@endpush

