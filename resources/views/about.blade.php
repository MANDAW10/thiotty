<x-app-layout>
    <header class="py-16 bg-slate-900 text-white border-b-8 border-[var(--primary)]">
        <div class="container-custom text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight mb-4">{{ __('messages.about_title') }}</h1>
            <p class="text-white/70 font-medium leading-relaxed">{{ __('messages.about_lead') }}</p>
        </div>
    </header>

    <div class="py-20 bg-white">
        <div class="container-custom max-w-3xl mx-auto prose prose-slate">
            <p class="text-slate-600 leading-relaxed text-lg mb-6">
                {{ __('messages.hero_text') }}
            </p>
            <p class="text-slate-600 leading-relaxed">
                {{ __('messages.quality_text') }}
            </p>
            <div class="mt-12 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('shop.index') }}" class="px-8 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-slate-900 transition-colors">
                    {{ __('messages.shop') }}
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 border-2 border-slate-200 text-slate-800 font-black text-[11px] uppercase tracking-widest hover:border-[var(--primary)] transition-colors">
                    {{ __('messages.contact') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
