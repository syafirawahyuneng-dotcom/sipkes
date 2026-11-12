@extends('rme.layout')

@section('title', 'Rawat Inap & Bed Management')
@section('header_title', '7. Rawat Inap, Monitoring Bed & CPPT')

@section('content')
<div class="space-y-6">

    <!-- Top Grid: Status Kamar / Tempat Tidur (Bed Monitoring Display) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-5">
            <div>
                <h3 class="text-base font-bold text-slate-800">Monitoring Okupansi Tempat Tidur (Bed Occupancy)</h3>
                <p class="text-xs text-slate-500">Visualisasi ketersediaan kamar rawat inap real-time Faskes</p>
            </div>
            
            <div class="flex items-center gap-3 text-xs font-semibold">
                <span class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Tersedia
                </span>
                <span class="inline-flex items-center gap-1.5 text-rose-700 bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-200">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Terisi Pasien
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($rooms as $room)
                <div class="p-4 rounded-xl border-2 transition relative {{ $room->status == 'tersedia' ? 'border-emerald-200 bg-emerald-50/20' : 'border-rose-200 bg-rose-50/20' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-800">{{ $room->room_name }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                            {{ $room->status == 'tersedia' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $room->status }}
                        </span>
                    </div>

                    <p class="text-[11px] text-slate-500 mb-2">Kelas: <strong>{{ $room->class_type }}</strong> • Rp {{ number_format($room->rate_per_day, 0, ',', '.') }}/hari</p>

                    @if($room->status == 'terisi' && $room->activeAdmission)
                        <div class="p-2.5 bg-white rounded-lg border border-rose-100 text-xs space-y-1">
                            <p class="font-bold text-slate-900 truncate">{{ $room->activeAdmission->patient ? $room->activeAdmission->patient->name : 'Pasien' }}</p>
                            <p class="text-[10px] text-slate-400 font-mono">RM: {{ $room->activeAdmission->patient ? $room->activeAdmission->patient->no_rm : '-' }}</p>
                            <p class="text-[10px] text-rose-700 font-medium truncate">Diag: {{ $room->activeAdmission->initial_diagnosis }}</p>
                            <p class="text-[9px] text-slate-400">Masuk: {{ \Carbon\Carbon::parse($room->activeAdmission->check_in)->format('d/m/Y H:i') }}</p>
                            
                            <form action="{{ route('rme.rawat.inap.checkout', $room->activeAdmission->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" onclick="return confirm('Pulangkan pasien dan kosongkan tempat tidur?')" 
                                        class="w-full py-1 bg-rose-600 hover:bg-rose-700 text-white text-[10px] font-bold rounded transition">
                                    <i class="fa-solid fa-door-open mr-1"></i> Pulangkan Pasien
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="p-3 bg-white/60 rounded-lg border border-dashed border-emerald-300 text-center text-xs text-emerald-700 font-medium">
                            <i class="fa-solid fa-bed text-emerald-500 text-base mb-1 block"></i>
                            Tempat Tidur Kosong
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Pendaftaran Masuk Rawat Inap & Catatan CPPT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Admisi Pasien Masuk Rawat Inap -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <h3 class="text-base font-bold text-slate-800 mb-1">Registrasi Pasien Masuk (Admisi)</h3>
            <p class="text-xs text-slate-500 mb-5">Tempatkan pasien yang membutuhkan observasi rawat inap</p>

            <form action="{{ route('rme.rawat.inap.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pasien <span class="text-rose-500">*</span></label>
                    <select name="patient_id" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                        <option value="">-- Pilih Pasien Terdaftar --</option>
                        @foreach($patients as $pt)
                            <option value="{{ $pt->id }}">{{ $pt->no_rm }} - {{ $pt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Kamar / Bed <span class="text-rose-500">*</span></label>
                    <select name="room_id" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                        <option value="">-- Pilih Kamar Tersedia --</option>
                        @foreach($rooms->where('status', 'tersedia') as $rm)
                            <option value="{{ $rm->id }}">{{ $rm->room_name }} ({{ $rm->class_type }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Diagnosa Masuk (Admisi) <span class="text-rose-500">*</span></label>
                    <input type="text" name="initial_diagnosis" required placeholder="Contoh: Febris H-3 suspek DHF / DBD"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan CPPT Awal Pasien</label>
                    <textarea name="cppt_notes" rows="3" placeholder="Keluhan utama lemas, trombosit rendah, infus RL 20 tpm, pantau tanda dehidrasi berkala..."
                              class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center justify-center gap-2">
                    <i class="fa-solid fa-bed"></i> Tempatkan Pasien di Kamar
                </button>
            </form>
        </div>

        <!-- Tabel Catatan Perkembangan Pasien Terintegrasi (CPPT) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <h3 class="text-base font-bold text-slate-800 mb-1">Riwayat Admisi & Catatan CPPT Rawat Inap</h3>
            <p class="text-xs text-slate-500 mb-4">Integrasi catatan medis dokter, perawat, dan tenaga klinis</p>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                            <th class="py-2.5 px-3">Waktu Masuk</th>
                            <th class="py-2.5 px-3">Pasien</th>
                            <th class="py-2.5 px-3">Kamar</th>
                            <th class="py-2.5 px-3">Diagnosa & CPPT</th>
                            <th class="py-2.5 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($admissions as $adm)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-2.5 px-3">
                                    <span class="font-bold text-slate-800 block">{{ \Carbon\Carbon::parse($adm->check_in)->format('d/m/Y') }}</span>
                                    <span class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($adm->check_in)->format('H:i') }} WIB</span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <span class="font-bold text-slate-800">{{ $adm->patient ? $adm->patient->name : '-' }}</span>
                                    <span class="font-mono text-[10px] text-primary-600 block">RM: {{ $adm->patient ? $adm->patient->no_rm : '-' }}</span>
                                </td>
                                <td class="py-2.5 px-3 font-semibold text-slate-800">{{ $adm->room ? $adm->room->room_name : '-' }}</td>
                                <td class="py-2.5 px-3 max-w-xs">
                                    <span class="font-semibold text-purple-700 block">{{ $adm->initial_diagnosis }}</span>
                                    <span class="text-[11px] text-slate-500 line-clamp-2">{{ $adm->cppt_notes ?? '-' }}</span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold
                                        {{ $adm->status == 'dirawat' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ ucfirst($adm->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">Belum ada riwayat rawat inap.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection

