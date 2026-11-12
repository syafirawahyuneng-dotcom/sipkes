@extends('rme.layout')

@section('title', 'Pemantauan Tindakan Sedasi & Bedah Minor')
@section('header_title', '19. Pemantauan Sedasi, Anestesi Lokal & Skor Pemulihan Aldrete')

@section('content')
<div class="space-y-6">

    <!-- Form Pemantauan Sedasi & Skor Aldrete Interaktif -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-6">
            <div>
                <h3 class="text-base font-bold text-slate-800">Lembar Observasi & Monitoring Tindakan Sedasi</h3>
                <p class="text-xs text-slate-500">Standar pemantauan pra, intra, dan pasca-sedasi dengan kalkulator Skor Pemulihan Aldrete</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 border border-indigo-200">
                    <i class="fa-solid fa-heart-pulse mr-1"></i> Standar Akreditasi Kemenkes
                </span>
            </div>
        </div>

        <form action="{{ route('rme.sedasi.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Identitas Pasien, Prosedur & Dokter -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
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
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tindakan Bedah Minor / Prosedur <span class="text-rose-500">*</span></label>
                    <input type="text" name="procedure_name" required value="Eksisi Kista Ateroma & Debridement Luka"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Sedasi / Anestesi <span class="text-rose-500">*</span></label>
                    <select name="sedation_type" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-medium">
                        <option value="Anestesi Lokal Infiltrasi (Lidocaine 2%)">Anestesi Lokal Infiltrasi (Lidocaine 2%)</option>
                        <option value="Sedasi Ringan (Minimal Sedation)">Sedasi Ringan (Minimal Sedation)</option>
                        <option value="Sedasi Sedang / Sadar (Moderate Sedation)">Sedasi Sedang / Sadar (Moderate Sedation)</option>
                        <option value="Blok Saraf Perifer">Blok Saraf Perifer</option>
                    </select>
                </div>
            </div>

            <!-- Dokter & Premedikasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dokter Operator / Penanggung Jawab <span class="text-rose-500">*</span></label>
                    <input type="text" name="doctor_name" required value="dr. Ahmad Santoso"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Premedikasi / Obat Anestesi yang Diberikan</label>
                    <input type="text" name="premedication" value="Lidocaine 2% 4 ml + Adrenalin 1:200.000"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
                </div>
            </div>

            <!-- Tanda Vital Intra & Pasca Sedasi -->
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Monitoring Tanda Vital Pasca Tindakan</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Tekanan Darah (TD)</label>
                        <input type="text" name="monitor_bp" value="120/80" placeholder="120/80"
                               class="w-full text-xs px-2.5 py-1.5 border border-slate-300 rounded font-mono bg-white">
                        <span class="text-[9px] text-slate-400 mt-0.5 block">mmHg</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Frekuensi Nadi (HR)</label>
                        <input type="number" name="monitor_hr" value="78" placeholder="78"
                               class="w-full text-xs px-2.5 py-1.5 border border-slate-300 rounded font-mono bg-white">
                        <span class="text-[9px] text-slate-400 mt-0.5 block">kali / menit</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Saturasi Oksigen (SpO2)</label>
                        <input type="number" name="monitor_spo2" value="99" placeholder="99"
                               class="w-full text-xs px-2.5 py-1.5 border border-slate-300 rounded font-mono bg-white font-bold text-emerald-700">
                        <span class="text-[9px] text-slate-400 mt-0.5 block">Persen (%)</span>
                    </div>
                </div>
            </div>

            <!-- Interaktif Skor Aldrete Recovery (5 Parameter Standar Internasional) -->
            <div class="p-4 rounded-xl border-2 border-indigo-200 bg-indigo-50/30 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-indigo-600 text-white font-bold flex items-center justify-center text-xs">
                            <i class="fa-solid fa-gauge-high"></i>
                        </span>
                        <div>
                            <h4 class="text-xs font-bold text-indigo-950 uppercase tracking-wide">Kalkulator Skor Pemulihan Aldrete (Aldrete Score)</h4>
                            <p class="text-[10px] text-indigo-700">Pasien aman dipindahkan / dipulangkan bila skor total &ge; 9</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] uppercase font-bold text-slate-400 block">Total Skor Aldrete</span>
                        <span id="scoreDisplay" class="font-mono text-xl font-black text-emerald-600">10 / 10</span>
                        <input type="hidden" name="aldrete_score" id="aldreteInput" value="10">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-5 gap-3 pt-2 text-xs">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 mb-1">1. Aktivitas Motorik</label>
                        <select id="pMotor" onchange="recalcAldrete()" class="w-full text-[11px] p-1.5 border border-slate-300 rounded bg-white">
                            <option value="2">2 - Gerak 4 Ekstremitas</option>
                            <option value="1">1 - Gerak 2 Ekstremitas</option>
                            <option value="0">0 - Tak Dapat Gerak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 mb-1">2. Pernapasan</label>
                        <select id="pResp" onchange="recalcAldrete()" class="w-full text-[11px] p-1.5 border border-slate-300 rounded bg-white">
                            <option value="2">2 - Mampu Nafas Dalam</option>
                            <option value="1">1 - Nafas Dangkal/Sesak</option>
                            <option value="0">0 - Apnea / Bantuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 mb-1">3. Tekanan Darah</label>
                        <select id="pBp" onchange="recalcAldrete()" class="w-full text-[11px] p-1.5 border border-slate-300 rounded bg-white">
                            <option value="2">2 - &plusmn; 20% Pra-Sedasi</option>
                            <option value="1">1 - &plusmn; 20-50% Pra-Sedasi</option>
                            <option value="0">0 - &plusmn; 50% Pra-Sedasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 mb-1">4. Kesadaran</label>
                        <select id="pConscious" onchange="recalcAldrete()" class="w-full text-[11px] p-1.5 border border-slate-300 rounded bg-white">
                            <option value="2">2 - Sadar Penuh</option>
                            <option value="1">1 - Bangun Dipanggil</option>
                            <option value="0">0 - Belum Respon</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 mb-1">5. Warna Kulit/SpO2</label>
                        <select id="pColor" onchange="recalcAldrete()" class="w-full text-[11px] p-1.5 border border-slate-300 rounded bg-white">
                            <option value="2">2 - Kemerahan / SpO2>92%</option>
                            <option value="1">1 - Pucat / Perlu O2</option>
                            <option value="0">0 - Sianosis / SpO2&lt;90%</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Evaluasi / Instruksi Pasca Sedasi</label>
                <input type="text" name="evaluation" value="Pasien sadar penuh, tanda vital stabil, perdarahan terkontrol, diperbolehkan rawat jalan."
                       class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none">
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center gap-2">
                    <i class="fa-solid fa-bed-pulse"></i> Simpan Catatan Sedasi & Skor Aldrete
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Pemantauan Sedasi -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-4">Riwayat Pasien dengan Pemantauan Sedasi</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-2.5 px-3">Tanggal / RM</th>
                        <th class="py-2.5 px-3">Pasien</th>
                        <th class="py-2.5 px-3">Tindakan Medis</th>
                        <th class="py-2.5 px-3">Jenis Anestesi</th>
                        <th class="py-2.5 px-3">Tanda Vital</th>
                        <th class="py-2.5 px-3 text-center">Skor Aldrete</th>
                        <th class="py-2.5 px-3">Evaluasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($sedations as $sed)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-2.5 px-3">
                                <span class="font-bold text-slate-800 block">{{ $sed->created_at->format('d/m/Y') }}</span>
                                <span class="font-mono text-[10px] text-primary-600">{{ $sed->patient ? $sed->patient->no_rm : '-' }}</span>
                            </td>
                            <td class="py-2.5 px-3 font-semibold">{{ $sed->patient ? $sed->patient->name : '-' }}</td>
                            <td class="py-2.5 px-3 font-bold text-slate-900">{{ $sed->procedure_name }}</td>
                            <td class="py-2.5 px-3 text-[11px] text-slate-600">{{ $sed->sedation_type }}</td>
                            <td class="py-2.5 px-3 font-mono text-[11px]">
                                TD: {{ $sed->monitor_bp ?? '-' }} | SpO2: {{ $sed->monitor_spo2 ?? '-' }}%
                            </td>
                            <td class="py-2.5 px-3 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-mono font-bold
                                    {{ $sed->aldrete_score >= 9 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $sed->aldrete_score }} / 10
                                </span>
                            </td>
                            <td class="py-2.5 px-3 max-w-xs truncate text-[11px] text-slate-500">{{ $sed->evaluation ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-400">Belum ada catatan pemantauan sedasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100">
            {{ $sedations->links() }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function recalcAldrete() {
        const m = parseInt(document.getElementById('pMotor').value) || 0;
        const r = parseInt(document.getElementById('pResp').value) || 0;
        const b = parseInt(document.getElementById('pBp').value) || 0;
        const c = parseInt(document.getElementById('pConscious').value) || 0;
        const o = parseInt(document.getElementById('pColor').value) || 0;
        const total = m + r + b + c + o;

        document.getElementById('aldreteInput').value = total;
        const display = document.getElementById('scoreDisplay');
        display.innerText = total + ' / 10';
        if (total >= 9) {
            display.className = 'font-mono text-xl font-black text-emerald-600';
        } else {
            display.className = 'font-mono text-xl font-black text-amber-600';
        }
    }
</script>
@endpush

