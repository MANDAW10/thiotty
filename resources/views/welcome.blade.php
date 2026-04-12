<x-app-layout>
    <!-- Immersive Cinematic Hero -->
    <!-- Sophisticated Split Hero -->
    <section class="relative py-12 lg:py-24 overflow-hidden bg-white">
        <!-- Decoration background -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-slate-50/50 -z-10 hidden lg:block"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -z-10"></div>

        <div class="container-custom relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <!-- Premium Badge -->
                    <div class="fade-in mb-8 lg:mb-10">
                        <div class="inline-flex items-center gap-3 px-6 py-2.5 bg-primary/5 border border-primary/10 rounded-full">
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse shadow-[0_0_10px_rgba(255,87,34,0.8)]"></span>
                            <span class="text-[10px] sm:text-xs font-black text-primary uppercase tracking-[0.3em]">{{ __('messages.art_agriculture') }}</span>
                        </div>
                    </div>

                    <h1 class="fade-in text-5xl sm:text-7xl lg:text-8xl font-black text-slate-900 leading-[1.05] mb-8 lg:mb-10 serif-heading">
                        {{ explode(' ', __('messages.excellence_signature'))[0] }} <br class="hidden lg:block">
                        <span class="italic-font text-primary underline decoration-primary/10 underline-offset-[12px]">{{ count(explode(' ', __('messages.excellence_signature'))) > 1 ? explode(' ', __('messages.excellence_signature'))[1] : '' }}</span>
                    </h1>

                    <p class="fade-in text-lg sm:text-xl text-slate-500 font-medium mb-10 lg:mb-14 max-w-xl leading-relaxed lg:mx-0 mx-auto" style="animation-delay: 0.2s">
                        {{ __('messages.hero_text') }}
                    </p>

                    <div class="fade-in flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6" style="animation-delay: 0.4s">
                        <a href="{{ route('shop.index') }}" class="btn-thiotty w-full sm:w-auto px-12 py-5 text-sm uppercase tracking-[0.2em] shadow-2xl">
                            {{ __('messages.explore_collection') }}
                        </a>
                        <a href="#categories" class="group flex items-center gap-4 text-xs font-black uppercase tracking-[0.3em] text-slate-900 hover:text-primary transition-all">
                            {{ __('messages.discover_universes') }}
                            <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="fade-in relative" style="animation-delay: 0.3s">
                    <div class="relative z-10 rounded-[60px] overflow-hidden shadow-[0_40px_100px_-15px_rgba(0,0,0,0.2)] aspect-[4/5] lg:aspect-auto lg:h-[700px]">
                        <img src="{{ asset('img/banners/hero-main.png') }}" class="w-full h-full object-cover scale-105 animate-[slowZoom_20s_ease-in-out_infinite]" alt="Thiotty Vision">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent"></div>
                    </div>
                    
                    <!-- Floating Highlight -->
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-secondary/10 rounded-full blur-[80px] -z-10"></div>
                </div>

            </div>
        </div>
    </section>

    <!-- Luxury Category Grid (The Lookbook) -->
    <section id="categories" class="py-24 bg-white">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-6">
                <div class="max-w-xl">
                    <h2 class="text-xs font-black text-primary uppercase tracking-[0.4em] mb-4">{{ __('messages.our_universes') }}</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight serif-heading">
                        {{ explode(' ', __('messages.browse_terroir'))[0] }} <span class="italic-font">{{ count(explode(' ', __('messages.browse_terroir'))) > 1 ? implode(' ', array_slice(explode(' ', __('messages.browse_terroir')), 1)) : '' }}</span>
                    </h3>
                </div>
                <div class="mb-2">
                    <div class="h-1 w-24 bg-primary/20 rounded-full"></div>
                </div>
            </div>

            <!-- Luxury Horizontal Category Slider -->
            <div class="flex overflow-x-auto snap-x snap-mandatory gap-8 pb-10 hide-scrollbar -mx-4 px-4 md:mx-0 md:px-0">
                @php
                    $slugs = ['vaches', 'chevaux', 'poulets', 'aliments', 'lait'];
                @endphp

                @foreach($categories->sortBy(fn($c) => array_search($c->slug, $slugs)) as $cat)
                    <a href="{{ route('shop.category', $cat->slug) }}" 
                       class="flex-none w-[70%] md:w-[280px] snap-center h-[300px] md:h-[380px] relative rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/50 transition-all duration-700 bg-slate-100 group hover-glare">
                        
                        <!-- Premium Badge -->
                        <div class="absolute top-8 left-8 z-20 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-[9px] font-black text-white uppercase tracking-[0.2em]">
                            {{ $cat->products_count }} {{ __('messages.articles_count') }}
                        </div>

                        <img src="{{ $cat->image_url }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $cat->display_name }}">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/10 to-transparent"></div>
                        
                        <div class="absolute bottom-10 left-10 right-10 z-10 transform transition-transform duration-500 group-hover:-translate-y-4">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center text-white mb-4 border border-white/20">
                                <i class="{{ $cat->icon }} text-base"></i>
                            </div>
                            <h4 class="text-3xl font-black text-white serif-heading mb-2">{{ $cat->display_name }}</h4>
                            <div class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500">
                                <span class="text-[9px] font-black text-primary uppercase tracking-[0.2em]">{{ __('messages.discover_range') }}</span>
                                <div class="w-8 h-[1px] bg-primary"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- The Thiotty Heritage (Storytelling) -->
    <section class="py-32 bg-slate-900 text-white overflow-hidden relative">
        <!-- Abstract Decoration -->
        <div class="absolute -top-64 -right-64 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-64 -left-64 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-[120px]"></div>

        <div class="container-custom relative z-10">
            <div class="grid lg:grid-cols-2 gap-24 items-center">
                <div class="relative order-2 lg:order-1 hidden md:block">
                    <div class="relative z-10 rounded-[60px] overflow-hidden shadow-2xl shadow-black/50 aspect-[4/5]">
                        <img src="https://images.unsplash.com/photo-1629904853716-f0bc54ea4813?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover" alt="Notre Passion">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                    </div>
                    <!-- Floating Stat Card -->
                    <div class="absolute -bottom-10 -right-10 md:right-10 bg-white p-10 rounded-[40px] shadow-2xl text-slate-900 border border-slate-100 hidden sm:block">
                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-2">{{ __('messages.local_impact') }}</p>
                        <h4 class="text-4xl font-black serif-heading">+500</h4>
                        <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ __('messages.partner_producers') }}</p>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <h2 class="text-xs font-black text-primary uppercase tracking-[0.4em] mb-6">{{ __('messages.our_heritage') }}</h2>
                    <h3 class="text-5xl md:text-6xl font-black mb-10 leading-tight serif-heading">
                        {{ explode(',', __('messages.passion_label'))[0] }} <br>
                        <span class="italic-font text-primary">{{ count(explode(',', __('messages.passion_label'))) > 1 ? explode(',', __('messages.passion_label'))[1] : '' }}</span>
                    </h3>
                    <p class="text-lg text-slate-400 font-medium leading-relaxed mb-12">
                        {{ __('messages.heritage_text') }}
                    </p>
                    
                    <div class="grid grid-cols-2 gap-12">
                        <div>
                            <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-primary mb-6 border border-white/10">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h4 class="text-sm font-black uppercase tracking-widest mb-3">{{ __('messages.quality_certified') }}</h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-bold">{{ __('messages.quality_text') }}</p>
                        </div>
                        <div>
                            <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-primary mb-6 border border-white/10">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h4 class="text-sm font-black uppercase tracking-widest mb-3">{{ __('messages.natural_label') }}</h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-bold">{{ __('messages.natural_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Curated Product Gallery -->
    <section class="py-32 bg-slate-50/50">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row items-center justify-between mb-20 gap-8">
                <div class="text-center md:text-left">
                    <h2 class="text-xs font-black text-primary uppercase tracking-[0.4em] mb-4">{{ __('messages.the_selection') }}</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-slate-900 serif-heading">
                        {{ explode(' ', __('messages.harvest_of_moment'))[0] }} <span class="italic-font">{{ count(explode(' ', __('messages.harvest_of_moment'))) > 1 ? implode(' ', array_slice(explode(' ', __('messages.harvest_of_moment')), 1)) : '' }}</span>
                    </h3>
                </div>
                <a href="{{ route('shop.index') }}" class="group flex items-center gap-4 text-xs font-black uppercase tracking-[0.3em] text-slate-900 hover:text-primary transition-all">
                    {{ __('messages.view_collection') }}
                    <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Refined Testimonials Section -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-primary mb-4">{{ __('messages.thiotty_distinction') }}</h2>
                <h3 class="text-4xl md:text-5xl font-black text-slate-900 serif-heading">{{ explode(' ', __('messages.client_trust'))[0] }} {{ explode(' ', __('messages.client_trust'))[1] }} <span class="italic-font underline decoration-primary/20 underline-offset-8">{{ implode(' ', array_slice(explode(' ', __('messages.client_trust')), 2)) }}</span></h3>
            </div>

            <div class="relative">
                <div class="flex animate-marquee py-12">
                    @php
                        $testimonials = [
                            ['name' => 'Pape Mandaw Dieng', 'role' => __('messages.testimonial_1_role'), 'text' => __('messages.testimonial_1_text')],
                            ['name' => 'Abdou Lahad Geuye', 'role' => __('messages.testimonial_2_role'), 'text' => __('messages.testimonial_2_text')],
                            ['name' => 'Fatou Fall', 'role' => __('messages.testimonial_3_role'), 'text' => __('messages.testimonial_3_text')]
                        ];
                    @endphp

                    @foreach(array_merge($testimonials, $testimonials) as $t)
                        <div class="flex-none w-[450px]">
                            <div class="bg-slate-50 p-12 rounded-[50px] border border-slate-100 flex flex-col h-full group hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500">
                                <div class="flex gap-1 mb-8 text-amber-500">
                                    <i class="fas fa-star text-[10px]"></i><i class="fas fa-star text-[10px]"></i><i class="fas fa-star text-[10px]"></i><i class="fas fa-star text-[10px]"></i><i class="fas fa-star text-[10px]"></i>
                                </div>
                                <p class="text-slate-600 font-medium italic leading-relaxed text-lg mb-10">"{{ $t['text'] }}"</p>
                                <div class="flex items-center gap-4 pt-8 border-t border-slate-200 mt-auto">
                                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center font-black text-primary text-xl">
                                        {{ substr($t['name'], 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-slate-900 text-sm uppercase tracking-widest">{{ $t['name'] }}</h4>
                                        <p class="text-[10px] font-bold text-primary uppercase mt-1">{{ $t['role'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes slowZoom {
            0%, 100% { transform: scale(1.05); }
            50% { transform: scale(1.15); }
        }
    </style>
</x-app-layout>
