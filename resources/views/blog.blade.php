<x-app-layout>
    <header class="py-16 bg-[var(--light-bg)] border-b border-slate-100">
        <div class="container-custom text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 uppercase tracking-tight mb-4">{{ __('messages.blog_title') }}</h1>
            <p class="text-slate-500 font-medium">{{ __('messages.blog_lead') }}</p>
        </div>
    </header>

    <div class="py-20 bg-white">
        <div class="container-custom grid md:grid-cols-3 gap-8">
            @foreach([
                ['t' => 'Relance de l\'aviculture', 'd' => 'Perspectives et bonnes pratiques pour les éleveurs sénégalais.', 'img' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=800&auto=format&fit=crop'],
                ['t' => 'Produits locaux & e-commerce', 'd' => 'Comment la digitalisation soutient la filière et les producteurs.', 'img' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=800&auto=format&fit=crop'],
                ['t' => 'Qualité et traçabilité', 'd' => 'Nos engagements pour une chaîne courte et transparente.', 'img' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800&auto=format&fit=crop'],
            ] as $post)
                <article class="border border-slate-100 bg-white hover:shadow-lg transition-shadow group">
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ $post['img'] }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <h2 class="text-lg font-black uppercase tracking-tight text-slate-900 mb-2">{{ $post['t'] }}</h2>
                        <p class="text-sm text-slate-500 leading-relaxed mb-4">{{ $post['d'] }}</p>
                        <span class="text-[10px] font-black uppercase tracking-widest text-[var(--primary)]">{{ __('messages.newest') }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-app-layout>
