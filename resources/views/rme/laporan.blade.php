@extends('rme.layout')

@section('title', 'Laporan Morbiditas ICD-10 & Statistik')
@section('header_title', '8. Laporan 10 Besar Penyakit & Statistik Eksekutif')

@section('content')
<div class="space-y-6">

    <!-- Print Header (Hanya Muncul saat Dicetak) -->
    <div class="hidden print-only mb-6 text-center border-b-2 border-black pb-4">
        <h2 class="text-xl font-bold uppercase">LAPORAN MORBIDITAS & STATISTIK PELAYANAN KLINIK</h2>
        <h3 class="text-sm font-semibold">KLINIK PRATAMA TEFA V-KES POLITEKNIK NEGERI JEMBER</h3>
        <p class="text-xs">Periode: {{ date('F Y') }} • Dicetak pada: {{ now()->translatedFormat('l, d F Y H:i') }} WIB</p>
    </div>

    <!-- Executive Overview Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 no-print">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Kunjungan Pasien</span>
            <p class="text-3xl font-extrabold text-primary-700 mt-2">{{ $totalVisits }}</p>
            <span class="text-xs text-slate-400 mt-1 block">Pasien terlayani di klinik</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pendapatan Kasir</span>
            <p class="text-3xl font-extrabold text-emerald-700 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <span class="text-xs text-emerald-600 mt-1 block font-medium"><i class="fa-solid fa-circle-check"></i> Transaksi terverifikasi</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Demografi Pasien</span>
                <div class="flex items-center gap-4 mt-2">
                    <div>
                        <span class="text-xs text-slate-400">Laki-Laki:</span>
                        <p class="text-lg font-bold text-blue-700">{{ $genderBreakdown['L'] ?? 0 }} jiwa</p>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400">Perempuan:</span>
                        <p class="text-lg font-bold text-pink-700">{{ $genderBreakdown['P'] ?? 0 }} jiwa</p>
                    </div>
                </div>
            </div>
            <button onclick="window.print()" class="mt-2 py-1.5 px-3 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Laporan Resmi
            </button>
        </div>
    </div>

    <!-- 10 Besar Morbiditas Penyakit (ICD-10) - Permenkes FKTP Standard -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">10 Besar Morbiditas Penyakit (ICD-10 FKTP)</h3>
                <p class="text-xs text-slate-500">Standar pelaporan epidemiologi Dinas Kesehatan dan Kemenkes RI</p>
            </div>
            <span class="text-xs bg-purple-100 text-purple-800 px-3 py-1 rounded-full font-bold">
                Katalog ICD-10
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-3 px-3 text-center w-12">No.</th>
                        <th class="py-3 px-3 w-28">Kode ICD-10</th>
                        <th class="py-3 px-3">Nama Diagnosis Penyakit</th>
                        <th class="py-3 px-3 text-center w-32">Jumlah Kasus</th>
                        <th class="py-3 px-3 text-right">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($topDiseases as $idx => $d)
                        @php
                            $percentage = $totalVisits > 0 ? round(($d->total / $totalVisits) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-3 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                            <td class="py-3 px-3 font-mono font-bold text-purple-700">{{ $d->diagnosis_code }}</td>
                            <td class="py-3 px-3 font-semibold text-slate-800">{{ $d->diagnosis_name }}</td>
                            <td class="py-3 px-3 text-center font-bold text-slate-900">{{ $d->total }} kasus</td>
                            <td class="py-3 px-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden no-print">
                                        <div class="bg-purple-600 h-full rounded-full" style="width: {{ min(100, $percentage * 3) }}%"></div>
                                    </div>
                                    <span class="font-mono font-bold text-xs">{{ $percentage }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">Belum ada diagnosis yang tercatat untuk laporan morbiditas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ringkasan Transaksi Finansial Terkini -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-4">Ringkasan Finansial Kasir Faskes</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-2.5 px-3">No. Invoice</th>
                        <th class="py-2.5 px-3">Pasien</th>
                        <th class="py-2.5 px-3">Status Bayar</th>
                        <th class="py-2.5 px-3">Metode</th>
                        <th class="py-2.5 px-3 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($recentInvoices as $rInv)
                        <tr>
                            <td class="py-2.5 px-3 font-mono font-bold text-primary-700">{{ $rInv->invoice_number }}</td>
                            <td class="py-2.5 px-3">{{ $rInv->patient ? $rInv->patient->name : '-' }}</td>
                            <td class="py-2.5 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold
                                    {{ $rInv->payment_status == 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $rInv->payment_status)) }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3">{{ $rInv->payment_method ?? 'Belum Dibayar' }}</td>
                            <td class="py-2.5 px-3 text-right font-mono font-bold text-slate-900">
                                Rp {{ number_format($rInv->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-400">Belum ada riwayat invoice.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

