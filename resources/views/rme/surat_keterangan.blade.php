@extends('rme.layout')

@section('title', 'Surat Sakit & Surat Sehat Dokter')
@section('header_title', '17. Generator Surat Keterangan Dokter (Sakit & Sehat)')

@section('content')
<div class="space-y-6">

    <!-- Form Buat Surat Keterangan Dokter Baru -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-6">
            <div>
                <h3 class="text-base font-bold text-slate-800">Penerbitan Surat Keterangan Medis</h3>
                <p class="text-xs text-slate-500">Generator Surat Keterangan Sakit (SKS) dan Surat Keterangan Sehat (SKD) resmi dokter</p>
            </div>
            <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">
                Kop Surat Dokter Otomatis
            </span>
        </div>

        <form action="{{ route('rme.surat.keterangan.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Surat <span class="text-rose-500">*</span></label>
                    <select name="type" required id="selectSuratType" onchange="toggleSuratFields()" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-bold text-slate-800">
                        <option value="sakit">Surat Keterangan Sakit (Istirahat Kerja/Kuliah)</option>
                        <option value="sehat">Surat Keterangan Sehat Jasmani (SKD)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Pasien <span class="text-rose-500">*</span></label>
                    <select name="patient_id" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-medium">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($patients as $pt)
                            <option value="{{ $pt->id }}">{{ $pt->no_rm }} - {{ $pt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Dokter Pemeriksa <span class="text-rose-500">*</span></label>
                    <input type="text" name="doctor_name" required value="dr. Ahmad Santoso"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mulai Tanggal <span class="text-rose-500">*</span></label>
                    <input type="date" name="start_date" required value="{{ date('Y-m-d') }}"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                </div>

                <div id="colRestDays">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lama Istirahat (Hari)</label>
                    <input type="number" name="rest_days" min="1" max="14" value="3"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                </div>

                <div id="colEndDate">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ date('Y-m-d', strtotime('+3 days')) }}"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Keperluan Pembuatan Surat</label>
                    <input type="text" name="purpose" placeholder="Izin Istirahat Bekerja / Persyaratan Melamar Kerja / Beasiswa..."
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Kondisi Klinis</label>
                    <input type="text" name="condition_notes" placeholder="Perlu istirahat memulihkan kondisi fisik / Dalam keadaan sehat jasmani & bebas buta warna..."
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center gap-2">
                    <i class="fa-solid fa-stamp"></i> Terbitkan & Buat Surat Keterangan
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Surat Keterangan yang Telah Diterbitkan -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-4">Arsip Surat Keterangan Dokter Diterbitkan</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-2.5 px-3">No. Surat</th>
                        <th class="py-2.5 px-3">Jenis</th>
                        <th class="py-2.5 px-3">Pasien</th>
                        <th class="py-2.5 px-3">Dokter</th>
                        <th class="py-2.5 px-3">Periode / Istirahat</th>
                        <th class="py-2.5 px-3 text-right">Cetak Surat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($certificates as $cert)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-2.5 px-3 font-mono font-bold text-slate-800">{{ $cert->certificate_number }}</td>
                            <td class="py-2.5 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                    {{ $cert->type == 'sakit' ? 'bg-rose-100 text-rose-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    Surat {{ ucfirst($cert->type) }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 font-semibold">{{ $cert->patient ? $cert->patient->name : '-' }}</td>
                            <td class="py-2.5 px-3 text-slate-600">{{ $cert->doctor_name }}</td>
                            <td class="py-2.5 px-3">
                                @if($cert->type == 'sakit')
                                    <span>{{ $cert->rest_days ?? 3 }} Hari ({{ $cert->start_date }} s.d {{ $cert->end_date ?? '-' }})</span>
                                @else
                                    <span class="text-emerald-700 font-medium">Sehat Jasmani</span>
                                @endif
                            </td>
                            <td class="py-2.5 px-3 text-right">
                                <button type="button" 
                                        onclick="showCertModal('{{ $cert->certificate_number }}', '{{ $cert->type }}', '{{ $cert->patient ? $cert->patient->name : 'Pasien' }}', '{{ $cert->patient ? $cert->patient->no_rm : '-' }}', '{{ $cert->patient ? $cert->patient->address : '-' }}', '{{ $cert->doctor_name }}', '{{ $cert->start_date }}', '{{ $cert->end_date }}', '{{ $cert->rest_days }}', '{{ $cert->purpose }}', '{{ $cert->condition_notes }}')"
                                        class="inline-flex items-center px-2.5 py-1 rounded bg-slate-100 hover:bg-yellow-100 hover:text-yellow-900 text-slate-700 text-[11px] font-semibold transition">
                                    <i class="fa-solid fa-print mr-1"></i> Cetak Surat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada surat yang diterbitkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100">
            {{ $certificates->links() }}
        </div>
    </div>

</div>

<!-- Modal Cetak Surat Dokter Resmi (Layout A4 Faskes) -->
<div id="certModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto custom-scrollbar">
        <div class="flex items-center justify-between border-b pb-3 no-print">
            <h4 class="text-sm font-bold text-slate-800">Preview Surat Keterangan Dokter</h4>
            <button onclick="document.getElementById('certModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Box Dokumen Surat -->
        <div class="border border-slate-300 p-8 rounded-xl font-sans text-xs space-y-5 bg-white text-slate-900 leading-relaxed" id="certPrintArea">
            <!-- Kop Klinik -->
            <div class="text-center border-b-2 border-slate-900 pb-3 flex items-center justify-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain">
                <div>
                    <h3 class="text-base font-extrabold uppercase tracking-wide">KLINIK PRATAMA TEFA V-KES POLIJE</h3>
                    <p class="text-[11px] text-slate-600">Jl. Mastrip PO BOX 164 Jember • Telp. 0331-333532</p>
                    <p class="text-[10px] text-slate-500">Izin Operasional No: 440/123/FKTP/2024</p>
                </div>
            </div>

            <!-- Judul Surat -->
            <div class="text-center space-y-1">
                <h4 class="text-sm font-bold uppercase underline" id="modalCertTitle">SURAT KETERANGAN SAKIT</h4>
                <p class="text-[11px] font-mono" id="modalCertNo">No: SKS/VKES/2026/001</p>
            </div>

            <!-- Isi Surat -->
            <div class="space-y-3">
                <p>Yang bertanda tangan di bawah ini, Dokter Pemeriksa pada Klinik Pratama TeFa V-Kes Politeknik Negeri Jember menerangkan dengan sebenarnya bahwa:</p>
                <div class="p-3 bg-slate-50 rounded-lg space-y-1 font-medium pl-6">
                    <p>Nama Pasien: <strong id="modalCertPatient" class="uppercase">-</strong></p>
                    <p>No. Rekam Medis: <span id="modalCertRm" class="font-mono">-</span></p>
                    <p>Alamat Pasien: <span id="modalCertAddress">-</span></p>
                </div>

                <div id="modalCertBodySakit">
                    <p>Berhubung karena kondisi kesehatan yang sakit, yang bersangkutan memerlukan <strong>istirahat selama <span id="modalCertDays">3</span> hari</strong> terhitung mulai tanggal <span id="modalCertStart">-</span> sampai dengan tanggal <span id="modalCertEnd">-</span>.</p>
                </div>

                <div id="modalCertBodySehat" class="hidden">
                    <p>Setelah dilakukan pemeriksaan fisik dan tanda vital dengan teliti, dinyatakan berada dalam keadaan <strong>SEHAT JASMANI & BEBAS BUTA WARNA</strong>.</p>
                    <p>Surat keterangan ini diberikan untuk keperluan: <strong id="modalCertPurpose">-</strong>.</p>
                </div>

                <p>Demikian surat keterangan ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>

            <!-- Tanda Tangan Dokter -->
            <div class="pt-8 flex justify-end">
                <div class="text-center w-56">
                    <p>Jember, {{ date('d F Y') }}</p>
                    <p class="font-semibold text-slate-700">Dokter Pemeriksa,</p>
                    <div class="h-16 flex items-center justify-center">
                        <span class="font-serif italic text-base text-slate-700" id="modalCertDoctorSig">dr. Ahmad Santoso</span>
                    </div>
                    <p class="font-bold underline text-slate-900 uppercase" id="modalCertDoctor">dr. Ahmad Santoso</p>
                    <p class="text-[10px] text-slate-500">SIP: 198401012010121001</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2 no-print">
            <button onclick="document.getElementById('certModal').classList.add('hidden')" class="px-3.5 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">Tutup</button>
            <button onclick="window.print()" class="px-5 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 shadow">
                <i class="fa-solid fa-print"></i> Cetak Dokumen Ini
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleSuratFields() {
        const type = document.getElementById('selectSuratType').value;
        const colDays = document.getElementById('colRestDays');
        const colEnd = document.getElementById('colEndDate');
        if (type === 'sehat') {
            colDays.classList.add('hidden');
            colEnd.classList.add('hidden');
        } else {
            colDays.classList.remove('hidden');
            colEnd.classList.remove('hidden');
        }
    }

    function showCertModal(no, type, patient, rm, address, doctor, start, end, days, purpose, notes) {
        document.getElementById('modalCertNo').innerText = 'No: ' + no;
        document.getElementById('modalCertPatient').innerText = patient;
        document.getElementById('modalCertRm').innerText = rm;
        document.getElementById('modalCertAddress').innerText = address;
        document.getElementById('modalCertDoctor').innerText = doctor;
        document.getElementById('modalCertDoctorSig').innerText = doctor;

        if (type === 'sehat') {
            document.getElementById('modalCertTitle').innerText = 'SURAT KETERANGAN DOKTER (SEHAT)';
            document.getElementById('modalCertBodySakit').classList.add('hidden');
            document.getElementById('modalCertBodySehat').classList.remove('hidden');
            document.getElementById('modalCertPurpose').innerText = purpose || 'Persyaratan Administrasi';
        } else {
            document.getElementById('modalCertTitle').innerText = 'SURAT KETERANGAN SAKIT';
            document.getElementById('modalCertBodySakit').classList.remove('hidden');
            document.getElementById('modalCertBodySehat').classList.add('hidden');
            document.getElementById('modalCertDays').innerText = days || '3';
            document.getElementById('modalCertStart').innerText = start;
            document.getElementById('modalCertEnd').innerText = end || '-';
        }

        document.getElementById('certModal').classList.remove('hidden');
    }
</script>
@endpush

