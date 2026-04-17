<x-app-layout>
@push('seo')
    @php
        $seoTitle       = 'Thiotty Enterprise | Bétail, Chevaux & Agro-alimentaire au Sénégal';
        $seoDescription = 'Thiotty Enterprise : achetez du bétail, des chevaux, des volailles et des produits agro-alimentaires de qualité directement en ligne. Livraison à domicile à Dakar et partout au Sénégal.';
        $seoImage       = asset('assets/images/branding/vaches/troupeau vache.jpg');
        $seoUrl         = url('/');
    @endphp
@endpush
    <div class="px-4 md:px-8 lg:px-12 max-w-[1800px] mx-auto pt-4 mb-12">
        <section class="relative overflow-hidden rounded-[2rem] shadow-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">

        {{-- Slides --}}
        <div class="relative" x-data="{ current: 0, total: 3 }" x-init="setInterval(() => current = (current + 1) % total, 5000)">

            {{-- Slide 1 --}}
            <div class="absolute inset-0 transition-opacity duration-700"
                :class="current === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <img src="{{ asset('assets/images/branding/vaches/troupeau vache.jpg') }}" alt="Élevage moderne africain"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 via-slate-900/30 to-slate-900/60"></div>
            </div>

            {{-- Slide 2 --}}
            <div class="absolute inset-0 transition-opacity duration-700"
                :class="current === 1 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <img src="{{ asset('assets/images/branding/vaches/troupeau de mouton.jpg') }}" alt="Alimentation bétail"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 via-slate-900/30 to-slate-900/60"></div>
            </div>

            {{-- Slide 3 --}}
            <div class="absolute inset-0 transition-opacity duration-700"
                :class="current === 2 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <img src="{{ asset('assets/images/branding/vaches/ferme poulet.jpg') }}" alt="Accompagnement éleveurs"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 via-slate-900/30 to-slate-900/60"></div>
            </div>

            {{-- Contenu --}}
            <div class="relative z-20 container-custom min-h-[860px] flex flex-col justify-center py-24">

                {{-- Contenu Slide 1 --}}
                <div class="max-w-3xl transition-all duration-700"
                    :class="current === 0 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none absolute'">
                    <span
                        class="inline-flex px-4 py-2 mb-6 text-xs font-black uppercase tracking-[0.35em] bg-white/10 text-white">Thiotty
                        Senegal</span>
                    <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tight leading-tight mb-6">Moderniser
                        l'élevage africain avec des produits de qualité</h1>
                    <p class="max-w-2xl text-sm md:text-base text-slate-200 leading-relaxed mb-10">Vente de bétail,
                        alimentation, intrants et accompagnement pour un élevage durable, rentable et respectueux de
                        l'environnement.</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <a href="{{ route('shop.index') }}"
                            class="inline-flex items-center justify-center rounded-full bg-[#f8b703] px-8 py-4 text-sm font-black uppercase tracking-[0.2em] text-slate-900 shadow-xl hover:bg-[#e0a000] transition">Voir
                            Boutique</a>
                        <a href="#categories"
                            class="inline-flex items-center justify-center rounded-full border border-white bg-white/10 px-8 py-4 text-sm font-black uppercase tracking-[0.2em] text-white hover:bg-white hover:text-slate-900 transition">Nos
                            catégories</a>
                    </div>
                </div>

                {{-- Contenu Slide 2 --}}
                <div class="max-w-3xl transition-all duration-700"
                    :class="current === 1 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none absolute'">
                    <span
                        class="inline-flex px-4 py-2 mb-6 text-xs font-black uppercase tracking-[0.35em] bg-white/10 text-white">Alimentation
                        & Intrants</span>
                    <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tight leading-tight mb-6">Des aliments
                        de qualité pour un bétail en bonne santé</h1>
                    <p class="max-w-2xl text-sm md:text-base text-slate-200 leading-relaxed mb-10">Suppléments
                        nutritionnels, compléments minéraux et aliments équilibrés pour maximiser la productivité de
                        votre élevage.</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <a href="{{ route('shop.index') }}"
                            class="inline-flex items-center justify-center rounded-full bg-[#f8b703] px-8 py-4 text-sm font-black uppercase tracking-[0.2em] text-slate-900 shadow-xl hover:bg-[#e0a000] transition">Découvrir</a>
                        <a href="#categories"
                            class="inline-flex items-center justify-center rounded-full border border-white bg-white/10 px-8 py-4 text-sm font-black uppercase tracking-[0.2em] text-white hover:bg-white hover:text-slate-900 transition">En
                            savoir plus</a>
                    </div>
                </div>

                {{-- Contenu Slide 3 --}}
                <div class="max-w-3xl transition-all duration-700"
                    :class="current === 2 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none absolute'">
                    <span
                        class="inline-flex px-4 py-2 mb-6 text-xs font-black uppercase tracking-[0.35em] bg-white/10 text-white">Accompagnement</span>
                    <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tight leading-tight mb-6">Un suivi
                        expert pour votre réussite</h1>
                    <p class="max-w-2xl text-sm md:text-base text-slate-200 leading-relaxed mb-10">Nos conseillers
                        spécialisés vous guident à chaque étape pour optimiser vos pratiques et garantir la rentabilité
                        de votre exploitation.</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center justify-center rounded-full bg-[#f8b703] px-8 py-4 text-sm font-black uppercase tracking-[0.2em] text-slate-900 shadow-xl hover:bg-[#e0a000] transition">Nous
                            contacter</a>
                        <a href="#categories"
                            class="inline-flex items-center justify-center rounded-full border border-white bg-white/10 px-8 py-4 text-sm font-black uppercase tracking-[0.2em] text-white hover:bg-white hover:text-slate-900 transition">Nos
                            services</a>
                    </div>
                </div>

            </div>

            {{-- Navigation arrows --}}
            <button @click="current = (current - 1 + total) % total"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 border border-white/30 text-white hover:bg-white/25 transition">
                &#8592;
            </button>
            <button @click="current = (current + 1) % total"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 border border-white/30 text-white hover:bg-white/25 transition">
                &#8594;
            </button>

            {{-- Dots --}}
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex gap-2">
                <template x-for="i in total" :key="i">
                    <button @click="current = i - 1" :class="current === i - 1 ? 'bg-[#f8b703] w-6' : 'bg-white/40 w-2'"
                        class="h-2 rounded-full transition-all duration-300">
                    </button>
                </template>
            </div>

        </div>
    </section>
    </div>

    <section id="categories" class="py-20 bg-white">
        <div class="container-custom">
            <div class="text-center mb-16">
                <span class="text-xs uppercase tracking-[0.35em] text-slate-500">NOS CATÉGORIES</span>
                <h2 class="mt-4 text-3xl md:text-4xl font-black text-slate-900">
                    Découvrez nos gammes de produits
                </h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2">

                <!-- VIANDE DE BOEUF -->
                <a href="{{ route('shop.category', 'viande-boeuf') }}"
                    class="group relative overflow-hidden shadow-lg transition hover:-translate-y-1 hover:shadow-xl">

                    <img src="https://images.unsplash.com/photo-1546964124-0cce460f38ef?w=800&auto=format"
                        alt="Viande de boeuf"
                        class="h-80 w-full object-cover transition duration-700 group-hover:scale-105">

                    <!-- BOUTON CENTRÉ -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-white px-8 py-4 shadow-md">
                            <p class="text-sm font-black uppercase tracking-widest text-slate-900">
                                VIANDE DE BOEUF
                            </p>
                        </div>
                    </div>
                </a>

                <!-- POULETS -->
                <a href="{{ route('shop.category', 'poulets') }}"
                    class="group relative overflow-hidden shadow-lg transition hover:-translate-y-1 hover:shadow-xl">

                    <img src="https://images.unsplash.com/photo-1587593810167-a84920ea0781?w=800&auto=format"
                        alt="Poulets" class="h-80 w-full object-cover transition duration-700 group-hover:scale-105">

                    <!-- BOUTON CENTRÉ -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-white px-8 py-4 shadow-md">
                            <p class="text-sm font-black uppercase tracking-widest text-slate-900">
                                POULETS
                            </p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <section class="py-20 bg-[var(--light-bg)] border-y border-slate-100">
        <div class="container-custom">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight mb-4">Découvrez nos
                    produits les plus vendus</h2>
                <p class="text-slate-500 text-sm md:text-base font-medium leading-relaxed">Qualité, fraîcheur et
                    satisfaction garanties. Nos meilleures références sont sélectionnées pour répondre à vos besoins.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8">
                @foreach ($bestSellers->take(8) as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('shop.index') }}"
                    class="inline-flex px-12 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-slate-900 transition-colors">Voir
                    Boutique</a>
            </div>
        </div>
    </section>

    <section class="pt-24 pb-0 bg-white">
        <div class="container-custom mb-20">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <span class="text-xs uppercase tracking-[0.35em] text-slate-500">moderniser l'élevage africain</span>
                <h2 class="mt-4 text-4xl md:text-5xl font-black text-slate-900 leading-tight">Des solutions complètes
                    pour l'élevage, la protection et la confiance.</h2>
                <p class="mt-6 text-base text-slate-600 leading-relaxed">Nous intervenons dans la vente de bétail
                    (vaches, génisses, moutons, volailles), de produits carnés, d'intrants et aliments pour bétail,
                    ainsi que dans la formation et l'accompagnement à travers des initiatives comme Thiotty Academy.</p>
            </div>

            <div class="grid gap-8 sm:grid-cols-3">
                <div class="rounded-[30px] border border-slate-200 bg-[var(--light-bg)] p-8 shadow-sm">
                    <span
                        class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[var(--primary)] text-white text-xl mb-4"><i
                            class="fas fa-cow"></i></span>
                    <h3 class="text-sm font-black uppercase tracking-[0.35em] text-slate-900">Génisses Montbéliard
                    </h3>
                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">une race reconnue pour : Leur excellente
                        production laitière Leur robustesse Leur adaptation aux conditions africaines Leur
                        croissance régulière et leur bonne fertilité</p>
                </div>
                <div class="rounded-[30px] border border-slate-200 bg-[var(--light-bg)] p-8 shadow-sm">
                    <span
                        class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[var(--primary)] text-white text-xl mb-4"><i
                            class="fas fa-shield-alt"></i></span>
                    <h3 class="text-sm font-black uppercase tracking-[0.35em] text-slate-900">Protection</h3>
                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">Thiotty mise sur des produits de qualité
                        pour assurer une protection durable, saine et respectueuse.</p>
                </div>
                <div class="rounded-[30px] border border-slate-200 bg-[var(--light-bg)] p-8 shadow-sm">
                    <span
                        class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[var(--primary)] text-white text-xl mb-4"><i
                            class="fas fa-hands-helping"></i></span>
                    <h3 class="text-sm font-black uppercase tracking-[0.35em] text-slate-900">confiance</h3>
                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">Parce que votre sécurité et votre
                        bien-être comptent, Thiotty vous accompagne avec des solutions efficaces.</p>
                </div>
            </div>
        </div>

        <div class="w-full h-[500px] lg:h-[700px] relative">
            <img src="https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=2400&auto=format&fit=crop"
                alt="Élevage africain moderne" class="h-full w-full object-cover">
        </div>
    </section>

    <section class="py-24 bg-[var(--light-bg)]">
        <div class="container-custom">
            <div class="flex flex-col items-center mb-20 text-center">
                <h3 class="text-3xl md:text-4xl font-black text-[#5BC0DE] mb-5">Produits en vedette</h3>
                <p class="text-slate-800 text-[15px] md:text-base max-w-3xl font-medium leading-relaxed">Chez Thiotty,
                    nous mettons en avant des produits de qualité, pensés pour répondre à vos besoins au quotidien.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8">
                @foreach ($featuredProducts->take(8) as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-20 text-center">
                <a href="{{ route('shop.index') }}"
                    class="inline-flex items-center gap-6 px-16 py-6 bg-slate-900 text-white font-black text-[12px] uppercase tracking-widest hover:bg-[var(--primary)] transition-all">Explorer
                    Notre Boutique</a>
            </div>
        </div>
    </section>

    {{-- <section class="py-20 bg-white border-t border-slate-100">
        <div class="container-custom grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h3 class="text-3xl font-black uppercase text-slate-900 mb-2">Abonnez-vous dès aujourd'hui !</h3>
                <p class="text-slate-500 mb-6 font-medium">Et recevez un cadeau</p>
                <p class="text-slate-600 mb-6 text-sm">Abonnez-vous dès aujourd'hui pour profiter de nos offres et
                    conseils exclusifs.</p>
                @if (session('newsletter_ok'))
                    <p class="text-green-600 font-bold text-sm mb-4">Merci ! Votre inscription a bien été prise en
                        compte.</p>
                @endif
                <form action="{{ route('newsletter.subscribe') }}" method="POST"
                    class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="email" name="email" required placeholder="Votre adresse e-mail"
                        class="flex-1 px-5 py-4 border border-slate-200 text-sm font-bold focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent outline-none"
                        value="{{ old('email') }}">
                    <button type="submit"
                        class="px-8 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-slate-900 transition-colors">S'inscrire</button>
                </form>
                @error('email')
                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="text-center">
                <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=600&auto=format&fit=crop"
                    alt="Poulet de qualité" class="rounded-2xl shadow-lg max-w-sm mx-auto">
            </div>
        </div>
    </section> --}}

    <!-- TENDANCE ACTUELLE (BLOG SECTION) -->
    <section class="py-20 bg-slate-50">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight mb-4">Tendance
                    actuelle</h2>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <article
                    class="group bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=800&auto=format&fit=crop"
                            alt="Relance de l'aviculture"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors">
                        </div>
                    </div>
                    <div class="p-6">
                        <h3
                            class="text-xl font-black text-slate-900 mb-3 group-hover:text-[#206B13] transition-colors">
                            Relance de l'aviculture</h3>
                        <p class="text-slate-500 text-[14px] leading-relaxed mb-6 font-medium">Perspectives et bonnes pratiques pour
                            les éleveurs sénégalais.</p>
                        <a href="#"
                            class="inline-flex items-center text-[13px] font-black text-[#206B13] hover:text-slate-900 transition-colors uppercase tracking-wide">
                            Lire plus <i class="fas fa-arrow-right ml-2 text-[11px]"></i>
                        </a>
                    </div>
                </article>

                <article
                    class="group bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=800&auto=format&fit=crop"
                            alt="Produits locaux & e-commerce"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors">
                        </div>
                    </div>
                    <div class="p-6">
                        <h3
                            class="text-xl font-black text-slate-900 mb-3 group-hover:text-[#206B13] transition-colors">
                            Produits locaux & e-commerce</h3>
                        <p class="text-slate-500 text-[14px] leading-relaxed mb-6 font-medium">Comment la digitalisation soutient la
                            filière et les producteurs.</p>
                        <a href="#"
                            class="inline-flex items-center text-[13px] font-black text-[#206B13] hover:text-slate-900 transition-colors uppercase tracking-wide">
                            Lire plus <i class="fas fa-arrow-right ml-2 text-[11px]"></i>
                        </a>
                    </div>
                </article>

                <article
                    class="group bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800&auto=format&fit=crop"
                            alt="Qualité et traçabilité"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors">
                        </div>
                    </div>
                    <div class="p-6">
                        <h3
                            class="text-xl font-black text-slate-900 mb-3 group-hover:text-[#206B13] transition-colors">
                            Qualité et traçabilité</h3>
                        <p class="text-slate-500 text-[14px] leading-relaxed mb-6 font-medium">Nos engagements pour une chaîne courte
                            et transparente.</p>
                        <a href="#"
                            class="inline-flex items-center text-[13px] font-black text-[#206B13] hover:text-slate-900 transition-colors uppercase tracking-wide">
                            Lire plus <i class="fas fa-arrow-right ml-2 text-[11px]"></i>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section class="py-20 bg-slate-50">
        <div class="container-custom">
            <div class="grid gap-8 md:grid-cols-4 text-center">
                <div class="group">
                    <div
                        class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="fas fa-truck-fast text-2xl text-[var(--primary)]"></i>
                    </div>
                    <h3 class="text-lg font-black uppercase tracking-tight text-slate-900 mb-3">Livraison gratuite</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Profitez de votre achat en toute tranquillité :
                        nous prenons en charge la livraison pour vous garantir rapidité, sécurité et zéro coût
                        additionnel. Achetez, on s'occupe du reste !</p>
                </div>

                <div class="group">
                    <div
                        class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="fas fa-lock text-2xl text-[var(--primary)]"></i>
                    </div>
                    <h3 class="text-lg font-black uppercase tracking-tight text-slate-900 mb-3">Paiement sécurisé en
                        ligne</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Effectuez vos achats en toute confiance grâce à
                        un système de paiement fiable et protégé, garantissant la sécurité de vos transactions du début
                        à la fin.</p>
                </div>

                <div class="group">
                    <div
                        class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="fas fa-headset text-2xl text-[var(--primary)]"></i>
                    </div>
                    <h3 class="text-lg font-black uppercase tracking-tight text-slate-900 mb-3">Assistance en ligne
                        24h/24 et 7j/7</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Notre équipe est disponible à tout moment pour
                        répondre à vos questions, vous accompagner et vous offrir un service rapide et efficace, où que
                        vous soyez.</p>
                </div>

                <div class="group">
                    <div
                        class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="fas fa-rotate-left text-2xl text-[var(--primary)]"></i>
                    </div>
                    <h3 class="text-lg font-black uppercase tracking-tight text-slate-900 mb-3">Remboursement garanti
                    </h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Votre satisfaction est notre priorité. En cas de
                        problème conforme à nos conditions, vous bénéficiez d'un remboursement rapide et transparent, en
                        toute confiance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWSLETTER SECTION -->
    <section class="bg-white">
        <div class="container-custom grid lg:grid-cols-2 gap-12 lg:gap-24 items-center">
            <div class="py-16 lg:py-24">
                <h3 class="text-[32px] lg:text-[40px] font-black uppercase text-[#0f172a] leading-tight mb-2 tracking-tight">ABONNEZ-VOUS DÈS AUJOURD'HUI !</h3>
                <p class="text-slate-500 text-[16px] font-semibold mb-8">Et recevez un cadeau</p>
                <p class="text-slate-700 text-[15px] mb-8 leading-relaxed">Abonnez-vous dès aujourd'hui pour profiter de nos offres et conseils exclusifs.</p>
                
                @if (session('newsletter_ok'))
                    <p class="text-[#206B13] font-bold text-sm mb-4">Merci ! Votre inscription a bien été prise en compte.</p>
                @endif
                
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row w-full max-w-xl">
                    @csrf
                    <input type="email" name="email" required placeholder="Votre adresse e-mail"
                        class="flex-1 w-full px-5 py-4 border border-slate-200 sm:border-r-0 text-[14px] font-bold text-[#4B5563] placeholder-[#6b7280] focus:outline-none focus:ring-0 focus:border-[var(--primary)] focus:z-10 transition-colors"
                        value="{{ old('email') }}">
                    <button type="submit"
                        class="px-10 py-4 bg-[var(--primary)] text-white font-black text-xs uppercase tracking-widest hover:bg-slate-900 transition-colors whitespace-nowrap z-0">
                        S'INSCRIRE
                    </button>
                </form>
                @error('email')
                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full">
                <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1200&auto=format&fit=crop"
                    alt="Volaille de qualité supérieure" class="w-full h-auto object-contain rounded-xl">
            </div>
        </div>
    </section>
</x-app-layout>
