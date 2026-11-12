@extends('layouts.frontend')

@section('title', 'Kontak & Informasi Sekretariat SIP-Kes')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Kontak Resmi</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Hubungi Kami</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Informasi kontak sekretariat TeFa Inovasi Kesehatan Politeknik Negeri Jember dan formulir penawaran kemitraan faskes.
        </p>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Info Details (Sesuai Proposal) -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 mb-2">Sekretariat TeFa V-Kes</h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Silakan hubungi kami untuk koordinasi presentasi, uji coba sistem demo, verifikasi akun faskes, atau pendampingan bridging SATUSEHAT.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0 text-xl">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold uppercase">Nomor Telepon / WhatsApp</p>
                            <p class="text-sm font-bold text-slate-800">{{ $contact->phone ?? '0813-3551-2803' }}</p>
                            <a href="https://wa.me/6281335512803?text=Halo%20Admin%20SIP-Kes" target="_blank" class="text-xs text-primary-600 font-bold hover:underline mt-1 inline-block">Kirim Pesan WhatsApp &rarr;</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0 text-xl">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold uppercase">Email Resmi</p>
                            <p class="text-sm font-bold text-slate-800">{{ $contact->email ?? 'vkes@polije.ac.id' }}</p>
                            <a href="mailto:vkes@polije.ac.id" class="text-xs text-primary-600 font-bold hover:underline mt-1 inline-block">Kirim Email Surat Resmi &rarr;</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0 text-xl">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold uppercase">Instagram Resmi</p>
                            <p class="text-sm font-bold text-slate-800">{{ $contact->instagram ?? '@sipkes.co.id' }}</p>
                            <a href="{{ $contact->instagram_url ?? 'https://instagram.com/sipkes.co.id' }}" target="_blank" class="text-xs text-primary-600 font-bold hover:underline mt-1 inline-block">Kunjungi Profil Instagram &rarr;</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0 text-xl">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold uppercase">Alamat Lengkap</p>
                            <p class="text-xs sm:text-sm font-medium text-slate-700 leading-relaxed">{{ $contact->address ?? 'Jurusan Kesehatan, Program Studi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jalan Mastrip 164, Jember.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-sm h-52">
                    <iframe src="https://maps.google.com/maps?q=Politeknik+Negeri+Jember&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <!-- Right Message Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-sm">
                    <h3 class="text-2xl font-black text-slate-900 mb-2">Kirim Pertanyaan / Formulir Minat</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mb-8">Isi formulir di bawah ini, tim kami akan merespons langsung kebutuhan faskes Anda.</p>

                    @if(session('success'))
                    <div class="p-4 mb-6 rounded-2xl bg-green-50 border border-green-200 text-green-800 text-xs sm:text-sm flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Pemohon *</label>
                                <input type="text" name="name" required class="w-full text-xs sm:text-sm px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="dr. / Bpk / Ibu...">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email *</label>
                                <input type="email" name="email" required class="w-full text-xs sm:text-sm px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="nama@faskes.id">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">No. HP / WhatsApp *</label>
                                <input type="text" name="phone" class="w-full text-xs sm:text-sm px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="08xxxxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Fasilitas Kesehatan</label>
                                <input type="text" name="faskes_name" class="w-full text-xs sm:text-sm px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Klinik Pratama Sejahtera">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Subjek Keperluan *</label>
                            <input type="text" name="subject" required class="w-full text-xs sm:text-sm px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Permintaan Demo Sistem / Pertanyaan Paket Langganan">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Isi Pesan Detail *</label>
                            <textarea name="message" rows="5" required class="w-full text-xs sm:text-sm px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Sampaikan kebutuhan faskes Anda, jumlah poli, atau kendala integrasi SATUSEHAT yang sedang dihadapi..."></textarea>
                        </div>

                        <button type="submit" class="w-full py-4 px-6 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-sm shadow-md shadow-primary-600/30 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection

