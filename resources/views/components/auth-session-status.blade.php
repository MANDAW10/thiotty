@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-4 bg-emerald-50 text-emerald-700 border border-emerald-100 p-4 rounded-2xl animate-in fade-in slide-in-from-top-2 duration-500']) }}>
        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shrink-0 shadow-sm shadow-emerald-200/50">
            <i class="fas fa-check text-sm text-emerald-500"></i>
        </div>
        <div class="flex-1">
            <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50 mb-0.5">Succès</p>
            <p class="text-xs font-bold">{{ $status }}</p>
        </div>
    </div>
@endif
