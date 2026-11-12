@extends('rme.layout')

@section('title', 'Diagnosa & Tindakan (AP)')
@section('header_title', '4. Diagnosa ICD-10 & Tindakan Medis (AP)')

@section('content')
<div class="space-y-6">

    @if(!$exam && count($examinations) > 0)
        <!-- Banner Pilih Pasien yang Menunggu Input AP -->
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl shadow-sm">
            <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wide">Pilih Pemeriksaan Pasien yang Memerlukan Diagnosa (AP)</h4>
            <p class="text-xs text-amber-700 mt-0.5">Terdapat {{ count($examinations) }} pasien yang telah selesai pemeriksaan Subjektif & Objektif (SO) dan siap diinput diagnosanya:</p>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach($examinations as $pEx)
                    <a href="{{ route('rme.diagnosa.tindakan', ['exam_id' => $pEx->id]) }}" 
                       class="px-3 py-1.5 bg-white border border-amber-300 rounded-lg text-xs font-semibold text-amber-900 hover:bg-amber-100 transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-user text-amber-600"></i>
                        <span>{{ $pEx->patient ? $pEx->patient->name : 'Pasien' }} ({{ $pEx->poli }})</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @if($exam)
        <!-- Kartu Pasien Terpilih & Resume SO -->
        <div class="bg-gradient-to-r from-purple-900 to-indigo-900 text-white rounded-2xl p-6 shadow-md">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-purple-700/60 pb-3 mb-3">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-purple-700 text-white font-bold flex items-center justify-center text-sm">
                        {{ strtoupper(substr($exam->patient ? $exam->patient->name : 'P', 0, 1)) }}
                    </span>
                    <div>
                        <h3 class="text-lg font-bold">{{ $exam->patient ? $exam->patient->name : 'Pasien' }}</h3>
                        <p class="text-xs text-purple-200">No. RM: {{ $exam->patient ? $exam->patient->no_rm : '-' }} • Poli: {{ $exam->poli }} • Dokter: {{ $exam->doctor_name }}</p>
                    </div>
                </div>
                <a href="{{ route('rme.diagnosa.tindakan') }}" class="text-xs text-purple-200 hover:text-white underline">
                    Ganti Pasien
                </a>
            </div>

            <!-- Resume SOAP (S & O) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                <div class="bg-purple-950/50 p-2.5 rounded-lg border border-purple-800">
                    <span class="text-[10px] text-purple-300 font-bold block uppercase">Keluhan Utama (S):</span>
                    <span class="font-medium text-white">{{ $exam->complaint_main }}</span>
                </div>
                <div class="bg-purple-950/50 p-2.5 rounded-lg border border-purple-800">
                    <span class="text-[10px] text-purple-300 font-bold block uppercase">Tanda Vital (O):</span>
                    <span class="font-mono text-white">TD: {{ $exam->blood_pressure ?? '-' }} | S: {{ $exam->temperature ?? '-' }}&deg;C</span>
                </div>
                <div class="bg-purple-950/50 p-2.5 rounded-lg border border-purple-800">
                    <span class="text-[10px] text-purple-300 font-bold block uppercase">Nadi & Pernapasan:</span>
                    <span class="font-mono text-white">HR: {{ $exam->pulse ?? '-' }} | RR: {{ $exam->respiration ?? '-' }}</span>
                </div>
                <div class="bg-purple-950/50 p-2.5 rounded-lg border border-purple-800">
                    <span class="text-[10px] text-purple-300 font-bold block uppercase">Riwayat Alergi:</span>
                    <span class="text-amber-300 font-bold">{{ $exam->allergy ?? 'Tidak ada alergi' }}</span>
                </div>
            </div>
        </div>

        <!-- Form Pengisian Assessment (A) & Plan (P) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Form AP (2 Kolom) -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
                <h3 class="text-base font-bold text-slate-800 mb-1">Pemberian Diagnosa (Assessment) & Terapi (Plan)</h3>
                <p class="text-xs text-slate-500 mb-6">Secara otomatis menghasilkan tagihan kasir dan resep di modul farmasi.</p>

                <form action="{{ route('rme.diagnosa.tindakan.store', $exam->id) }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Bagian A: ASSESSMENT (Diagnosa ICD-10) -->
                    <div class="p-4 rounded-xl bg-purple-50/50 border border-purple-200 space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-purple-600 text-white font-bold flex items-center justify-center text-xs">A</span>
                            <h4 class="text-xs font-bold text-purple-950 uppercase tracking-wide">Assessment (Diagnosa ICD-10)</h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Kode ICD-10 <span class="text-rose-500">*</span></label>
                                <input type="text" id="diagCode" name="diagnosis_code" required value="{{ $exam->diagnosis_code ?? 'J00' }}"
                                       class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none font-mono font-bold bg-white">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Diagnosa Klinis <span class="text-rose-500">*</span></label>
                                <input type="text" id="diagName" name="diagnosis_name" required value="{{ $exam->diagnosis_name ?? 'Acute nasopharyngitis [common cold]' }}"
                                       class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Prognosis <span class="text-rose-500">*</span></label>
                            <select name="prognosis" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none bg-white">
                                <option value="Bonam (Baik)" {{ ($exam->prognosis == 'Bonam (Baik)') ? 'selected' : '' }}>Bonam (Baik / Sembuh Sempurna)</option>
                                <option value="Dubia ad Bonam" {{ ($exam->prognosis == 'Dubia ad Bonam') ? 'selected' : '' }}>Dubia ad Bonam (Cenderung Baik)</option>
                                <option value="Dubia ad Malam" {{ ($exam->prognosis == 'Dubia ad Malam') ? 'selected' : '' }}>Dubia ad Malam (Cenderung Memburuk)</option>
                                <option value="Malam" {{ ($exam->prognosis == 'Malam') ? 'selected' : '' }}>Malam (Buruk)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Bagian P: PLAN (Tindakan & Resep Obat) -->
                    <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-200 space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-blue-600 text-white font-bold flex items-center justify-center text-xs">P</span>
                            <h4 class="text-xs font-bold text-blue-950 uppercase tracking-wide">Plan (Tindakan Medis & Resep Farmasi)</h4>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Tindakan Medis / ICD-9-CM</label>
                            <input type="text" name="procedure_action" value="{{ $exam->procedure_action ?? 'Konseling Edukasi Kesehatan, Observasi Tanda Vital' }}" placeholder="Contoh: Nebulisasi, Perawatan Luka, Pencabutan Gigi..."
                                   class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Resep Obat & Aturan Pakai</label>
                            <textarea name="prescription_notes" rows="3" placeholder="R/ Paracetamol 500mg No. X, S 3 dd tab 1 prn demam&#10;R/ Vitamin C 50 mg No. X, S 1 dd tab 1 pc"
                                      class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white font-mono">{{ $exam->prescription_notes ?? "R/ Paracetamol 500 mg No. X, S 3 dd tab 1\nR/ Vitamin C 50 mg No. X, S 1 dd tab 1" }}</textarea>
                            <p class="text-[10px] text-slate-500 mt-1">Resep ini akan langsung tersinkronisasi ke modul Farmasi & Kasir Billing.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                        <button type="submit" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan AP & Terbitkan Billing Tagihan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Referensi Cepat Kode ICD-10 Faskes Primer (1 Kolom) -->
            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-book-medical text-purple-600"></i> Referensi Cepat ICD-10 FKTP
                    </h4>
                    <p class="text-[11px] text-slate-500 mb-3">Klik salah satu diagnosa untuk mengisi form otomatis:</p>
                    
                    <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar pr-1">
                        @foreach($icd10 as $ref)
                            <button type="button" 
                                    onclick="pickIcd('{{ $ref['code'] }}', '{{ addslashes($ref['name']) }}')"
                                    class="w-full text-left p-2 rounded-lg border border-slate-200 hover:border-purple-400 hover:bg-purple-50 transition flex items-start gap-2 text-xs">
                                <span class="px-1.5 py-0.5 rounded bg-purple-100 text-purple-800 font-mono font-bold text-[10px]">
                                    {{ $ref['code'] }}
                                </span>
                                <span class="text-slate-700 leading-tight">{{ $ref['name'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Daftar Obat Tersedia di Apotek -->
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-pills text-teal-600"></i> Stok Obat Apotek Siap Resep
                    </h4>
                    <div class="space-y-1.5 max-h-48 overflow-y-auto custom-scrollbar text-xs">
                        @foreach($medicines->take(8) as $m)
                            <div class="flex items-center justify-between p-1.5 rounded bg-slate-50 border border-slate-100">
                                <span class="font-semibold text-slate-800">{{ $m->name }}</span>
                                <span class="text-[10px] text-emerald-600 font-mono font-bold">{{ $m->stock }} {{ $m->unit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    @endif

    <!-- Tabel Rekam Medis Selesai -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-4">Daftar Pemeriksaan Medis Selesai (SO & AP Lengkap)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-2.5 px-3">Tanggal / RM</th>
                        <th class="py-2.5 px-3">Pasien</th>
                        <th class="py-2.5 px-3">ICD-10 Diagnosa</th>
                        <th class="py-2.5 px-3">Prognosis</th>
                        <th class="py-2.5 px-3">Tindakan / Resep</th>
                        <th class="py-2.5 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($completedExaminations as $cEx)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-2.5 px-3">
                                <span class="font-bold text-slate-800 block">{{ $cEx->visit_date }}</span>
                                <span class="font-mono text-[10px] text-primary-600">{{ $cEx->patient ? $cEx->patient->no_rm : '-' }}</span>
                            </td>
                            <td class="py-2.5 px-3 font-semibold">{{ $cEx->patient ? $cEx->patient->name : '-' }}</td>
                            <td class="py-2.5 px-3">
                                <span class="font-mono font-bold text-purple-700">{{ $cEx->diagnosis_code }}</span>
                                <span class="text-slate-600 block text-[11px]">{{ $cEx->diagnosis_name }}</span>
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                    {{ $cEx->prognosis }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 max-w-xs truncate text-[11px]">
                                {{ $cEx->procedure_action ?? '-' }}
                            </td>
                            <td class="py-2.5 px-3 text-right space-x-1">
                                <a href="{{ route('rme.farmasi') }}" title="Lihat Resep di Farmasi" class="inline-flex items-center px-2 py-1 rounded bg-teal-50 text-teal-700 hover:bg-teal-600 hover:text-white text-[11px] font-semibold transition">
                                    <i class="fa-solid fa-pills mr-1"></i> Farmasi
                                </a>
                                <a href="{{ route('rme.kasir') }}" title="Lihat Tagihan Kasir" class="inline-flex items-center px-2 py-1 rounded bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white text-[11px] font-semibold transition">
                                    <i class="fa-solid fa-cash-register mr-1"></i> Kasir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada pemeriksaan dengan diagnosa lengkap.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function pickIcd(code, name) {
        document.getElementById('diagCode').value = code;
        document.getElementById('diagName').value = name;
    }
</script>
@endpush

