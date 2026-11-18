{{-- Kartu artikel (daftar artikel, beranda, artikel terkait). Seluruh kartu dapat diklik. --}}
<a href="{{ $article->detail_url }}" class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition group flex flex-col focus:outline-none focus:ring-2 focus:ring-primary-500">
    <div class="aspect-[16/9] bg-slate-100 overflow-hidden relative flex items-center justify-center shrink-0">
        @if($article->hasValidCover())
            <img src="{{ $article->cover_url }}" alt="{{ $article->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center text-white">
                <i class="fa-solid fa-file-lines text-5xl text-white/40 group-hover:scale-110 transition duration-300"></i>
            </div>
        @endif

        @if($article->category)
        <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-black/60 text-white">
            {{ $article->category->name }}
        </span>
        @endif
    </div>

    <div class="p-6 flex flex-col flex-grow">
        <p class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] font-semibold text-primary-600 mb-2">
            @if($article->published_at)
            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $article->published_at->locale('id')->isoFormat('D MMMM Y') }}</span>
            @endif
            <span class="text-slate-400"><i class="fa-regular fa-clock mr-1"></i> {{ $article->reading_time }} menit baca</span>
        </p>
        <h3 class="font-bold text-slate-900 text-base leading-snug mb-2 line-clamp-2 group-hover:text-primary-700 transition">{{ $article->title }}</h3>
        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-5">{{ $article->excerpt_text }}</p>
        <span class="mt-auto inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 group-hover:text-primary-700">
            Baca Selengkapnya <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
        </span>
    </div>
</a>
