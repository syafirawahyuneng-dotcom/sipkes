@extends('rme.layout')

@section('title', 'Odontogram Gigi Interaktif (Poli Gigi)')
@section('header_title', '14. Odontogram Digital Interaktif Klinik Gigi')

@section('content')
<div class="space-y-6">

    <!-- Pilih Pasien & Header Poli Gigi -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Peta Odontogram Gigi Pasien (32 Gigi Dewasa FDI)</h3>
                <p class="text-xs text-slate-500">Standar notasi FDI (Fédération Dentaire Internationale) untuk rekam gigi klinik</p>
            </div>

            <!-- Pilih Pasien Dropdown -->
            <form action="{{ route('rme.odontogram') }}" method="GET" class="flex items-center gap-2">
                <select name="patient_id" onchange="this.form.submit()" class="text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-medium">
                    @foreach($patients as $pt)
                        <option value="{{ $pt->id }}" {{ ($patient && $patient->id == $pt->id) ? 'selected' : '' }}>
                            {{ $pt->no_rm }} - {{ $pt->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($patient)
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                <div>
                    Pasien Terpilih: <strong class="text-slate-900">{{ $patient->name }}</strong> (No. RM: {{ $patient->no_rm }})
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Tersimpan di Rekam Medis</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Peta Visual Odontogram 32 Gigi Interaktif -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
        
        <!-- Legend Kondisi Gigi -->
        <div class="flex flex-wrap items-center gap-3 text-xs bg-slate-50 p-3 rounded-xl border border-slate-200">
            <span class="font-bold text-slate-700 text-[11px] uppercase tracking-wide">Keterangan Status:</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded bg-white border border-slate-400"></span> Normal/Sehat</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded bg-rose-500"></span> Caries (Lubang)</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded bg-blue-500"></span> Tambalan (Filling)</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded bg-slate-900 text-white font-bold text-[9px] flex items-center justify-center">X</span> Missing (Hilang)</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded bg-amber-400"></span> Crown (Mahkota)</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded bg-orange-600"></span> Radix (Sisa Akar)</span>
        </div>

        <!-- Arch Gigi Atas (Maxilla) -->
        <div class="space-y-2">
            <div class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase px-1">
                <span>Rahang Atas Kanan (Q1)</span>
                <span class="text-slate-400">GARIS TENGAH (MIDLINE)</span>
                <span>Rahang Atas Kiri (Q2)</span>
            </div>

            <!-- 16 Gigi Atas -->
            <div class="grid grid-cols-16 gap-1 sm:gap-2">
                @php
                    $upperTeeth = ['18','17','16','15','14','13','12','11','21','22','23','24','25','26','27','28'];
                @endphp
                @foreach($upperTeeth as $t)
                    @php
                        $cond = $odontograms[$t] ?? 'Sehat';
                        $colorClass = match($cond) {
                            'Caries' => 'bg-rose-500 text-white border-rose-600',
                            'Filling' => 'bg-blue-500 text-white border-blue-600',
                            'Missing' => 'bg-slate-900 text-white border-slate-950 font-bold',
                            'Crown' => 'bg-amber-400 text-slate-900 border-amber-500',
                            'Radix' => 'bg-orange-600 text-white border-orange-700',
                            default => 'bg-slate-50 hover:bg-slate-100 text-slate-800 border-slate-300',
                        };
                    @endphp
                    <button type="button" 
                            onclick="selectTooth('{{ $t }}', '{{ $cond }}')"
                            class="aspect-square flex flex-col items-center justify-center p-1 rounded-lg border-2 transition shadow-sm hover:scale-105 {{ $colorClass }}">
                        <span class="text-[10px] sm:text-xs font-bold font-mono">{{ $t }}</span>
                        <i class="fa-solid fa-tooth text-[10px] sm:text-xs mt-0.5"></i>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Garis Pemisah Oklusal -->
        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-dashed border-slate-300"></span></div>
            <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-3 text-slate-400 font-semibold text-[10px]">Bidang Oklusal</span></div>
        </div>

        <!-- Arch Gigi Bawah (Mandibula) -->
        <div class="space-y-2">
            <!-- 16 Gigi Bawah -->
            <div class="grid grid-cols-16 gap-1 sm:gap-2">
                @php
                    $lowerTeeth = ['48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38'];
                @endphp
                @foreach($lowerTeeth as $t)
                    @php
                        $cond = $odontograms[$t] ?? 'Sehat';
                        $colorClass = match($cond) {
                            'Caries' => 'bg-rose-500 text-white border-rose-600',
                            'Filling' => 'bg-blue-500 text-white border-blue-600',
                            'Missing' => 'bg-slate-900 text-white border-slate-950 font-bold',
                            'Crown' => 'bg-amber-400 text-slate-900 border-amber-500',
                            'Radix' => 'bg-orange-600 text-white border-orange-700',
                            default => 'bg-slate-50 hover:bg-slate-100 text-slate-800 border-slate-300',
                        };
                    @endphp
                    <button type="button" 
                            onclick="selectTooth('{{ $t }}', '{{ $cond }}')"
                            class="aspect-square flex flex-col items-center justify-center p-1 rounded-lg border-2 transition shadow-sm hover:scale-105 {{ $colorClass }}">
                        <i class="fa-solid fa-tooth text-[10px] sm:text-xs mb-0.5"></i>
                        <span class="text-[10px] sm:text-xs font-bold font-mono">{{ $t }}</span>
                    </button>
                @endforeach
            </div>

            <div class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase px-1">
                <span>Rahang Bawah Kanan (Q4)</span>
                <span class="text-slate-400">GARIS TENGAH (MIDLINE)</span>
                <span>Rahang Bawah Kiri (Q3)</span>
            </div>
        </div>

    </div>

    <!-- Modal Form Update Kondisi Gigi -->
    <div id="toothModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b pb-2">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-pink-100 text-pink-700 flex items-center justify-center text-xs font-bold">
                        <i class="fa-solid fa-tooth"></i>
                    </span>
                    <h4 class="text-sm font-bold text-slate-800">Update Gigi <span id="lblToothNum" class="font-mono text-pink-600 font-black">--</span></h4>
                </div>
                <button onclick="document.getElementById('toothModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('rme.odontogram.save') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient ? $patient->id : 1 }}">
                <input type="hidden" name="tooth_number" id="inputToothNum">

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status / Kondisi Gigi <span class="text-rose-500">*</span></label>
                    <select name="condition" id="selectToothCondition" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-medium">
                        <option value="Sehat">Sehat / Normal (Tanpa Kelainan)</option>
                        <option value="Caries">Caries / Gigi Berlubang</option>
                        <option value="Filling">Filling / Tumpatan Komposit / Tambalan</option>
                        <option value="Missing">Missing / Gigi Hilang / Sudah Dicabut</option>
                        <option value="Crown">Crown / Mahkota Tiruan</option>
                        <option value="Radix">Radix / Sisa Akar Gigi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tindakan Dokter Gigi</label>
                    <textarea name="notes" rows="2" placeholder="Contoh: Karies profunda oklusal, rencana tumpatan resin komposit..."
                              class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('toothModal').classList.add('hidden')" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-1.5 bg-pink-600 hover:bg-pink-700 text-white rounded-lg text-xs font-bold shadow">
                        Simpan Kondisi Gigi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function selectTooth(num, currentCond) {
        document.getElementById('lblToothNum').innerText = num;
        document.getElementById('inputToothNum').value = num;
        document.getElementById('selectToothCondition').value = currentCond;
        document.getElementById('toothModal').classList.remove('hidden');
    }
</script>
@endpush

