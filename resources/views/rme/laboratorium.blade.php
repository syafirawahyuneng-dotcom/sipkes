@extends('rme.layout')

@section('title', 'Laboratorium Medis')
@section('header_title', '18. Modul Pemeriksaan Laboratorium & Uji Diagnostik')

@section('content')
<div class="space-y-6">

    <!-- Form Input Hasil Uji Laboratorium -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-6">
            <div>
                <h3 class="text-base font-bold text-slate-800">Pencatatan Hasil Uji Laboratorium</h3>
                <p class="text-xs text-slate-500">Hematologi, Kimia Darah, Urinalisis, & Parameter Diagnostik FKTP</p>
            </div>
            <span class="px-3 py-1 bg-teal-100 text-teal-800 text-xs font-bold rounded-full">
                Standar Nilai Rujukan
            </span>
        </div>

        <form action="{{ route('rme.laboratorium.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                    <label class="block text-xs font-bold text-slate-700 mb-1">Dokter / Analis Pengirim <span class="text-rose-500">*</span></label>
                    <input type="text" name="doctor_name" required value="dr. Ahmad Santoso"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                </div>
            </div>

            <!-- Preset Parameter Uji Populer -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Parameter Pemeriksaan Lab <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-2">
                    <button type="button" onclick="setLabPreset('Hemoglobin (Hb)', '13.0 - 17.0', 'g/dL')" class="p-2 text-left rounded-lg border border-slate-200 hover:border-teal-500 hover:bg-teal-50 text-xs transition">
                        <span class="font-bold block text-slate-800">Hemoglobin (Hb)</span>
                        <span class="text-[10px] text-slate-400">Ruj: 13.0 - 17.0 g/dL</span>
                    </button>
                    <button type="button" onclick="setLabPreset('Glukosa Darah Puasa (GDP)', '70 - 110', 'mg/dL')" class="p-2 text-left rounded-lg border border-slate-200 hover:border-teal-500 hover:bg-teal-50 text-xs transition">
                        <span class="font-bold block text-slate-800">Glukosa Darah (GDP)</span>
                        <span class="text-[10px] text-slate-400">Ruj: 70 - 110 mg/dL</span>
                    </button>
                    <button type="button" onclick="setLabPreset('Asam Urat (Uric Acid)', '3.4 - 7.0', 'mg/dL')" class="p-2 text-left rounded-lg border border-slate-200 hover:border-teal-500 hover:bg-teal-50 text-xs transition">
                        <span class="font-bold block text-slate-800">Asam Urat</span>
                        <span class="text-[10px] text-slate-400">Ruj: 3.4 - 7.0 mg/dL</span>
                    </button>
                    <button type="button" onclick="setLabPreset('Kolesterol Total', '< 200', 'mg/dL')" class="p-2 text-left rounded-lg border border-slate-200 hover:border-teal-500 hover:bg-teal-50 text-xs transition">
                        <span class="font-bold block text-slate-800">Kolesterol Total</span>
                        <span class="text-[10px] text-slate-400">Ruj: &lt; 200 mg/dL</span>
                    </button>
                </div>

                <input type="text" id="labParamName" name="parameter_name" required value="Hemoglobin (Hb)"
                       class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-semibold">
            </div>

            <!-- Hasil, Nilai Normal, Satuan, Status -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hasil Uji <span class="text-rose-500">*</span></label>
                    <input type="text" name="result_value" required value="14.2" placeholder="14.2"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono font-bold">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Rujukan Normal <span class="text-rose-500">*</span></label>
                    <input type="text" id="labNormalRange" name="normal_range" required value="13.0 - 17.0"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Satuan <span class="text-rose-500">*</span></label>
                    <input type="text" id="labUnit" name="unit" required value="g/dL"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Indikator Status <span class="text-rose-500">*</span></label>
                    <select name="status_indicator" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-bold">
                        <option value="Normal">Normal (Dalam Batas)</option>
                        <option value="Tinggi">Tinggi (Di Atas Batas)</option>
                        <option value="Rendah">Rendah (Di Bawah Batas)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kesimpulan / Catatan Analis</label>
                <input type="text" name="conclusion" value="Nilai hemoglobin dalam batas normal, tidak ada indikasi anemia."
                       class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center gap-2">
                    <i class="fa-solid fa-vial-circle-check"></i> Simpan Hasil Uji Laboratorium
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Uji Lab & Cetak Hasil -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-4">Riwayat Hasil Pemeriksaan Laboratorium Pasien</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-2.5 px-3">Tanggal / RM</th>
                        <th class="py-2.5 px-3">Pasien</th>
                        <th class="py-2.5 px-3">Parameter Uji</th>
                        <th class="py-2.5 px-3">Hasil Uji</th>
                        <th class="py-2.5 px-3">Nilai Rujukan</th>
                        <th class="py-2.5 px-3">Status</th>
                        <th class="py-2.5 px-3 text-right">Cetak Hasil</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($labTests as $lab)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-2.5 px-3">
                                <span class="font-bold text-slate-800 block">{{ $lab->created_at->format('d/m/Y') }}</span>
                                <span class="font-mono text-[10px] text-primary-600">{{ $lab->patient ? $lab->patient->no_rm : '-' }}</span>
                            </td>
                            <td class="py-2.5 px-3 font-semibold">{{ $lab->patient ? $lab->patient->name : '-' }}</td>
                            <td class="py-2.5 px-3 font-bold text-teal-900">{{ $lab->parameter_name }}</td>
                            <td class="py-2.5 px-3 font-mono font-bold text-sm text-slate-900">
                                {{ $lab->result_value }} {{ $lab->unit }}
                            </td>
                            <td class="py-2.5 px-3 font-mono text-slate-500">{{ $lab->normal_range }} {{ $lab->unit }}</td>
                            <td class="py-2.5 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold
                                    {{ $lab->status_indicator == 'Normal' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $lab->status_indicator }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-right">
                                <button type="button" 
                                        onclick="showLabModal('{{ $lab->patient ? $lab->patient->name : 'Pasien' }}', '{{ $lab->patient ? $lab->patient->no_rm : '-' }}', '{{ $lab->doctor_name }}', '{{ $lab->parameter_name }}', '{{ $lab->result_value }}', '{{ $lab->normal_range }}', '{{ $lab->unit }}', '{{ $lab->status_indicator }}', '{{ $lab->conclusion }}')"
                                        class="inline-flex items-center px-2.5 py-1 rounded bg-teal-50 text-teal-700 hover:bg-teal-600 hover:text-white text-[11px] font-semibold transition">
                                    <i class="fa-solid fa-print mr-1"></i> Cetak Lembar Lab
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-400">Belum ada hasil uji laboratorium.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100">
            {{ $labTests->links() }}
        </div>
    </div>

</div>

<!-- Modal Lembar Hasil Uji Lab Siap Cetak -->
<div id="labModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-8 shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b pb-3 no-print">
            <h4 class="text-sm font-bold text-slate-800">Preview Lembar Hasil Uji Laboratorium</h4>
            <button onclick="document.getElementById('labModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="border border-slate-300 p-6 rounded-xl font-sans text-xs space-y-4 bg-white text-slate-900" id="labPrintArea">
            <!-- Kop Lab -->
            <div class="text-center border-b-2 border-slate-900 pb-3 flex items-center justify-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                <div>
                    <h3 class="text-sm font-black uppercase">INSTALASI LABORATORIUM KLINIK</h3>
                    <p class="text-[11px] text-slate-600">Klinik Pratama TeFa V-Kes Politeknik Negeri Jember</p>
                </div>
            </div>

            <!-- Info Pasien -->
            <div class="grid grid-cols-2 gap-2 p-2.5 bg-slate-50 rounded-lg font-medium text-[11px]">
                <p>Nama Pasien: <strong id="mLabPatient">-</strong></p>
                <p>No. Rekam Medis: <strong id="mLabRm">-</strong></p>
                <p>Dokter Pengirim: <span id="mLabDoc">-</span></p>
                <p>Tanggal Pemeriksaan: <span>{{ date('d/m/Y') }}</span></p>
            </div>

            <!-- Tabel Parameter -->
            <table class="w-full text-left border-collapse border border-slate-300 text-xs">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 text-[11px] font-bold">
                        <th class="p-2 border-r border-slate-300">Pemeriksaan</th>
                        <th class="p-2 border-r border-slate-300 text-center">Hasil</th>
                        <th class="p-2 border-r border-slate-300 text-center">Nilai Rujukan</th>
                        <th class="p-2 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2 border-r border-slate-300 font-bold" id="mLabParam">-</td>
                        <td class="p-2 border-r border-slate-300 text-center font-mono font-bold" id="mLabResult">-</td>
                        <td class="p-2 border-r border-slate-300 text-center font-mono" id="mLabRef">-</td>
                        <td class="p-2 text-center font-bold" id="mLabStatus">-</td>
                    </tr>
                </tbody>
            </table>

            <!-- Kesimpulan -->
            <div class="p-2.5 rounded bg-slate-50 border border-slate-200">
                <span class="text-[10px] font-bold text-slate-400 block uppercase">Kesimpulan / Catatan Analis:</span>
                <p class="text-xs text-slate-700" id="mLabNotes">-</p>
            </div>

            <!-- Tanda Tangan Penanggung Jawab Lab -->
            <div class="pt-4 flex justify-end">
                <div class="text-center w-48">
                    <p class="text-[11px]">Penanggung Jawab Laboratorium,</p>
                    <div class="h-12 flex items-center justify-center">
                        <span class="font-serif italic text-sm">dr. Ahmad Santoso</span>
                    </div>
                    <p class="font-bold underline text-xs">dr. Ahmad Santoso</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2 no-print">
            <button onclick="document.getElementById('labModal').classList.add('hidden')" class="px-3.5 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">Tutup</button>
            <button onclick="window.print()" class="px-5 py-1.5 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 shadow">
                <i class="fa-solid fa-print"></i> Cetak Hasil Lab
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setLabPreset(param, range, unit) {
        document.getElementById('labParamName').value = param;
        document.getElementById('labNormalRange').value = range;
        document.getElementById('labUnit').value = unit;
    }

    function showLabModal(patient, rm, doc, param, result, ref, unit, status, notes) {
        document.getElementById('mLabPatient').innerText = patient;
        document.getElementById('mLabRm').innerText = rm;
        document.getElementById('mLabDoc').innerText = doc;
        document.getElementById('mLabParam').innerText = param;
        document.getElementById('mLabResult').innerText = result + ' ' + unit;
        document.getElementById('mLabRef').innerText = ref + ' ' + unit;
        document.getElementById('mLabStatus').innerText = status;
        document.getElementById('mLabNotes').innerText = notes || '-';
        document.getElementById('labModal').classList.remove('hidden');
    }
</script>
@endpush

