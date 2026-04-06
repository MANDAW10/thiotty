@props(['minimal' => false])

<div class="flex items-center gap-3 {{ $attributes->get('class') }}">
    <div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center shadow-lg shadow-secondary/20 shrink-0">
        <i class="fas fa-leaf text-white text-xl"></i>
    </div>
    @if(!$minimal)
        <div class="flex flex-col">
            <span class="text-xl font-black text-primary leading-none uppercase tracking-tighter">Thiotty</span>
            <span class="text-[10px] font-black text-slate-400 leading-none uppercase tracking-[0.3em] mt-1">Enterprise</span>
        </div>
    @endif
</div>
