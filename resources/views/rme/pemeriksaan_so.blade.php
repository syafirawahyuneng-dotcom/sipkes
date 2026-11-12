@extends('rme.layout')

@section('title', 'Pemeriksaan Klinis (SO - Subjektif & Objektif)')
@section('header_title', '3. Pemeriksaan Klinis Subjektif & Objektif (SO)')

@section('content')
<div class="space-y-6">

    <!-- Card Pemeriksaan SO -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5 mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Rekam Medis SOAP - Bagian S & O</h3>
                <p class="text-xs text-slate-500">Pencatatan Anamnesis (Subjektif) dan Pemeriksaan Fisik & Tanda Vital (Objektif)</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    <i class="fa-solid fa-check-circle mr-1"></i> Standar SOAP Kemenkes
                </span>
            </div>
        </div>

        <form action="{{ route('rme.pemeriksaan.so.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Identitas Pasien & Dokter Pemeriksa -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Pasien Terdaftar <span class="text-rose-500">*</span></label>
                    <select name="patient_id" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none bg-white">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ ($selectedPatient && $selectedPatient->id == $p->id) ? 'selected' : '' }}>
                                {{ $p->no_rm }} - {{ $p->name }} ({{ $p->gender }}, {{ \Carbon\Carbon::parse($p->birth_date)->age }} th)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Poli Pelayanan <span class="text-rose-500">*</span></label>
                    <select name="poli" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none bg-white">
                        <option value="Poli Umum">Poli Umum</option>
                        <option value="Poli Gigi">Poli Gigi & Mulut</option>
                        <option value="Poli KIA/KB">Poli KIA & KB</option>
                        <option value="UGD">Unit Gawat Darurat (UGD)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Dokter / Petugas Pemeriksa <span class="text-rose-500">*</span></label>
                    <input type="text" name="doctor_name" required value="dr. Ahmad Santoso"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none bg-white">
                </div>
            </div>

            <!-- Bagian 1: SUBJEKTIF (S) - Anamnesis -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center text-xs">S</span>
                    <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Pemeriksaan Subjektif (Anamnesis)</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Keluhan Utama <span class="text-rose-500">*</span></label>
                        <textarea name="complaint_main" rows="3" required placeholder="Contoh: Pasien mengeluh demam tinggi sejak 3 hari disertai batuk kering dan sakit kepala..."
                                  class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Riwayat Penyakit Sekarang (RPS)</label>
                        <textarea name="anamnesis" rows="3" placeholder="Keluhan memberat di malam hari, nafsu makan berkurang, tidak ada riwayat sesak napas..."
                                  class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Riwayat Penyakit Dahulu (RPD)</label>
                        <input type="text" name="disease_history" placeholder="Hipertensi, Diabetes Mellitus, Asma..."
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Riwayat Alergi Obat / Makanan</label>
                        <input type="text" name="allergy" placeholder="Tidak ada alergi / Alergi Penisilin..."
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: OBJEKTIF (O) - Tanda Vital & Fisik -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold flex items-center justify-center text-xs">O</span>
                    <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Pemeriksaan Objektif (Tanda Vital & Fisik)</h4>
                </div>

                <!-- Vital Signs Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Tekanan Darah</label>
                        <div class="flex items-center">
                            <input type="text" name="blood_pressure" value="120/80" placeholder="120/80"
                                   class="w-full text-xs px-2 py-1.5 border border-slate-300 rounded focus:ring-1 focus:ring-primary-500 outline-none bg-white">
                        </div>
                        <span class="text-[9px] text-slate-400 mt-0.5 block">mmHg</span>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Suhu Tubuh</label>
                        <input type="number" step="0.1" name="temperature" value="36.5" placeholder="36.5"
                               class="w-full text-xs px-2 py-1.5 border border-slate-300 rounded focus:ring-1 focus:ring-primary-500 outline-none bg-white">
                        <span class="text-[9px] text-slate-400 mt-0.5 block">&deg;C</span>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Nadi (Heart Rate)</label>
                        <input type="number" name="pulse" value="80" placeholder="80"
                               class="w-full text-xs px-2 py-1.5 border border-slate-300 rounded focus:ring-1 focus:ring-primary-500 outline-none bg-white">
                        <span class="text-[9px] text-slate-400 mt-0.5 block">kali / menit</span>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Pernapasan (RR)</label>
                        <input type="number" name="respiration" value="20" placeholder="20"
                               class="w-full text-xs px-2 py-1.5 border border-slate-300 rounded focus:ring-1 focus:ring-primary-500 outline-none bg-white">
                        <span class="text-[9px] text-slate-400 mt-0.5 block">kali / menit</span>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Berat Badan (BB)</label>
                        <input type="number" step="0.1" id="inputWeight" name="weight" value="65" placeholder="65" oninput="calcBmi()"
                               class="w-full text-xs px-2 py-1.5 border border-slate-300 rounded focus:ring-1 focus:ring-primary-500 outline-none bg-white">
                        <span class="text-[9px] text-slate-400 mt-0.5 block">Kilogram (kg)</span>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Tinggi Badan (TB)</label>
                        <input type="number" id="inputHeight" name="height" value="170" placeholder="170" oninput="calcBmi()"
                               class="w-full text-xs px-2 py-1.5 border border-slate-300 rounded focus:ring-1 focus:ring-primary-500 outline-none bg-white">
                        <span class="text-[9px] text-emerald-600 font-semibold mt-0.5 block" id="bmiBadge">BMI: 22.5 (Normal)</span>
                    </div>
                </div>

                <!-- Deskripsi Pemeriksaan Fisik -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Pemeriksaan Fisik (Head to Toe)</label>
                    <textarea name="physical_exam" rows="3" placeholder="Kepala: Normocephal, Konjungtiva anemis (-/-), Faring hiperemis (+), Cor/Pulmo dalam batas normal, Abdomen supel, Bising usus (+)..."
                              class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none"></textarea>
                </div>
            </div>

            <!-- Submit Button to Step 4 -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('rme.antrian') }}" class="text-xs text-slate-500 hover:text-slate-800 font-medium">
                    &larr; Kembali ke Layar Antrian
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex items-center gap-2">
                    <span>Simpan Pemeriksaan SO & Lanjut ke Diagnosa (AP)</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Pemeriksaan Terakhir -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-4">Riwayat Pemeriksaan SO Pasien Terkini</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-2.5 px-3">Tanggal / No. RM</th>
                        <th class="py-2.5 px-3">Pasien</th>
                        <th class="py-2.5 px-3">Poli / Dokter</th>
                        <th class="py-2.5 px-3">Keluhan Utama (S)</th>
                        <th class="py-2.5 px-3">Tanda Vital (O)</th>
                        <th class="py-2.5 px-3 text-right">Aksi AP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($recentExaminations as $ex)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-2.5 px-3">
                                <span class="font-bold text-slate-800 block">{{ $ex->visit_date }}</span>
                                <span class="font-mono text-[10px] text-primary-600">{{ $ex->patient ? $ex->patient->no_rm : '-' }}</span>
                            </td>
                            <td class="py-2.5 px-3 font-semibold">{{ $ex->patient ? $ex->patient->name : '-' }}</td>
                            <td class="py-2.5 px-3">
                                <span>{{ $ex->poli }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ $ex->doctor_name }}</span>
                            </td>
                            <td class="py-2.5 px-3 max-w-xs truncate">{{ $ex->complaint_main }}</td>
                            <td class="py-2.5 px-3 font-mono text-[11px]">
                                TD: {{ $ex->blood_pressure ?? '-' }} | S: {{ $ex->temperature ?? '-' }}&deg;C
                            </td>
                            <td class="py-2.5 px-3 text-right">
                                <a href="{{ route('rme.diagnosa.tindakan', ['exam_id' => $ex->id]) }}" 
                                   class="inline-flex items-center px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white text-[11px] font-bold transition">
                                    <i class="fa-solid fa-notes-medical mr-1"></i> Input AP
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada pemeriksaan tercatat.</td>
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
    function calcBmi() {
        const w = parseFloat(document.getElementById('inputWeight').value);
        const h = parseFloat(document.getElementById('inputHeight').value) / 100;
        const badge = document.getElementById('bmiBadge');
        if (w > 0 && h > 0) {
            const bmi = (w / (h * h)).toFixed(1);
            let status = 'Normal';
            let colorClass = 'text-emerald-600';
            if (bmi < 18.5) { status = 'Kurus'; colorClass = 'text-amber-600'; }
            else if (bmi >= 25) { status = 'Kelebihan BB'; colorClass = 'text-rose-600'; }
            badge.className = `text-[9px] ${colorClass} font-semibold mt-0.5 block`;
            badge.innerText = `BMI: ${bmi} (${status})`;
        }
    }
</script>
@endpush

