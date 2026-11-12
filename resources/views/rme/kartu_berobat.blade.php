@extends('rme.layout')

@section('title', 'Cetak Kartu Berobat Pasien')
@section('header_title', '10. Cetak Kartu Berobat Pasien (ID Card Medis)')

@section('content')
<div class="space-y-6">

    <!-- Kontrol Pilih Pasien & Aksi Cetak -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 no-print">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Cetak Kartu Identitas Berobat Pasien</h3>
                <p class="text-xs text-slate-500">Format kartu standar ukuran ID Card (85.60 &times; 53.98 mm) siap cetak PVC</p>
            </div>

            <!-- Pilih Pasien Dropdown -->
            <form action="{{ route('rme.kartu.berobat') }}" method="GET" class="flex items-center gap-3">
                <select name="patient_id" onchange="this.form.submit()" class="text-xs px-3 py-2 border border-slate-300 rounded-lg outline-none bg-white font-medium">
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ ($selectedPatient && $selectedPatient->id == $p->id) ? 'selected' : '' }}>
                            {{ $p->no_rm }} - {{ $p->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center gap-2">
                    <i class="fa-solid fa-print"></i> Cetak Kartu Ini
                </button>
            </form>
        </div>
    </div>

    @if($selectedPatient)
        <!-- Preview Kartu Berobat (Front & Back) -->
        <div class="flex flex-col lg:flex-row items-center justify-center gap-8 py-6">
            
            <!-- KARTU TAMPAK DEPAN -->
            <div class="w-[360px] h-[225px] rounded-2xl bg-gradient-to-br from-primary-800 via-primary-700 to-indigo-900 text-white p-5 shadow-2xl relative overflow-hidden flex flex-col justify-between border border-primary-500/30">
                <!-- Watermark Background -->
                <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none text-white text-[150px]">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>

                <!-- Header Kartu -->
                <div class="flex items-center justify-between border-b border-white/20 pb-2 relative z-10">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-7 w-auto bg-white p-0.5 rounded object-contain">
                        <div>
                            <h4 class="text-xs font-extrabold tracking-wide uppercase leading-tight">SIP-KES TEFA POLIJE</h4>
                            <p class="text-[9px] text-emerald-300 font-medium">KARTU TANDA BEROBAT PASIEN</p>
                        </div>
                    </div>
                    <span class="text-[9px] bg-white/20 px-2 py-0.5 rounded font-mono font-semibold">SATUSEHAT</span>
                </div>

                <!-- Isi Data Pasien -->
                <div class="space-y-1 relative z-10 my-auto text-xs">
                    <div class="flex justify-between items-end">
                        <span class="text-[10px] text-primary-200">NO. REKAM MEDIS:</span>
                        <span class="font-mono text-base font-extrabold tracking-widest text-amber-300">{{ $selectedPatient->no_rm }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-primary-200 block">NAMA PASIEN:</span>
                        <span class="text-sm font-extrabold tracking-wide uppercase text-white">{{ $selectedPatient->name }}</span>
                    </div>
                    <div class="grid grid-cols-2 text-[10px] pt-1">
                        <div>
                            <span class="text-primary-200">Tgl. Lahir / JK:</span>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($selectedPatient->birth_date)->format('d/m/Y') }} ({{ $selectedPatient->gender }})</p>
                        </div>
                        <div>
                            <span class="text-primary-200">IHS SATUSEHAT:</span>
                            <p class="font-mono font-semibold text-emerald-300">{{ $selectedPatient->satusehat_ihs ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer Kartu: Barcode Grafis & Alamat -->
                <div class="relative z-10 pt-2 border-t border-white/20 flex items-center justify-between text-[8px] text-primary-200">
                    <div>
                        <span>Politeknik Negeri Jember</span> • <span>Jl. Mastrip PO BOX 164</span>
                    </div>
                    <!-- Barcode Grafis SVG Mockup -->
                    <div class="bg-white p-1 rounded flex items-center">
                        <svg class="h-4 w-28" viewBox="0 0 100 20" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0" y="0" width="2" height="20" fill="#000"/>
                            <rect x="4" y="0" width="1" height="20" fill="#000"/>
                            <rect x="7" y="0" width="3" height="20" fill="#000"/>
                            <rect x="12" y="0" width="1" height="20" fill="#000"/>
                            <rect x="15" y="0" width="4" height="20" fill="#000"/>
                            <rect x="21" y="0" width="2" height="20" fill="#000"/>
                            <rect x="25" y="0" width="1" height="20" fill="#000"/>
                            <rect x="28" y="0" width="3" height="20" fill="#000"/>
                            <rect x="33" y="0" width="2" height="20" fill="#000"/>
                            <rect x="37" y="0" width="1" height="20" fill="#000"/>
                            <rect x="40" y="0" width="3" height="20" fill="#000"/>
                            <rect x="45" y="0" width="2" height="20" fill="#000"/>
                            <rect x="50" y="0" width="4" height="20" fill="#000"/>
                            <rect x="56" y="0" width="1" height="20" fill="#000"/>
                            <rect x="60" y="0" width="2" height="20" fill="#000"/>
                            <rect x="64" y="0" width="3" height="20" fill="#000"/>
                            <rect x="70" y="0" width="1" height="20" fill="#000"/>
                            <rect x="73" y="0" width="2" height="20" fill="#000"/>
                            <rect x="77" y="0" width="4" height="20" fill="#000"/>
                            <rect x="83" y="0" width="1" height="20" fill="#000"/>
                            <rect x="86" y="0" width="3" height="20" fill="#000"/>
                            <rect x="91" y="0" width="2" height="20" fill="#000"/>
                            <rect x="95" y="0" width="3" height="20" fill="#000"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- KARTU TAMPAK BELAKANG (Ketentuan Pemakaian) -->
            <div class="w-[360px] h-[225px] rounded-2xl bg-slate-900 text-slate-300 p-5 shadow-2xl relative overflow-hidden flex flex-col justify-between border border-slate-700">
                <div class="border-b border-slate-700 pb-2">
                    <h5 class="text-xs font-bold text-white uppercase tracking-wider">KETENTUAN KARTU PASIEN</h5>
                    <p class="text-[9px] text-slate-400">Harap dibaca dan disimpan dengan baik</p>
                </div>

                <ol class="text-[9px] text-slate-300 space-y-1.5 list-decimal list-inside my-auto leading-relaxed">
                    <li>Kartu ini wajib dibawa setiap kali berobat ke klinik.</li>
                    <li>Kartu ini berlaku untuk seumur hidup dan tidak dapat dipindahtangankan.</li>
                    <li>Apabila kartu ini hilang atau rusak, segera hubungi loket pendaftaran.</li>
                    <li>Tersinkronisasi dengan profil pasien aplikasi SATUSEHAT Mobile Kemenkes RI.</li>
                </ol>

                <div class="pt-2 border-t border-slate-700 flex items-center justify-between text-[8px] text-slate-400">
                    <span>Emergency Call: 0331-333532</span>
                    <span class="font-mono text-emerald-400">VALID HL7 FHIR</span>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection

