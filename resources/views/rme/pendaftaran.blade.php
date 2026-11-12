@extends('rme.layout')

@section('title', 'Pendaftaran Pasien & Cetak Antrian')
@section('header_title', '1. Pendaftaran Pasien Baru & Rawat Jalan')

@section('content')
<div class="space-y-6">

    <!-- Top Grid: Form Pendaftaran Pasien Baru & Cari Pasien -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Form Tambah Pasien Baru (2 Kolom) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Formulir Registrasi Pasien</h3>
                    <p class="text-xs text-slate-500">Nomor Rekam Medis Otomatis & Terkoneksi SATUSEHAT</p>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-slate-400 font-semibold block uppercase">Auto No. RM</span>
                    <span class="font-mono text-sm font-bold px-2.5 py-1 bg-primary-50 text-primary-700 rounded-lg border border-primary-200">
                        {{ $nextRm }}
                    </span>
                </div>
            </div>

            <form action="{{ route('rme.pendaftaran.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Lengkap Pasien -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pasien Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Budi Santoso"
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                    </div>

                    <!-- NIK (16 Digit KTP) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">NIK (KTP) Pasien</label>
                        <input type="text" name="nik" maxlength="16" placeholder="16 digit NIK Dukcapil"
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                    </div>

                    <!-- Nomor Kartu BPJS -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor BPJS / KIS (Opsional)</label>
                        <input type="text" name="bpjs_number" placeholder="13 digit No. BPJS Kesehatan"
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                    </div>

                    <!-- Jenis Kelamin & Gol Darah -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Gender <span class="text-rose-500">*</span></label>
                            <select name="gender" required class="w-full text-xs px-2.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                                <option value="L">Laki-Laki (L)</option>
                                <option value="P">Perempuan (P)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Gol. Darah</label>
                            <select name="blood_type" class="w-full text-xs px-2.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                                <option value="">-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="birth_date" required value="1995-01-01"
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                    </div>

                    <!-- No. HP / WhatsApp -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor HP / WhatsApp</label>
                        <input type="text" name="phone" placeholder="08123456789"
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                    </div>
                </div>

                <!-- Alamat Domisili -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Domisili Pasien</label>
                    <input type="text" name="address" placeholder="Jl. Mastrip Timur No. 12, Jember"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                </div>

                <!-- Riwayat Alergi & Tujuan Poli -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Riwayat Alergi Obat / Makanan</label>
                        <input type="text" name="allergy_history" placeholder="Contoh: Amoksisilin, Udang, dsb."
                               class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Langsung Ambil Antrian Poli</label>
                        <select name="poli" class="w-full text-xs px-3 py-2 border border-emerald-300 bg-emerald-50 text-emerald-900 font-semibold rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="">-- Hanya Daftarkan Pasien (Tanpa Antrian) --</option>
                            <option value="Poli Umum" selected>Poli Umum (Loket A)</option>
                            <option value="Poli Gigi">Poli Gigi & Mulut (Loket G)</option>
                            <option value="Poli KIA/KB">Poli KIA & KB (Loket K)</option>
                            <option value="UGD">Unit Gawat Darurat (UGD)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="reset" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-50 transition">
                        Reset
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-save"></i>
                        <span>Simpan Pasien & Buat Antrian</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Kolom Info Integrasi & Fitur Cepat -->
        <div class="space-y-4">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-white animate-pulse"></span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-100">Kemenkes SATUSEHAT</h4>
                </div>
                <h3 class="text-base font-extrabold leading-snug">Auto-Generate Patient IHS Number</h3>
                <p class="text-xs text-emerald-100 mt-1 leading-relaxed">
                    Setiap pasien yang disimpan akan secara instan memperoleh nomor IHS (Individual Health Identifier) Kemenkes secara otomatis.
                </p>
                <div class="mt-4 pt-3 border-t border-emerald-500/40 flex items-center justify-between text-xs">
                    <span>Validasi NIK Dukcapil:</span>
                    <span class="font-bold bg-white/20 px-2 py-0.5 rounded text-[11px]">Siap Sinkron</span>
                </div>
            </div>

            <!-- Kartu Petunjuk Alur -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 text-xs text-slate-600 space-y-3">
                <h4 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-primary-600"></i> Alur Layanan Rawat Jalan
                </h4>
                <ol class="space-y-2 list-decimal list-inside text-slate-600">
                    <li>Pasien didaftarkan di loket pendaftaran.</li>
                    <li>Sistem mencetak nomor antrian & kartu berobat.</li>
                    <li>Audio panggil pasien otomatis di layar antrian.</li>
                    <li>Dokter/Bidan melakukan pemeriksaan SO & AP.</li>
                    <li>Resep otomatis diproses di kasir & farmasi.</li>
                </ol>
            </div>
        </div>

    </div>

    <!-- Tabel Database Pasien Terdaftar -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Basis Data Pasien Terdaftar</h3>
                <p class="text-xs text-slate-500">Total Pasien: {{ $patients->total() }} jiwa terdata</p>
            </div>
            
            <!-- Pencarian Pasien -->
            <form action="{{ route('rme.pendaftaran') }}" method="GET" class="flex items-center gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, No. RM, NIK..."
                           class="text-xs pl-8 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
                </div>
                <button type="submit" class="px-3 py-2 bg-slate-800 text-white rounded-lg text-xs font-semibold hover:bg-slate-900 transition">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('rme.pendaftaran') }}" class="px-2.5 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs hover:bg-slate-200">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-[10px] tracking-wider">
                        <th class="py-3 px-3">No. RM</th>
                        <th class="py-3 px-3">Nama Pasien</th>
                        <th class="py-3 px-3">NIK / IHS SATUSEHAT</th>
                        <th class="py-3 px-3">L/P & Umur</th>
                        <th class="py-3 px-3">BPJS</th>
                        <th class="py-3 px-3">Alamat / HP</th>
                        <th class="py-3 px-3 text-right">Aksi Interaktif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($patients as $p)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-3 font-mono font-bold text-primary-600">
                                {{ $p->no_rm }}
                            </td>
                            <td class="py-3 px-3">
                                <span class="font-bold text-slate-800 block">{{ $p->name }}</span>
                                <span class="text-[10px] text-slate-400">Gol. {{ $p->blood_type ?? '-' }}</span>
                            </td>
                            <td class="py-3 px-3 font-mono text-[11px]">
                                <span class="block">{{ $p->nik ?? '-' }}</span>
                                <span class="text-[10px] text-emerald-600 font-semibold">{{ $p->satusehat_ihs ?? 'IHS Pending' }}</span>
                            </td>
                            <td class="py-3 px-3">
                                <span class="font-semibold">{{ $p->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ \Carbon\Carbon::parse($p->birth_date)->age }} th</span>
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $p->bpjs_status == 'Aktif' ? 'bg-sky-100 text-sky-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $p->bpjs_status }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <span class="truncate block max-w-xs">{{ $p->address ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400">{{ $p->phone ?? '-' }}</span>
                            </td>
                            <td class="py-3 px-3 text-right space-x-1">
                                <a href="{{ route('rme.kartu.berobat', ['patient_id' => $p->id]) }}" title="Cetak Kartu Berobat" 
                                   class="inline-flex items-center px-2 py-1 rounded bg-slate-100 hover:bg-cyan-100 hover:text-cyan-800 text-slate-600 text-[11px] font-medium transition">
                                    <i class="fa-solid fa-id-card mr-1"></i> Kartu
                                </a>
                                <a href="{{ route('rme.pemeriksaan.so', ['patient_id' => $p->id]) }}" title="Mulai Pemeriksaan SOAP" 
                                   class="inline-flex items-center px-2 py-1 rounded bg-primary-50 hover:bg-primary-600 hover:text-white text-primary-700 text-[11px] font-semibold transition">
                                    <i class="fa-solid fa-stethoscope mr-1"></i> Periksa SO
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada data pasien yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100">
            {{ $patients->links() }}
        </div>
    </div>

</div>
@endsection

