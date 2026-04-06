<x-app-layout>
    <!-- Hero Section -->
    <header class="py-20 lg:py-32 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary/5 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>
        
        <div class="container-custom relative z-10 text-center">
            <nav class="flex justify-center mb-8 text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-all">Accueil</a>
                <span class="opacity-20">/</span>
                <span class="text-slate-900">Contact</span>
            </nav>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 mb-8 leading-tight">
                Parlons de vos <span class="text-primary italic">projets.</span>
            </h1>
            <p class="text-slate-500 text-lg md:text-xl font-medium max-w-2xl mx-auto leading-relaxed">
                Que vous soyez un agriculteur, un éleveur ou un partenaire, nous sommes là pour vous accompagner.
            </p>
        </div>
    </header>

    <div class="py-12 lg:py-24 bg-slate-50/30">
        <div class="container-custom">
            <div class="grid lg:grid-cols-3 gap-12 lg:gap-20">
                <!-- Contact Info -->
                <div class="lg:col-span-1 space-y-10">
                    <div class="bg-white p-10 rounded-[40px] border border-slate-100 shadow-sm transition-all hover:shadow-xl hover:shadow-slate-200/50">
                        <div class="w-14 h-14 bg-orange-50 text-primary rounded-2xl flex items-center justify-center mb-8 shadow-sm">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-4">Notre Siège</h3>
                        <p class="text-slate-500 font-medium leading-relaxed">
                            Avenue Cheikh Ahmadou Bamba,<br>
                            HLM Dakar, Sénégal
                        </p>
                    </div>

                    <div class="bg-white p-10 rounded-[40px] border border-slate-100 shadow-sm transition-all hover:shadow-xl hover:shadow-slate-200/50">
                        <div class="w-14 h-14 bg-green-50 text-secondary rounded-2xl flex items-center justify-center mb-8 shadow-sm">
                            <i class="fas fa-phone-alt text-xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-4">Contact Direct</h3>
                        <div class="space-y-4">
                            <a href="tel:+221770000000" class="block text-slate-600 font-bold hover:text-primary transition-colors">+221 77 000 00 00</a>
                            <a href="mailto:contact@lahadenterprise.com" class="block text-slate-600 font-bold hover:text-primary transition-colors">contact@lahadenterprise.com</a>
                        </div>
                    </div>

                    <div class="bg-secondary rounded-[40px] p-10 text-white shadow-2xl shadow-secondary/20 relative overflow-hidden group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all"></div>
                        <h4 class="text-xl font-bold mb-4 relative z-10">WhatsApp Support</h4>
                        <p class="text-sm text-white/70 mb-8 leading-relaxed relative z-10">Besoin d'une réponse rapide ? Contactez-nous directement sur WhatsApp.</p>
                        <a href="https://wa.me/221770000000" class="flex items-center justify-center gap-3 bg-white text-secondary py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-100 transition-all shadow-xl">
                            <i class="fab fa-whatsapp text-lg"></i> Discuter maintenant
                        </a>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-[60px] p-8 md:p-16 border border-slate-100 shadow-2xl shadow-slate-200/40">
                        @if(session('success'))
                            <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 font-bold text-sm flex items-center gap-3 fade-in">
                                <i class="fas fa-check-circle"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nom Complet</label>
                                    <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}"
                                           class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                                    <x-input-error :messages="$errors->get('name')" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email</label>
                                    <input type="email" name="email" required placeholder="john@example.com" value="{{ old('email') }}"
                                           class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                                    <x-input-error :messages="$errors->get('email')" />
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Sujet</label>
                                <input type="text" name="subject" placeholder="Question sur un produit..." value="{{ old('subject') }}"
                                       class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                                <x-input-error :messages="$errors->get('subject')" />
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Message</label>
                                <textarea name="message" rows="6" required placeholder="Comment pouvons-nous vous aider ?" 
                                          class="w-full bg-slate-50 border-none rounded-3xl py-6 px-8 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all resize-none">{{ old('message') }}</textarea>
                                <x-input-error :messages="$errors->get('message')" />
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="btn-lahad px-12 py-6 text-lg shadow-xl shadow-primary/20">
                                    Envoyer le message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
