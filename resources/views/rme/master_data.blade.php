@extends('rme.layout')

@section('title', 'Master Data Faskes & Poli')
@section('header_title', '20. Master Data Poli, Dokter & Sarana Prasarana')

@section('content')
<div class="space-y-6">

    <!-- Header Card Master Faskes -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-2xl p-6 shadow-md flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                <span class="text-xs uppercase font-bold text-emerald-400">Master Data FKTP TeFa V-Kes</span>
            </div>
            <h2 class="text-xl font-bold">Katalog Poli Pelayanan, Tenaga Medis & Jadwal Praktek</h2>
            <p class="text-xs text-slate-300 mt-1">
                Pengaturan master poli klinis, dokter penanggung jawab, serta alokasi ruangan fasilitas kesehatan.
            </p>
        </div>
    </div>

    <!-- Tabel Master Poli Pelayanan -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Daftar Poli & Unit Pelayanan Terintegrasi</h3>
                <p class="text-xs text-slate-500">Unit pelayanan rawat jalan dan penunjang medis aktif</p>
            </div>
            <span class="px-3 py-1 bg-primary-100 text-primary-800 text-xs font-bold rounded-full">
                {{ count($polis) }} Unit Pelayanan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-3 px-4">Kode Poli</th>
                        <th class="py-3 px-4">Nama Unit Layanan</th>
                        <th class="py-3 px-4">Dokter / Penanggung Jawab</th>
                        <th class="py-3 px-4">Status Layanan</th>
                        <th class="py-3 px-4 text-right">Aksi Layanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($polis as $pl)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-primary-700">{{ $pl['code'] }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900 text-sm">{{ $pl['name'] }}</td>
                            <td class="py-3 px-4 font-medium text-slate-700">{{ $pl['doctor'] }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-circle-check mr-1 text-[9px]"></i> {{ $pl['status'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('rme.antrian') }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-600 hover:text-white text-xs font-bold transition">
                                    <i class="fa-solid fa-bullhorn mr-1.5"></i> Buka Antrian Poli
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Informasi Profil Faskes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wide block">Identitas Faskes</span>
            <h4 class="text-sm font-bold text-slate-900">Klinik Pratama TeFa V-Kes Polije</h4>
            <p class="text-xs text-slate-600">Kode Faskes Kemenkes: <strong>10304928</strong></p>
            <p class="text-xs text-slate-600">Kode PCare BPJS: <strong>0192B001</strong></p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wide block">Alamat & Kontak</span>
            <p class="text-xs text-slate-700">Jl. Mastrip PO BOX 164, Jember, Jawa Timur</p>
            <p class="text-xs text-slate-600">Telepon: (0331) 333532</p>
            <p class="text-xs text-slate-600">Email: tefa-vkes@polije.ac.id</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wide block">Sertifikasi & Regulasi</span>
            <p class="text-xs text-emerald-700 font-bold"><i class="fa-solid fa-certificate"></i> Terakreditasi Paripurna</p>
            <p class="text-xs text-slate-600">Permenkes 24/2022 Rekam Medis Elektronik</p>
            <p class="text-xs text-slate-600">HL7 FHIR Interoperability Level 4</p>
        </div>
    </div>

</div>
@endsection

