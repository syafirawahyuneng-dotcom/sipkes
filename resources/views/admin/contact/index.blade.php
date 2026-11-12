@extends('admin.layout')

@section('title', 'Kontak & Pesan Masuk')
@section('page_title', 'Kelola Kontak & Formulir Pesan Faskes')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left: Contact Details Edit (Sesuai Proposal) -->
    <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm h-fit">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-slate-800">Informasi Kontak Resmi</h3>
            <p class="text-xs text-slate-500">Data telepon, email, instagram, dan alamat sekretariat TeFa V-Kes.</p>
        </div>

        <form action="{{ route('admin.contact.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">No. Telepon Resmi *</label>
                <input type="text" name="phone" required value="{{ old('phone', $contact->phone) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">WhatsApp (Format: 628xxx) *</label>
                <input type="text" name="whatsapp" required value="{{ old('whatsapp', $contact->whatsapp) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email *</label>
                <input type="email" name="email" required value="{{ old('email', $contact->email) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Username Instagram</label>
                <input type="text" name="instagram" value="{{ old('instagram', $contact->instagram) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">URL Instagram</label>
                <input type="text" name="instagram_url" value="{{ old('instagram_url', $contact->instagram_url) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Sekretariat Lengkap *</label>
                <textarea name="address" rows="3" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('address', $contact->address) }}</textarea>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                    Simpan Perubahan Kontak
                </button>
            </div>
        </form>
    </div>

    <!-- Right: Inbox Messages Table -->
    <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Daftar Pesan Masuk</h3>
                <p class="text-xs text-slate-500">Pesan dari pengunjung atau faskes yang berminat berlangganan.</p>
            </div>
            <span class="text-xs font-bold text-slate-500">{{ $messages->total() }} Pesan Masuk</span>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($messages as $msg)
            <div class="py-4 space-y-2">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-slate-900">{{ $msg->name }}</h4>
                            @if(!$msg->is_read)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700">Baru</span>
                            @endif
                        </div>
                        <p class="text-xs text-primary-600 font-semibold">{{ $msg->faskes_name ?? 'Faskes Mandiri' }} • {{ $msg->email }} • {{ $msg->phone }}</p>
                    </div>
                    <span class="text-[11px] text-slate-400 shrink-0">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl text-xs text-slate-700">
                    <p class="font-bold text-slate-800 mb-1">Subjek: {{ $msg->subject }}</p>
                    <p class="leading-relaxed">{{ $msg->message }}</p>
                </div>

                <div class="flex items-center justify-end gap-3 text-xs pt-1">
                    @if(!$msg->is_read)
                    <form action="{{ route('admin.messages.read', $msg) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sky-600 hover:underline font-bold">Tandai Sudah Dibaca</button>
                    </form>
                    @endif
                    <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline font-bold">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="py-12 text-center text-slate-400 text-xs">
                Belum ada pesan masuk.
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    </div>

</div>

@endsection

