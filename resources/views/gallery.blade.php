<x-app-layout>
    <div x-data="{ 
        isOpen: false, 
        currentImg: '', 
        currentTitle: '', 
        currentDesc: '',
        openLightbox(img, title, desc) {
            this.currentImg = img;
            this.currentTitle = title;
            this.currentDesc = desc;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeLightbox() {
            this.isOpen = false;
            document.body.style.overflow = 'auto';
        }
    }">
        <!-- Gallery Hero -->
        <header class="py-16 lg:py-24 bg-white border-b border-slate-50 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl opacity-50"></div>
            <div class="container-custom relative z-10 text-center">
                <nav class="flex justify-center mb-8 text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Accueil</a>
                    <span class="opacity-20">/</span>
                    <span class="text-slate-900">Galerie</span>
                </nav>
                <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-tight mb-6 tracking-tighter">
                    Notre <span class="text-primary italic italic-font">Vision</span>.
                </h1>
                <p class="text-slate-500 font-medium max-w-2xl mx-auto text-lg leading-relaxed">
                    Immersion au cœur de l'excellence agricole. Découvrez nos produits, nos élevages et l'engagement quotidien de Thiotty Enterprise.
                </p>
            </div>
        </header>

        <!-- Gallery Grid -->
        <section class="py-20 lg:py-32 bg-[#FDFDFD]">
            <div class="container-custom">
                <!-- Filter Tabs -->
                <div class="flex flex-wrap justify-center gap-4 mb-20">
                    <button class="px-8 py-3 rounded-2xl bg-primary text-white font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 transition-transform active:scale-95">Tout</button>
                    <button class="px-8 py-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-primary hover:border-primary/20 font-black text-xs uppercase tracking-widest transition-all">Élevage</button>
                    <button class="px-8 py-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-primary hover:border-primary/20 font-black text-xs uppercase tracking-widest transition-all">Terroir</button>
                    <button class="px-8 py-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-primary hover:border-primary/20 font-black text-xs uppercase tracking-widest transition-all">Culture</button>
                </div>

                <div class="columns-1 sm:columns-2 lg:columns-3 gap-8 space-y-8">
                    @forelse($items as $item)
                        <!-- Dynamic Image -->
                        <div @click="openLightbox('{{ $item->image_url }}', '{{ $item->title }}', '{{ $item->description }}')" 
                             class="fade-in group relative overflow-hidden rounded-[40px] bg-slate-100 shadow-sm hover:shadow-2xl transition-all duration-700 cursor-zoom-in" 
                             style="animation-delay: {{ $loop->index * 0.1 }}s">
                            
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full transition-transform duration-[2000ms] group-hover:scale-110">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-10 text-left">
                                <span class="text-[9px] font-black text-primary uppercase tracking-widest mb-3 leading-none">{{ $item->category }}</span>
                                <h4 class="text-white text-2xl font-black mb-2 leading-tight tracking-tighter">{{ $item->title }}</h4>
                                @if($item->description)
                                    <p class="text-white/60 text-sm font-medium line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                                @endif
                                
                                <div class="mt-6 flex items-center gap-2 text-[8px] font-black text-white uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all translate-y-4 group-hover:translate-y-0 delay-100">
                                    <i class="fas fa-expand-alt text-primary"></i> Voir en grand
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Placeholder if empty -->
                        <div class="col-span-full py-32 text-center bg-slate-50 rounded-[48px] border-2 border-dashed border-slate-200">
                            <i class="fas fa-camera-retro text-4xl text-slate-200 mb-6"></i>
                            <p class="text-slate-400 font-black uppercase tracking-widest text-[10px] mb-8">L'album est en cours de préparation...</p>
                            
                            <a href="{{ url('/seed-gallery-hd') }}" class="inline-flex items-center gap-4 bg-white border border-slate-200 px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-primary hover:border-primary transition-all shadow-sm">
                                <i class="fas fa-magic text-primary"></i> Activer la Galerie HD
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Call to Action -->
                <div class="mt-40 text-center fade-in bg-slate-900 rounded-[64px] p-16 md:p-24 relative overflow-hidden shadow-2xl shadow-primary/20" style="animation-delay: 0.6s">
                    <div class="relative z-10">
                        <h3 class="text-3xl md:text-5xl font-black text-white mb-10 tracking-tighter leading-tight">Inspiré par l'excellence <span class="text-primary italic">Thiotty</span> ?</h3>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-6 bg-primary text-white px-12 py-6 rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-white hover:text-primary transition-all shadow-xl shadow-primary/20 active:scale-95 group">
                            Découvrir nos produits <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
                        </a>
                    </div>
                    <!-- Background shapes -->
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-secondary/10 rounded-full blur-3xl"></div>
                </div>
            </div>
        </section>

        <!-- Lightbox Modal -->
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-950/95 backdrop-blur-2xl"
             style="display: none;">
            
            <button @click="closeLightbox()" class="absolute top-8 right-8 w-14 h-14 bg-white/10 hover:bg-primary text-white rounded-full flex items-center justify-center transition-all z-[110] group">
                <i class="fas fa-times text-xl transition-transform group-hover:rotate-90"></i>
            </button>

            <div class="max-w-6xl w-full flex flex-col md:flex-row gap-12 items-center" @click.away="closeLightbox()">
                <div class="flex-1 rounded-[48px] overflow-hidden shadow-2xl border-4 border-white/5 bg-slate-900 aspect-[4/5] md:aspect-auto">
                    <img :src="currentImg" class="w-full h-full object-contain">
                </div>
                <div class="w-full md:w-96 text-left space-y-6">
                    <h4 class="text-3xl md:text-4xl font-black text-white tracking-tighter leading-tight" x-text="currentTitle"></h4>
                    <div class="h-1 w-20 bg-primary rounded-full"></div>
                    <p class="text-slate-400 text-lg leading-relaxed font-medium" x-text="currentDesc"></p>
                    <div class="pt-8">
                        <button @click="closeLightbox()" class="text-[10px] font-black text-primary uppercase tracking-[0.3em] hover:text-white transition-colors">
                            <i class="fas fa-chevron-left mr-3"></i> Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Masonry and Animations -->
    <style>
        .italic-font { font-family: 'Outfit', sans-serif; font-style: italic; }
        .fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .columns-1 { column-count: 1; }
        @media (min-width: 640px) { .columns-2 { column-count: 2; } }
        @media (min-width: 1024px) { .columns-3 { column-count: 3; } }
        .columns-1 img, .columns-2 img, .columns-3 img { break-inside: avoid; margin-bottom: 2rem; }
    </style>
</x-app-layout>
