@extends('rme.layout')

@section('title', 'Antrian & Panggilan Suara (Audio Display)')
@section('header_title', '2. Antrian & Panggilan Suara Otomatis (TTS)')

@section('content')
<div class="space-y-6">

    <!-- Big Screen Antrian Display (Mirip TV Layar Ruang Tunggu Faskes) -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-2xl border border-slate-700/60 relative overflow-hidden">
        
        <!-- Top Display Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-700/60 pb-5">
            <div class="flex items-center gap-3">
                <span class="w-3.5 h-3.5 rounded-full bg-emerald-400 animate-ping"></span>
                <div>
                    <h2 class="text-xl font-extrabold tracking-wide text-white uppercase">Layar Antrian Multimedia</h2>
                    <p class="text-xs text-slate-300">Panggilan Audio Berbasis Web Speech API Sintesis Suara Bahasa Indonesia</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Test Voice Button -->
                <button onclick="playChimeAndSpeak('A-001', 'Poli Umum', 'Budi Santoso')" class="px-3.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold rounded-xl text-xs flex items-center gap-2 transition shadow">
                    <i class="fa-solid fa-volume-high"></i> Uji Audio Bel & Suara
                </button>
                <div class="px-3 py-1 bg-slate-800/80 rounded-lg border border-slate-700 font-mono text-xs text-slate-300" id="liveClock">
                    {{ now()->translatedFormat('l, d F Y - H:i:s') }}
                </div>
            </div>
        </div>

        <!-- Center Stage: Nomor yang Sedang Dipanggil -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-6 items-center">
            
            <!-- Big Box Current Calling -->
            <div class="lg:col-span-2 bg-slate-950/70 border border-slate-700/80 rounded-2xl p-6 sm:p-8 text-center relative overflow-hidden shadow-inner">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs font-bold uppercase mb-3">
                    <i class="fa-solid fa-bullhorn animate-bounce"></i> Panggilan Aktif
                </div>
                
                <div id="displayQueueNumber" class="text-6xl sm:text-7xl lg:text-8xl font-black font-mono tracking-wider text-amber-400 drop-shadow-md">
                    {{ $currentlyCalling ? $currentlyCalling->queue_number : 'A-001' }}
                </div>
                
                <div class="mt-3">
                    <h3 id="displayPoli" class="text-xl sm:text-2xl font-bold text-white tracking-wide">
                        {{ $currentlyCalling ? $currentlyCalling->poli : 'Poli Umum' }}
                    </h3>
                    <p id="displayPatientName" class="text-sm text-slate-300 mt-1 font-medium">
                        {{ $currentlyCalling && $currentlyCalling->patient ? $currentlyCalling->patient->name : 'Budi Santoso' }}
                    </p>
                </div>

                <div class="mt-6 flex justify-center gap-3">
                    @if($currentlyCalling)
                        <form action="{{ route('rme.antrian.call', $currentlyCalling->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs flex items-center gap-2 transition shadow-lg">
                                <i class="fa-solid fa-redo"></i> Panggil Ulang Audio
                            </button>
                        </form>
                        <form action="{{ route('rme.antrian.complete', $currentlyCalling->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs flex items-center gap-2 transition shadow-lg">
                                <i class="fa-solid fa-check"></i> Selesai Dilayani
                            </button>
                        </form>
                    @else
                        <button onclick="playChimeAndSpeak('A-001', 'Poli Umum', 'Budi Santoso')" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs flex items-center gap-2 transition shadow-lg">
                            <i class="fa-solid fa-volume-high"></i> Bunyikan Panggilan Contoh
                        </button>
                    @endif
                </div>
            </div>

            <!-- Loket-loket Poli Side Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-1 gap-3">
                @foreach($poliStats as $pName => $stat)
                    <div class="bg-slate-800/80 p-4 rounded-xl border border-slate-700/80 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">{{ $pName }}</span>
                            <span class="text-xl font-mono font-bold text-emerald-400">{{ $stat['current'] }}</span>
                            <span class="text-[10px] text-slate-400 block truncate max-w-[130px]">{{ $stat['patient_name'] }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] uppercase text-slate-500 font-semibold block">Menunggu</span>
                            <span class="px-2 py-0.5 rounded-full bg-slate-700 text-white font-mono text-xs font-bold">{{ $stat['waiting_count'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    <!-- Management Controls: Ambil Tiket Baru & Daftar Antrian Pasien -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Ambil Tiket Antrian Baru -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <h3 class="text-base font-bold text-slate-800 mb-1">Ambil Tiket Antrian Baru</h3>
            <p class="text-xs text-slate-500 mb-4">Cetak tiket antrian loket / poli klinik</p>

            <form action="{{ route('rme.antrian.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tujuan Poli / Loket <span class="text-rose-500">*</span></label>
                    <select name="poli" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                        <option value="Poli Umum">Poli Umum (Awalan A-)</option>
                        <option value="Poli Gigi">Poli Gigi & Mulut (Awalan G-)</option>
                        <option value="Poli KIA/KB">Poli KIA & KB (Awalan K-)</option>
                        <option value="UGD">Unit Gawat Darurat (Awalan U-)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pasien Terdaftar (Opsional)</label>
                    <select name="patient_id" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                        <option value="">-- Pasien Umum (Non-Registrasi) --</option>
                        @foreach($patients as $pt)
                            <option value="{{ $pt->id }}">{{ $pt->no_rm }} - {{ $pt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-xs font-bold transition shadow flex items-center justify-center gap-2">
                    <i class="fa-solid fa-print"></i> Cetak Nomor Antrian
                </button>
            </form>
        </div>

        <!-- Tabel Antrian Hari Ini (2 Kolom) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Daftar Antrian Hari Ini</h3>
                    <p class="text-xs text-slate-500">Panggilan suara real-time & kontrol antrian</p>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-full font-mono">
                    Total: {{ count($queues) }} Tiket
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                            <th class="py-2.5 px-3">No. Tiket</th>
                            <th class="py-2.5 px-3">Poli / Loket</th>
                            <th class="py-2.5 px-3">Pasien</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-3 text-right">Aksi Panggilan Suara</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($queues as $q)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-2.5 px-3 font-mono font-bold text-sm text-primary-700">
                                    {{ $q->queue_number }}
                                </td>
                                <td class="py-2.5 px-3 font-medium">{{ $q->poli }}</td>
                                <td class="py-2.5 px-3">
                                    <span class="font-bold text-slate-800 block">{{ $q->patient ? $q->patient->name : 'Pasien Reguler' }}</span>
                                    <span class="text-[10px] text-slate-400">RM: {{ $q->patient ? $q->patient->no_rm : '-' }}</span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold
                                        {{ $q->status == 'dipanggil' ? 'bg-amber-100 text-amber-800 border border-amber-300' : ($q->status == 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600') }}">
                                        {{ ucfirst($q->status) }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-right space-x-1">
                                    <!-- Direct Browser TTS Voice Trigger -->
                                    <button type="button" 
                                            onclick="playChimeAndSpeak('{{ $q->queue_number }}', '{{ $q->poli }}', '{{ $q->patient ? $q->patient->name : 'Pasien' }}')"
                                            class="inline-flex items-center px-2 py-1 rounded bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold shadow-sm transition"
                                            title="Panggil Suara Langsung">
                                        <i class="fa-solid fa-volume-high mr-1"></i> Suara
                                    </button>

                                    <!-- Server Call Post -->
                                    <form action="{{ route('rme.antrian.call', $q->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium transition" title="Update status dipanggil">
                                            <i class="fa-solid fa-bullhorn mr-1"></i> Panggil
                                        </button>
                                    </form>

                                    <!-- Selesai -->
                                    @if($q->status != 'selesai')
                                        <form action="{{ route('rme.antrian.complete', $q->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-2 py-1 rounded bg-emerald-50 hover:bg-emerald-600 hover:text-white text-emerald-700 text-[11px] font-semibold transition" title="Tandai selesai">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">Belum ada antrian tercatat hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    // Live Clock Update
    setInterval(() => {
        const d = new Date();
        const el = document.getElementById('liveClock');
        if (el) {
            el.innerText = d.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' - ' + d.toLocaleTimeString('id-ID');
        }
    }, 1000);

    // Audio Bell Chime via Web Audio API
    function playDingDong(callback) {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const now = ctx.currentTime;
            
            // Ding
            const osc1 = ctx.createOscillator();
            const gain1 = ctx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(587.33, now); // D5
            gain1.gain.setValueAtTime(0.3, now);
            gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.6);
            osc1.connect(gain1);
            gain1.connect(ctx.destination);
            osc1.start(now);
            osc1.stop(now + 0.6);

            // Dong
            const osc2 = ctx.createOscillator();
            const gain2 = ctx.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(440.00, now + 0.35); // A4
            gain2.gain.setValueAtTime(0.35, now + 0.35);
            gain2.gain.exponentialRampToValueAtTime(0.001, now + 1.2);
            osc2.connect(gain2);
            gain2.connect(ctx.destination);
            osc2.start(now + 0.35);
            osc2.stop(now + 1.2);

            setTimeout(callback, 900);
        } catch(e) {
            if (callback) callback();
        }
    }

    // Play Chime and Speak with Indonesian SpeechSynthesis
    function playChimeAndSpeak(queueNum, poliName, patientName) {
        // Update display board
        document.getElementById('displayQueueNumber').innerText = queueNum;
        document.getElementById('displayPoli').innerText = poliName;
        document.getElementById('displayPatientName').innerText = patientName;

        playDingDong(() => {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const speechText = `Nomor antrian, ${queueNum}. Atas nama ${patientName}. Silakan menuju ke ${poliName}.`;
                const utterance = new SpeechSynthesisUtterance(speechText);
                utterance.lang = 'id-ID';
                utterance.rate = 0.92;
                utterance.pitch = 1.0;
                window.speechSynthesis.speak(utterance);
            }
        });
    }
</script>
@endpush

