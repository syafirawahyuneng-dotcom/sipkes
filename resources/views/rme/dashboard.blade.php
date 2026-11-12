@extends('rme.layout')

@section('title', 'Dashboard Operasional Faskes')
@section('header_title', '9. Dashboard Eksekutif & Operasional Klinik')

@section('content')
<div class="space-y-6">

    <!-- Hero Banner Klinik -->
    <div class="bg-gradient-to-r from-primary-800 via-primary-700 to-indigo-800 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-emerald-300 backdrop-blur-sm border border-white/20 mb-3">
                <i class="fa-solid fa-hospital text-emerald-400"></i> Faskes Tingkat Pertama (FKTP) Siap Layanan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Pusat Kendali Rekam Medis Elektronik (RME)</h2>
            <p class="text-primary-100 text-sm mt-2 leading-relaxed">
                Platform operasional klinis terpadu 20 modul TeFa V-Kes Polije. Terintegrasi penuh dengan standar HL7 FHIR SATUSEHAT Kemenkes RI dan BPJS Kesehatan PCare.
            </p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('rme.pendaftaran') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition shadow-md">
                    <i class="fa-solid fa-user-plus"></i> Daftar Pasien Baru
                </a>
                <a href="{{ route('rme.antrian') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25 text-white rounded-xl text-xs font-semibold backdrop-blur-sm border border-white/20 transition">
                    <i class="fa-solid fa-bullhorn text-amber-300"></i> Layar Antrian & Suara
                </a>
                <a href="{{ route('rme.diagnosa.tindakan') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25 text-white rounded-xl text-xs font-semibold backdrop-blur-sm border border-white/20 transition">
                    <i class="fa-solid fa-stethoscope text-sky-300"></i> Input Diagnosa (AP)
                </a>
            </div>
        </div>
        <div class="absolute -right-8 -bottom-8 opacity-10 pointer-events-none text-white text-[220px]">
            <i class="fa-solid fa-heart-pulse"></i>
        </div>
    </div>

    <!-- 6 Metric Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Pasien Terdaftar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Total Pasien</span>
                <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-users"></i>
                </span>
            </div>
            <p class="text-2xl font-bold text-slate-800 mt-2">{{ number_format($stats['total_patients']) }}</p>
            <span class="text-[11px] text-emerald-600 font-medium flex items-center gap-1 mt-1">
                <i class="fa-solid fa-database text-[9px]"></i> Rekam Aktif
            </span>
        </div>

        <!-- Antrian Hari Ini -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Antrian Hari Ini</span>
                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-ticket"></i>
                </span>
            </div>
            <p class="text-2xl font-bold text-slate-800 mt-2">{{ $stats['today_queues'] }}</p>
            <span class="text-[11px] text-amber-600 font-medium flex items-center gap-1 mt-1">
                <i class="fa-solid fa-clock text-[9px]"></i> Rawat Jalan
            </span>
        </div>

        <!-- Pemeriksaan Klinis -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Pemeriksaan SO</span>
                <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-stethoscope"></i>
                </span>
            </div>
            <p class="text-2xl font-bold text-slate-800 mt-2">{{ $stats['total_examinations'] }}</p>
            <span class="text-[11px] text-purple-600 font-medium flex items-center gap-1 mt-1">
                <i class="fa-solid fa-notes-medical text-[9px]"></i> Rekam SOAP
            </span>
        </div>

        <!-- Rawat Inap Aktif -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Rawat Inap</span>
                <span class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-bed"></i>
                </span>
            </div>
            <p class="text-2xl font-bold text-slate-800 mt-2">{{ $stats['active_admissions'] }}</p>
            <span class="text-[11px] text-sky-600 font-medium flex items-center gap-1 mt-1">
                <i class="fa-solid fa-bed-pulse text-[9px]"></i> Pasien Dirawat
            </span>
        </div>

        <!-- Obat Menipis -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Stok Obat Kritis</span>
                <span class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-pills"></i>
                </span>
            </div>
            <p class="text-2xl font-bold {{ $stats['low_stock_medicines'] > 0 ? 'text-rose-600' : 'text-slate-800' }} mt-2">
                {{ $stats['low_stock_medicines'] }}
            </p>
            <span class="text-[11px] {{ $stats['low_stock_medicines'] > 0 ? 'text-rose-600' : 'text-slate-400' }} font-medium flex items-center gap-1 mt-1">
                <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Batas Minimal
            </span>
        </div>

        <!-- Billing Hari Ini -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Kasir Lunas</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-rupiah-sign"></i>
                </span>
            </div>
            <p class="text-base font-bold text-slate-800 mt-2 truncate">
                Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}
            </p>
            <span class="text-[11px] text-emerald-600 font-medium flex items-center gap-1 mt-1">
                <i class="fa-solid fa-circle-check text-[9px]"></i> Penerimaan
            </span>
        </div>
    </div>

    <!-- Quick Shortcuts to All 20 Modules -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Navigasi Langsung 20 Fitur RME</h3>
                <p class="text-xs text-slate-500">Semua modul proposal beroperasi secara interaktif</p>
            </div>
            <span class="text-xs bg-primary-50 text-primary-700 px-2.5 py-1 rounded-full font-bold">20 Modul Aktif</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3">
            <a href="{{ route('rme.pendaftaran') }}" class="p-3 rounded-xl border border-slate-200 hover:border-primary-500 hover:bg-primary-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">1</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-primary-700 truncate">Pendaftaran</p>
                    <p class="text-[10px] text-slate-400">Registrasi RM</p>
                </div>
            </a>
            <a href="{{ route('rme.antrian') }}" class="p-3 rounded-xl border border-slate-200 hover:border-amber-500 hover:bg-amber-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">2</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-amber-700 truncate">Antrian & Suara</p>
                    <p class="text-[10px] text-slate-400">Panggilan TTS</p>
                </div>
            </a>
            <a href="{{ route('rme.pemeriksaan.so') }}" class="p-3 rounded-xl border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">3</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-emerald-700 truncate">Pemeriksaan SO</p>
                    <p class="text-[10px] text-slate-400">Subjektif & Objektif</p>
                </div>
            </a>
            <a href="{{ route('rme.diagnosa.tindakan') }}" class="p-3 rounded-xl border border-slate-200 hover:border-purple-500 hover:bg-purple-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">4</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-purple-700 truncate">Diagnosa & Tindakan</p>
                    <p class="text-[10px] text-slate-400">ICD-10 / AP</p>
                </div>
            </a>
            <a href="{{ route('rme.farmasi') }}" class="p-3 rounded-xl border border-slate-200 hover:border-teal-500 hover:bg-teal-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">5</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-teal-700 truncate">Farmasi</p>
                    <p class="text-[10px] text-slate-400">Resep & Obat</p>
                </div>
            </a>
            <a href="{{ route('rme.kasir') }}" class="p-3 rounded-xl border border-slate-200 hover:border-amber-500 hover:bg-amber-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">6</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-amber-800 truncate">Kasir & Billing</p>
                    <p class="text-[10px] text-slate-400">Kwitansi Lunas</p>
                </div>
            </a>
            <a href="{{ route('rme.rawat.inap') }}" class="p-3 rounded-xl border border-slate-200 hover:border-sky-500 hover:bg-sky-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">7</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-sky-700 truncate">Rawat Inap</p>
                    <p class="text-[10px] text-slate-400">Bed & CPPT</p>
                </div>
            </a>
            <a href="{{ route('rme.laporan') }}" class="p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">8</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-indigo-700 truncate">Laporan Morbiditas</p>
                    <p class="text-[10px] text-slate-400">Top 10 ICD-10</p>
                </div>
            </a>
            <a href="{{ route('rme.kartu.berobat') }}" class="p-3 rounded-xl border border-slate-200 hover:border-cyan-500 hover:bg-cyan-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">10</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-cyan-700 truncate">Kartu Berobat</p>
                    <p class="text-[10px] text-slate-400">QR Code Cetak</p>
                </div>
            </a>
            <a href="{{ route('rme.verifikasi.satusehat') }}" class="p-3 rounded-xl border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">11</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-emerald-700 truncate">SatuSehat Mobile</p>
                    <p class="text-[10px] text-slate-400">IHS Pasien</p>
                </div>
            </a>
            <a href="{{ route('rme.asuhan.keperawatan') }}" class="p-3 rounded-xl border border-slate-200 hover:border-rose-500 hover:bg-rose-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">12</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-rose-700 truncate">Askep Keperawatan</p>
                    <p class="text-[10px] text-slate-400">SDKI/SIKI/SLKI</p>
                </div>
            </a>
            <a href="{{ route('rme.pengaturan.integrasi') }}" class="p-3 rounded-xl border border-slate-200 hover:border-slate-500 hover:bg-slate-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">13</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-slate-700 truncate">Integrasi BPJS</p>
                    <p class="text-[10px] text-slate-400">PCare & SatuSehat</p>
                </div>
            </a>
            <a href="{{ route('rme.odontogram') }}" class="p-3 rounded-xl border border-slate-200 hover:border-pink-500 hover:bg-pink-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">14</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-pink-700 truncate">Odontogram Gigi</p>
                    <p class="text-[10px] text-slate-400">32 Gigi Interaktif</p>
                </div>
            </a>
            <a href="{{ route('rme.general.consent') }}" class="p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">15</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-indigo-700 truncate">General Consent</p>
                    <p class="text-[10px] text-slate-400">Tanda Tangan TTD</p>
                </div>
            </a>
            <a href="{{ route('rme.informed.consent') }}" class="p-3 rounded-xl border border-slate-200 hover:border-blue-500 hover:bg-blue-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">16</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-blue-700 truncate">Informed Consent</p>
                    <p class="text-[10px] text-slate-400">Persetujuan Medis</p>
                </div>
            </a>
            <a href="{{ route('rme.surat.keterangan') }}" class="p-3 rounded-xl border border-slate-200 hover:border-yellow-500 hover:bg-yellow-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-700 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">17</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-yellow-800 truncate">Surat Sakit & Sehat</p>
                    <p class="text-[10px] text-slate-400">Cetak Surat Dokter</p>
                </div>
            </a>
            <a href="{{ route('rme.laboratorium') }}" class="p-3 rounded-xl border border-slate-200 hover:border-teal-500 hover:bg-teal-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">18</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-teal-700 truncate">Laboratorium</p>
                    <p class="text-[10px] text-slate-400">Parameter & Nilai</p>
                </div>
            </a>
            <a href="{{ route('rme.sedasi') }}" class="p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">19</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-indigo-700 truncate">Sedasi & Anestesi</p>
                    <p class="text-[10px] text-slate-400">Skor Aldrete</p>
                </div>
            </a>
            <a href="{{ route('rme.master.data') }}" class="p-3 rounded-xl border border-slate-200 hover:border-slate-500 hover:bg-slate-50/50 transition flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs font-bold group-hover:scale-110 transition">20</div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-slate-700 truncate">Dan Lain-lain</p>
                    <p class="text-[10px] text-slate-400">Master & Poli</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Active Queues & Recent Patients Dual Column -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Live Antrian Aktif -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500 animate-ping"></span>
                        <h3 class="text-base font-bold text-slate-800">Antrian Hari Ini</h3>
                    </div>
                    <a href="{{ route('rme.antrian') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-800">
                        Buka Display Suara &rarr;
                    </a>
                </div>

                <div class="space-y-2.5">
                    @forelse($activeQueues as $q)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 rounded-lg bg-primary-100 text-primary-800 font-mono font-bold text-xs">
                                    {{ $q->queue_number }}
                                </span>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">{{ $q->patient ? $q->patient->name : 'Pasien Reguler' }}</p>
                                    <p class="text-[11px] text-slate-500">{{ $q->poli }} • No. RM: {{ $q->patient ? $q->patient->no_rm : '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold 
                                    {{ $q->status == 'dipanggil' ? 'bg-amber-100 text-amber-800 border border-amber-300' : ($q->status == 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700') }}">
                                    {{ ucfirst($q->status) }}
                                </span>
                                @if($q->status == 'menunggu' || $q->status == 'dipanggil')
                                    <form action="{{ route('rme.antrian.call', $q->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" title="Panggil Suara" class="w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white flex items-center justify-center text-xs transition">
                                            <i class="fa-solid fa-volume-high"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">Belum ada antrian terdaftar hari ini.</div>
                    @endforelse
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('rme.antrian') }}" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition">
                    <i class="fa-solid fa-desktop"></i> Layar Antrian Lengkap & Panggilan Suara
                </a>
            </div>
        </div>

        <!-- Pasien Baru Terdaftar -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-slate-800">Pasien Baru Terdaftar</h3>
                    <a href="{{ route('rme.pendaftaran') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-800">
                        Kelola Pasien &rarr;
                    </a>
                </div>

                <div class="space-y-2.5">
                    @forelse($recentPatients as $p)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($p->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">{{ $p->name }}</p>
                                    <p class="text-[11px] text-slate-500">RM: {{ $p->no_rm }} • NIK: {{ $p->nik ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $p->bpjs_status == 'Aktif' ? 'bg-sky-100 text-sky-800' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $p->bpjs_status }}
                                </span>
                                <a href="{{ route('rme.kartu.berobat', ['patient_id' => $p->id]) }}" title="Cetak Kartu" class="w-7 h-7 rounded-lg bg-slate-200 hover:bg-primary-600 hover:text-white text-slate-700 flex items-center justify-center text-xs transition">
                                    <i class="fa-solid fa-id-card"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">Belum ada pasien terdaftar.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('rme.pendaftaran') }}" class="w-full py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition">
                    <i class="fa-solid fa-user-plus"></i> Tambah Pasien Baru
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

