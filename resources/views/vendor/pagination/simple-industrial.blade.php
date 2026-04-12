@if ($paginator->hasPages())
    <div class="flex items-center justify-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-6 py-4 bg-slate-50 text-slate-300 font-black text-[10px] uppercase tracking-widest cursor-not-allowed border border-slate-100 italic">
                {{ __('pagination.previous') }}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-6 py-4 bg-white text-slate-800 border border-slate-100 font-black text-[10px] uppercase tracking-widest hover:bg-[var(--primary)] hover:text-white transition-all">
                {{ __('pagination.previous') }}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-6 py-4 bg-white text-slate-800 border border-slate-100 font-black text-[10px] uppercase tracking-widest hover:bg-[var(--primary)] hover:text-white transition-all">
                {{ __('pagination.next') }}
            </a>
        @else
            <span class="px-6 py-4 bg-slate-50 text-slate-300 font-black text-[10px] uppercase tracking-widest cursor-not-allowed border border-slate-100 italic">
                {{ __('pagination.next') }}
            </span>
        @endif
    </div>
@endif
