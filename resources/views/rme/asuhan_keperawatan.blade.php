@extends('rme.layout')

@section('title', 'Asuhan Keperawatan (SDKI SIKI SLKI)')
@section('header_title', '12. Dokumentasi Asuhan Keperawatan (SDKI, SIKI, SLKI)')

@section('content')
<div class="space-y-6">

    <!-- Form Input Askep Standar PPNI (SDKI, SIKI, SLKI) -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-6">
            <div>
                <h3 class="text-base font-bold text-slate-800">Formulir Asuhan Keperawatan Terstandar (3S PPNI)</h3>
                <p class="text-xs text-slate-500">Standar Diagnosis (SDKI), Luaran (SLKI), dan Intervensi Keperawatan Indonesia (SIKI)</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">
                    <i class="fa-solid fa-user-nurse mr-1"></i> Standar PPNI 3S
                </span>
            </div>
        </div>

        <form action="{{ route('rme.asuhan.keperawatan.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Pasien <span class="text-rose-500">*</span></label>
                    <select name="patient_id" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($patients as $pt)
                            <option value="{{ $pt->id }}">{{ $pt->no_rm }} - {{ $pt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Perawat Penanggung Jawab (PPJA) <span class="text-rose-500">*</span></label>
                    <input type="text" name="nurse_name" required value="Ns. Rina Wulandari, S.Kep"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                </div>
            </div>

            <!-- 1. Pengkajian -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">1. Pengkajian Keperawatan <span class="text-rose-500">*</span></label>
                <textarea name="assessment" rows="2" required placeholder="Pasien mengeluh badan panas dingin sejak 2 hari, menggigil, kulit teraba hangat, TD 120/80, N 88, S 38.6°C..."
                          class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none"></textarea>
            </div>

            <!-- 3S: SDKI, SIKI, SLKI -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                <!-- SDKI -->
                <div class="p-4 rounded-xl border-2 border-rose-200 bg-rose-50/20 space-y-2">
                    <div class="flex items-center gap-1.5 text-rose-800 font-bold text-xs uppercase tracking-wide">
                        <span class="w-5 h-5 rounded bg-rose-600 text-white flex items-center justify-center text-[10px]">1</span>
                        <span>SDKI (Diagnosis)</span>
                    </div>
                    <textarea name="sdki_diagnosis" rows="4" required placeholder="D.0130 Hipertermia b.d proses penyakit infeksi d.d suhu tubuh 38.6°C, kulit kemerahan, takikardi..."
                              class="w-full text-xs p-2.5 border border-rose-300 rounded-lg outline-none bg-white font-medium"></textarea>
                </div>

                <!-- SIKI -->
                <div class="p-4 rounded-xl border-2 border-blue-200 bg-blue-50/20 space-y-2">
                    <div class="flex items-center gap-1.5 text-blue-800 font-bold text-xs uppercase tracking-wide">
                        <span class="w-5 h-5 rounded bg-blue-600 text-white flex items-center justify-center text-[10px]">2</span>
                        <span>SIKI (Intervensi)</span>
                    </div>
                    <textarea name="siki_intervention" rows="4" required placeholder="I.15506 Manajemen Hipertermia:&#10;- Monitor suhu tubuh berkala&#10;- Berikan kompres hangat&#10;- Kolaborasi pemberian antipiretik..."
                              class="w-full text-xs p-2.5 border border-blue-300 rounded-lg outline-none bg-white font-medium"></textarea>
                </div>

                <!-- SLKI -->
                <div class="p-4 rounded-xl border-2 border-emerald-200 bg-emerald-50/20 space-y-2">
                    <div class="flex items-center gap-1.5 text-emerald-800 font-bold text-xs uppercase tracking-wide">
                        <span class="w-5 h-5 rounded bg-emerald-600 text-white flex items-center justify-center text-[10px]">3</span>
                        <span>SLKI (Luaran & Evaluasi)</span>
                    </div>
                    <textarea name="slki_evaluation" rows="4" required placeholder="L.14134 Termoregulasi Membaik:&#10;- Suhu tubuh dalam rentang normal 36.5 - 37.2°C&#10;- Menggigil menurun&#10;- Pasien merasa nyaman..."
                              class="w-full text-xs p-2.5 border border-emerald-300 rounded-lg outline-none bg-white font-medium"></textarea>
                </div>

            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Catatan Asuhan Keperawatan
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Asuhan Keperawatan -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-4">Riwayat Dokumentasi Asuhan Keperawatan Pasien</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-2.5 px-3">Tanggal / RM</th>
                        <th class="py-2.5 px-3">Pasien</th>
                        <th class="py-2.5 px-3">Perawat (PPJA)</th>
                        <th class="py-2.5 px-3">SDKI Diagnosis</th>
                        <th class="py-2.5 px-3">SIKI Intervensi</th>
                        <th class="py-2.5 px-3">SLKI Luaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($askeps as $askep)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-2.5 px-3">
                                <span class="font-bold text-slate-800 block">{{ $askep->created_at->format('d/m/Y') }}</span>
                                <span class="font-mono text-[10px] text-primary-600">{{ $askep->patient ? $askep->patient->no_rm : '-' }}</span>
                            </td>
                            <td class="py-2.5 px-3 font-semibold">{{ $askep->patient ? $askep->patient->name : '-' }}</td>
                            <td class="py-2.5 px-3 text-slate-600">{{ $askep->nurse_name }}</td>
                            <td class="py-2.5 px-3 max-w-xs text-rose-700 font-medium truncate">{{ $askep->sdki_diagnosis }}</td>
                            <td class="py-2.5 px-3 max-w-xs text-blue-700 truncate">{{ $askep->siki_intervention }}</td>
                            <td class="py-2.5 px-3 max-w-xs text-emerald-700 truncate">{{ $askep->slki_evaluation }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada catatan asuhan keperawatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100">
            {{ $askeps->links() }}
        </div>
    </div>

</div>
@endsection

