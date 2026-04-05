@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'flex flex-col gap-1.5 mt-2']) }}>
        @foreach ((array) $messages as $message)
            <div class="flex items-center gap-2 text-[11px] font-bold text-rose-500 bg-rose-50 px-3 py-2 rounded-xl border border-rose-100/50 animate-in fade-in slide-in-from-top-1 duration-200">
                <i class="fas fa-exclamation-circle text-[10px]"></i>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    </div>
@endif
