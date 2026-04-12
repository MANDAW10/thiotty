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
        <header class="py-24 bg-white border-b border-slate-100 relative overflow-hidden">
            <div class="container-custom relative z-10">
                <div class="inline-block bg-[var(--primary)] text-white px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.3em] mb-6 border-l-4 border-[var(--secondary)]">
                    Notre Vision
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] mb-8 uppercase tracking-tight">
                    Immersion <span class="text-[var(--primary)]">Industrielle</span>.
                </h1>
                <p class="text-slate-500 font-medium max-w-2xl text-lg leading-relaxed">
                    Découvrez l'excellence de nos infrastructures et la rigueur de nos processus. Thiotty Enterprise s'engage pour une agriculture moderne et durable.
                </p>
            </div>
        </header>

        <!-- Gallery Grid -->
        <section class="py-24 bg-slate-50">
            <div class="container-custom">
                <!-- Filter Tabs (Industrial) -->
                <div class="flex flex-wrap gap-4 mb-16">
                    <button class="px-10 py-4 bg-[var(--primary)] text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-none">Tout</button>
                    <button class="px-10 py-4 bg-white border border-slate-200 text-slate-400 hover:text-[var(--primary)] hover:border-[var(--primary)] font-black text-[10px] uppercase tracking-[0.2em] rounded-none transition-all">Élevage</button>
                    <button class="px-10 py-4 bg-white border border-slate-200 text-slate-400 hover:text-[var(--primary)] hover:border-[var(--primary)] font-black text-[10px] uppercase tracking-[0.2em] rounded-none transition-all">Terroir</button>
                    <button class="px-10 py-4 bg-white border border-slate-200 text-slate-400 hover:text-[var(--primary)] hover:border-[var(--primary)] font-black text-[10px] uppercase tracking-[0.2em] rounded-none transition-all">Culture</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-0 border border-slate-200 bg-slate-200">
                    @forelse($items as $item)
                        <!-- Industrial Gallery Card -->
                        <div @click="openLightbox('{{ $item->image_url }}', '{{ $item->title }}', '{{ $item->description }}')" 
                             class="group cursor-zoom-in relative aspect-square overflow-hidden bg-white border border-slate-200">
                            
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110 grayscale brightness-90 group-hover:grayscale-0 group-hover:brightness-100">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent p-10 translate-y-6 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="text-[9px] font-black text-[var(--secondary)] uppercase tracking-[3px] mb-3 block">{{ $item->category }}</span>
                                <h4 class="text-white text-xl md:text-2xl font-black leading-tight tracking-tight uppercase mb-4">{{ $item->title }}</h4>
                                <div class="h-1 w-12 bg-[var(--primary)] group-hover:w-full transition-all duration-500"></div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-32 text-center bg-white border border-slate-100">
                            <i class="fas fa-camera text-4xl text-slate-100 mb-6"></i>
                            <p class="text-slate-300 font-bold uppercase tracking-widest text-[10px]">Chargement des visuels...</p>
                        </div>
                    @endforelse
                </div>

                <!-- Call to Action (Industrial) -->
                <div class="mt-24 p-12 md:p-24 bg-[var(--primary)] text-white relative overflow-hidden flex flex-col items-center text-center">
                    <h3 class="text-3xl md:text-5xl font-black mb-10 tracking-tight uppercase leading-tight max-w-3xl">Inspiré par l'excellence agro-industrielle ?</h3>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-6 bg-white text-[var(--primary)] px-12 py-6 font-black text-[11px] uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all group">
                        Parcourir nos produits <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Lightbox Modal (Sharp Corners) -->
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[200] flex items-center justify-center p-6 bg-slate-950/95"
             style="display: none;">
            
            <button @click="closeLightbox()" class="absolute top-8 right-8 w-14 h-14 bg-white/10 hover:bg-[var(--primary)] text-white flex items-center justify-center transition-all z-[210] group">
                <i class="fas fa-times text-xl transition-transform group-hover:rotate-90"></i>
            </button>

            <div class="max-w-6xl w-full flex flex-col md:flex-row gap-0 bg-white shadow-2xl overflow-hidden" @click.away="closeLightbox()">
                <div class="flex-1 bg-slate-900 aspect-square md:aspect-auto">
                    <img :src="currentImg" class="w-full h-full object-cover">
                </div>
                <div class="w-full md:w-[400px] p-12 text-left space-y-8 flex flex-col justify-center">
                    <div>
                        <span class="text-[10px] font-black text-[var(--primary)] uppercase tracking-widest mb-4 block">Focus Produit</span>
                        <h4 class="text-4xl font-black text-slate-900 leading-[1.1] uppercase tracking-tight" x-text="currentTitle"></h4>
                    </div>
                    <div class="h-1 w-20 bg-[var(--primary)]"></div>
                    <p class="text-slate-500 text-lg leading-relaxed font-medium" x-text="currentDesc"></p>
                    <div class="pt-8">
                        <button @click="closeLightbox()" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-[var(--primary)] transition-colors">
                            <i class="fas fa-arrow-left mr-3"></i> Retour
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Masonry and Animations -->
    <style>
        .serif-font { font-family: 'Playfair Display', serif; }
        .italic-font { font-family: 'Outfit', sans-serif; font-style: italic; }
        
        .fade-in { 
            animation: fadeIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; 
            opacity: 0; 
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Custom Hover Effect for Cards */
        .group:hover .serif-font {
            color: var(--primary);
        }
    </style>
</x-app-layout>
