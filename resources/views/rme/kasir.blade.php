@extends('rme.layout')

@section('title', 'Kasir & Billing Pembayaran')
@section('header_title', '6. Kasir, Tagihan Billing & Cetak Kwitansi')

@section('content')
<div class="space-y-6">

    <!-- Tagihan Menunggu Pembayaran (Unpaid Invoices) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-base">
                    <i class="fa-solid fa-cash-register"></i>
                </span>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Tagihan Menunggu Pembayaran (Belum Lunas)</h3>
                    <p class="text-xs text-slate-500">Billing otomatis yang terbit dari hasil diagnosa dan tindakan dokter</p>
                </div>
            </div>
            <span class="text-xs font-bold px-3 py-1 bg-amber-100 text-amber-800 rounded-full border border-amber-200">
                {{ count($unpaidInvoices) }} Tagihan Antri
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($unpaidInvoices as $inv)
                <div class="p-5 rounded-2xl border-2 border-amber-200 bg-amber-50/30 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="font-mono font-bold text-xs text-amber-800">{{ $inv->invoice_number }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-200 text-amber-900">Belum Bayar</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 mt-2">{{ $inv->patient ? $inv->patient->name : 'Pasien' }}</h4>
                        <p class="text-xs text-slate-500 font-mono">RM: {{ $inv->patient ? $inv->patient->no_rm : '-' }}</p>

                        <!-- Breakdown Rincian -->
                        <div class="mt-3 p-3 bg-white rounded-xl border border-slate-200 text-xs space-y-1 text-slate-600">
                            <div class="flex justify-between">
                                <span>Administrasi:</span>
                                <span class="font-mono">Rp {{ number_format($inv->admin_fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jasa Dokter:</span>
                                <span class="font-mono">Rp {{ number_format($inv->doctor_fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tindakan Medis:</span>
                                <span class="font-mono">Rp {{ number_format($inv->action_fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Resep Obat Farmasi:</span>
                                <span class="font-mono">Rp {{ number_format($inv->medicine_fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="pt-2 border-t border-slate-200 flex justify-between font-bold text-slate-900 text-sm">
                                <span>Total Tagihan:</span>
                                <span class="font-mono text-emerald-700">Rp {{ number_format($inv->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pembayaran Kasir -->
                    <form action="{{ route('rme.kasir.pay', $inv->id) }}" method="POST" class="space-y-2 pt-2 border-t border-amber-200">
                        @csrf
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Metode Bayar</label>
                                <select name="payment_method" class="w-full text-xs px-2 py-1.5 border border-slate-300 rounded-lg outline-none bg-white">
                                    <option value="Tunai">Tunai / Cash</option>
                                    <option value="QRIS">QRIS Dinamis</option>
                                    <option value="BPJS Kesehatan">Klaim BPJS</option>
                                    <option value="Transfer Bank">Transfer Bank</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Uang Diterima</label>
                                <input type="number" name="paid_amount" required min="{{ $inv->total_amount }}" value="{{ $inv->total_amount }}"
                                       class="w-full text-xs px-2 py-1.5 border border-slate-300 rounded-lg outline-none font-mono font-bold bg-white">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-circle-check"></i> Proses Pembayaran Lunas
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-slate-400 text-xs">
                    Semua tagihan telah lunas. Tidak ada tagihan tertunda!
                </div>
            @endforelse
        </div>
    </div>

    <!-- Riwayat Pembayaran & Cetak Nota Kasir -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-4">Riwayat Transaksi Kasir Lunas & Cetak Kwitansi</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                        <th class="py-2.5 px-3">No. Invoice</th>
                        <th class="py-2.5 px-3">Pasien</th>
                        <th class="py-2.5 px-3">Waktu Bayar</th>
                        <th class="py-2.5 px-3">Total Biaya</th>
                        <th class="py-2.5 px-3">Metode</th>
                        <th class="py-2.5 px-3 text-right">Cetak Kwitansi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($paidInvoices as $pInv)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-2.5 px-3 font-mono font-bold text-primary-700">{{ $pInv->invoice_number }}</td>
                            <td class="py-2.5 px-3">
                                <span class="font-bold text-slate-800">{{ $pInv->patient ? $pInv->patient->name : 'Pasien' }}</span>
                                <span class="text-[10px] text-slate-400 block font-mono">RM: {{ $pInv->patient ? $pInv->patient->no_rm : '-' }}</span>
                            </td>
                            <td class="py-2.5 px-3 text-slate-600">{{ $pInv->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="py-2.5 px-3 font-mono font-bold text-emerald-700">
                                Rp {{ number_format($pInv->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                    {{ $pInv->payment_method ?? 'Tunai' }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-right">
                                <button type="button" 
                                        onclick="showReceiptModal('{{ $pInv->invoice_number }}', '{{ $pInv->patient ? $pInv->patient->name : 'Pasien' }}', '{{ $pInv->patient ? $pInv->patient->no_rm : '-' }}', '{{ $pInv->total_amount }}', '{{ $pInv->payment_method }}', '{{ $pInv->admin_fee }}', '{{ $pInv->doctor_fee }}', '{{ $pInv->action_fee }}', '{{ $pInv->medicine_fee }}')"
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-primary-600 hover:text-white text-slate-700 text-[11px] font-semibold transition">
                                    <i class="fa-solid fa-print mr-1"></i> Cetak Nota
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada transaksi lunas tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Kwitansi Kasir Format Resmi TeFa V-Kes -->
<div id="receiptModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b pb-2">
            <h4 class="text-sm font-bold text-slate-800">Kwitansi Pembayaran Resmi</h4>
            <button onclick="document.getElementById('receiptModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="border border-slate-300 p-5 rounded-xl font-mono text-xs space-y-3 bg-white" id="receiptPrintArea">
            <div class="text-center border-b border-dashed border-slate-400 pb-3">
                <h5 class="font-bold text-sm text-slate-900">KLINIK PRATAMA TEFA V-KES POLIJE</h5>
                <p class="text-[10px] text-slate-500">Jl. Mastrip PO BOX 164 Jember • Telp. 0331-333532</p>
                <span class="text-[9px] bg-slate-100 px-2 py-0.5 rounded mt-1 inline-block text-slate-600">BUKTI PEMBAYARAN KASIR</span>
            </div>

            <div class="text-[11px] space-y-1">
                <div class="flex justify-between"><span>No. Bukti:</span><strong id="rcptInv">-</strong></div>
                <div class="flex justify-between"><span>Pasien:</span><strong id="rcptPatient">-</strong></div>
                <div class="flex justify-between"><span>No. RM:</span><span id="rcptRm">-</span></div>
                <div class="flex justify-between"><span>Metode:</span><span id="rcptMethod">-</span></div>
            </div>

            <div class="border-t border-b border-dashed border-slate-400 py-2 space-y-1 text-[11px]">
                <div class="flex justify-between"><span>Biaya Pendaftaran & Admin</span><span id="rcptAdmin">Rp 0</span></div>
                <div class="flex justify-between"><span>Jasa Medis Dokter</span><span id="rcptDoc">Rp 0</span></div>
                <div class="flex justify-between"><span>Tindakan & Prosedur Medis</span><span id="rcptAct">Rp 0</span></div>
                <div class="flex justify-between"><span>Obat-Obatan & Farmasi</span><span id="rcptMed">Rp 0</span></div>
            </div>

            <div class="flex justify-between font-bold text-slate-900 text-sm">
                <span>TOTAL LUNAS:</span>
                <span id="rcptTotal" class="text-emerald-700">Rp 0</span>
            </div>

            <div class="text-center text-[10px] text-slate-400 pt-2 border-t border-dashed border-slate-300">
                Terima kasih atas kunjungan Anda.<br>Semoga lekas sembuh!
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <button onclick="document.getElementById('receiptModal').classList.add('hidden')" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">Tutup</button>
            <button onclick="window.print()" class="px-4 py-1.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-xs font-bold flex items-center gap-1.5">
                <i class="fa-solid fa-print"></i> Cetak Kwitansi
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showReceiptModal(inv, patient, rm, total, method, admin, doc, act, med) {
        document.getElementById('rcptInv').innerText = inv;
        document.getElementById('rcptPatient').innerText = patient;
        document.getElementById('rcptRm').innerText = rm;
        document.getElementById('rcptMethod').innerText = method;
        document.getElementById('rcptAdmin').innerText = 'Rp ' + Number(admin).toLocaleString('id-ID');
        document.getElementById('rcptDoc').innerText = 'Rp ' + Number(doc).toLocaleString('id-ID');
        document.getElementById('rcptAct').innerText = 'Rp ' + Number(act).toLocaleString('id-ID');
        document.getElementById('rcptMed').innerText = 'Rp ' + Number(med).toLocaleString('id-ID');
        document.getElementById('rcptTotal').innerText = 'Rp ' + Number(total).toLocaleString('id-ID');
        document.getElementById('receiptModal').classList.remove('hidden');
    }
</script>
@endpush

