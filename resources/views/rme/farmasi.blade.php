@extends('rme.layout')

@section('title', 'Instalasi Farmasi & Resep Obat')
@section('header_title', '5. Instalasi Farmasi, Stok Obat & Resep Elektronik')

@section('content')
<div class="space-y-6">

    <!-- Antrian Resep Elektronik Masuk dari Dokter (AP) -->
    <div class="bg-gradient-to-r from-teal-800 to-emerald-900 text-white rounded-2xl p-6 shadow-md">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-teal-700 pb-3 mb-4">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-xl bg-teal-600 text-white flex items-center justify-center text-base">
                    <i class="fa-solid fa-receipt"></i>
                </span>
                <div>
                    <h3 class="text-base font-bold">Resep Masuk dari Dokter Poli</h3>
                    <p class="text-xs text-teal-200">Sinkronisasi otomatis saat dokter selesai menginput Plan (P)</p>
                </div>
            </div>
            <span class="text-xs bg-white/20 px-3 py-1 rounded-full font-semibold">
                {{ count($recentPrescriptions) }} Resep Terkini
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @forelse($recentPrescriptions as $rx)
                <div class="bg-teal-950/60 p-4 rounded-xl border border-teal-700/60 text-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between font-bold text-white mb-1">
                            <span>{{ $rx->patient ? $rx->patient->name : 'Pasien' }}</span>
                            <span class="font-mono text-teal-300">{{ $rx->patient ? $rx->patient->no_rm : '-' }}</span>
                        </div>
                        <p class="text-[11px] text-teal-300">{{ $rx->poli }} • {{ $rx->doctor_name }}</p>
                        <div class="mt-2.5 p-2 rounded bg-black/30 font-mono text-[11px] text-emerald-200 whitespace-pre-line border border-teal-800">
                            {{ $rx->prescription_notes }}
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-t border-teal-800/80 flex items-center justify-between">
                        <span class="text-[10px] text-teal-400">{{ $rx->visit_date }}</span>
                        <button onclick="printEtiket('{{ $rx->patient ? $rx->patient->name : 'Pasien' }}', '{{ $rx->prescription_notes }}')" 
                                class="px-2.5 py-1 bg-teal-500 hover:bg-teal-400 text-slate-900 rounded font-bold text-[11px] transition flex items-center gap-1 shadow">
                            <i class="fa-solid fa-print"></i> Cetak Etiket
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-4 text-teal-200 text-xs">Belum ada resep masuk.</div>
            @endforelse
        </div>
    </div>

    <!-- Modul Inventori Obat: Form Tambah & Tabel Stok -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Tambah Obat Baru -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <h3 class="text-base font-bold text-slate-800 mb-1">Tambah Data Obat</h3>
            <p class="text-xs text-slate-500 mb-5">Input obat baru ke katalog inventori farmasi</p>

            <form action="{{ route('rme.farmasi.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Obat <span class="text-rose-500">*</span></label>
                    <input type="text" name="code" required placeholder="OBT-009"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Obat & Dosis <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Amoxicillin 500 mg"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                        <select name="category" class="w-full text-xs px-2.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                            <option value="Tablet">Tablet</option>
                            <option value="Sirup">Sirup</option>
                            <option value="Kapsul">Kapsul</option>
                            <option value="Salep">Salep</option>
                            <option value="Injeksi">Injeksi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Satuan</label>
                        <input type="text" name="unit" required placeholder="Strip / Botol" value="Strip"
                               class="w-full text-xs px-2.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Stok Awal</label>
                        <input type="number" name="stock" required min="0" value="100"
                               class="w-full text-xs px-2.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Min. Stok</label>
                        <input type="number" name="min_stock" value="15"
                               class="w-full text-xs px-2.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Harga Satuan (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" required min="0" value="12000"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Kedaluwarsa</label>
                    <input type="date" name="expired_date" value="2027-12-31"
                           class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                </div>

                <button type="submit" class="w-full mt-2 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i> Tambah ke Inventori
                </button>
            </form>
        </div>

        <!-- Tabel Inventori Obat & Pengeluaran Stok (2 Kolom) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Inventori & Pengeluaran Obat</h3>
                    <p class="text-xs text-slate-500">Kelola kuantitas fisik dan penyerahan obat ke pasien</p>
                </div>
                
                <form action="{{ route('rme.farmasi') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode obat..."
                           class="text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none w-52">
                    <button type="submit" class="px-3 py-2 bg-slate-800 text-white rounded-lg text-xs font-semibold hover:bg-slate-900 transition">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('rme.farmasi') }}" class="px-2.5 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs">Reset</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                            <th class="py-2.5 px-3">Kode</th>
                            <th class="py-2.5 px-3">Nama Obat</th>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Sisa Stok</th>
                            <th class="py-2.5 px-3">Harga</th>
                            <th class="py-2.5 px-3 text-right">Keluar Stok (Dispense)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($medicines as $m)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-2.5 px-3 font-mono font-bold text-teal-700">{{ $m->code }}</td>
                                <td class="py-2.5 px-3 font-semibold text-slate-800">{{ $m->name }}</td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-700 font-medium">{{ $m->category }}</span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <span class="font-mono font-bold {{ $m->stock <= $m->min_stock ? 'text-rose-600' : 'text-emerald-700' }}">
                                        {{ $m->stock }} {{ $m->unit }}
                                    </span>
                                    @if($m->stock <= $m->min_stock)
                                        <span class="text-[9px] text-rose-500 block font-semibold">Stok Menipis</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 font-mono">Rp {{ number_format($m->price, 0, ',', '.') }}</td>
                                <td class="py-2.5 px-3 text-right">
                                    <form action="{{ route('rme.farmasi.dispense', $m->id) }}" method="POST" class="inline-flex items-center gap-1">
                                        @csrf
                                        <input type="number" name="qty" min="1" max="{{ $m->stock }}" value="1" 
                                               class="w-12 text-center text-xs py-1 border border-slate-300 rounded font-mono">
                                        <button type="submit" class="px-2.5 py-1 bg-teal-600 hover:bg-teal-700 text-white rounded text-[11px] font-semibold transition" title="Keluarkan obat">
                                            Keluarkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-slate-400">Tidak ada data obat di inventori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                {{ $medicines->links() }}
            </div>
        </div>

    </div>

</div>

<!-- Modal Etiket Obat Siap Cetak -->
<div id="etiketModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b pb-2">
            <h4 class="text-sm font-bold text-slate-800">Preview Etiket Obat Pasien</h4>
            <button onclick="document.getElementById('etiketModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <!-- Box Etiket Format Standar Apotek -->
        <div class="border-2 border-blue-600 rounded-xl p-4 bg-blue-50/20 text-center space-y-2 font-mono text-xs" id="etiketPrintArea">
            <div class="border-b border-blue-400 pb-2">
                <h5 class="font-bold text-blue-900 text-sm">INSTALASI FARMASI TEFA POLIJE</h5>
                <p class="text-[10px] text-slate-600">Jl. Mastrip PO BOX 164 Jember • Telp. (0331) 333532</p>
            </div>
            <div class="text-left text-[11px] space-y-1">
                <p><strong>Nama:</strong> <span id="lblEtiketPatient">-</span></p>
                <p><strong>Tgl:</strong> {{ date('d/m/Y') }}</p>
                <div class="my-2 p-2 bg-white rounded border border-blue-200">
                    <p class="font-bold text-slate-900" id="lblEtiketNotes">-</p>
                </div>
                <p class="text-[10px] italic text-center text-slate-500">Semoga Lekas Sembuh</p>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <button onclick="document.getElementById('etiketModal').classList.add('hidden')" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">Tutup</button>
            <button onclick="window.print()" class="px-4 py-1.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-xs font-bold flex items-center gap-1.5">
                <i class="fa-solid fa-print"></i> Cetak Etiket
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function printEtiket(patient, notes) {
        document.getElementById('lblEtiketPatient').innerText = patient;
        document.getElementById('lblEtiketNotes').innerText = notes;
        document.getElementById('etiketModal').classList.remove('hidden');
    }
</script>
@endpush

