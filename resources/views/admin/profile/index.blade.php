@extends('admin.layout')

@section('title', 'Kelola Profil')
@section('page_title', 'Kelola Konten Profil TeFa & SIP-Kes')

@section('content')

<div class="max-w-4xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Edit Profil & Informasi Institusi</h3>
        <p class="text-xs text-slate-500">Ubah narasi tentang Teaching Factory, visi, misi, dan latar belakang pengembangan SIP-Kes.</p>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Unit Inovasi *</label>
                <input type="text" name="name" required value="{{ old('name', $profile->name) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Institusi Naungan *</label>
                <input type="text" name="institution" required value="{{ old('institution', $profile->institution) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tagline Resmi</label>
            <input type="text" name="tagline" value="{{ old('tagline', $profile->tagline) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tentang Teaching Factory Inovasi Kesehatan (TeFa V-Kes) *</label>
            <textarea name="about_tefa" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('about_tefa', $profile->about_tefa) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tentang Aplikasi SIP-Kes *</label>
            <textarea name="about_sipkes" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('about_sipkes', $profile->about_sipkes) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Latar Belakang Pengembangan SIP-Kes *</label>
            <textarea name="background" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('background', $profile->background) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Visi TeFa V-Kes *</label>
                <textarea name="vision" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('vision', $profile->vision) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Misi TeFa V-Kes *</label>
                <textarea name="mission" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('mission', $profile->mission) }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow-md transition">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan Profil
            </button>
        </div>
    </form>
</div>

@endsection

