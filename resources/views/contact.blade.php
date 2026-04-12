<x-app-layout>
    <!-- INDUSTRIAL HERO SECTION -->
    <section class="relative h-[400px] overflow-hidden bg-slate-900">
        <img src="https://images.unsplash.com/photo-1590682680695-43b964a3ae17?q=80&w=2000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-50" alt="Contact Thiotty">
        <div class="container-custom relative h-full flex flex-col justify-center z-10">
            <div class="inline-block bg-[var(--primary)] text-white px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.3em] mb-4 border-l-4 border-[var(--secondary)] w-fit">
                Nous Contacter
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white leading-tight uppercase tracking-tight mb-4">
                Parlons de vos <span class="text-[var(--primary)]">Besoin</span> Pro.
            </h1>
            <p class="text-white/60 text-lg max-w-2xl font-medium tracking-wide">
                Une logistique agro-industrielle à votre service. Notre équipe d'experts vous répond sous 24h pour toutes vos demandes d'approvisionnement.
            </p>
        </div>
    </section>

    <!-- CONTACT GRID -->
    <section class="py-24 bg-white">
        <div class="container-custom">
            <div class="grid lg:grid-cols-12 gap-16">
                <!-- Info Column -->
                <div class="lg:col-span-5 space-y-12">
                    <div class="border-l-8 border-[var(--primary)] pl-8">
                        <h2 class="text-[12px] font-black text-[var(--primary)] uppercase tracking-[0.4em] mb-2">Informations</h2>
                        <h3 class="text-3xl font-black text-slate-800 uppercase tracking-tight">Thiotty Enterprise</h3>
                    </div>

                    <div class="grid gap-8">
                        <!-- Card -->
                        <div class="flex items-start gap-6 p-8 bg-slate-50 border border-slate-100 group hover:border-[var(--primary)] transition-colors">
                            <div class="w-12 h-12 bg-white text-[var(--primary)] flex items-center justify-center text-xl shadow-sm">
                                <i class="fas fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Siège Social</h4>
                                <p class="text-slate-800 font-bold leading-relaxed">Dakar, Sénégal<br>Zone Industrielle de Mbao</p>
                            </div>
                        </div>

                        <!-- Card -->
                        <div class="flex items-start gap-6 p-8 bg-slate-50 border border-slate-100 group hover:border-[var(--primary)] transition-colors">
                            <div class="w-12 h-12 bg-white text-[var(--primary)] flex items-center justify-center text-xl shadow-sm">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Téléphone</h4>
                                <p class="text-slate-800 font-bold leading-relaxed">+221 78 357 74 31</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Lun - Sam: 09h00 - 18h00</p>
                            </div>
                        </div>

                        <!-- Card -->
                        <div class="flex items-start gap-6 p-8 bg-slate-50 border border-slate-100 group hover:border-[var(--primary)] transition-colors">
                            <div class="w-12 h-12 bg-white text-[var(--primary)] flex items-center justify-center text-xl shadow-sm">
                                <i class="far fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email</h4>
                                <p class="text-slate-800 font-bold leading-relaxed">contact@thiotty.com</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Réponse sous 24h</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="lg:col-span-7">
                    <div class="bg-white p-8 md:p-12 border border-slate-200 shadow-2xl relative">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-slate-50 flex items-center justify-center text-slate-200">
                            <i class="fas fa-paper-plane text-4xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tight mb-8">Envoyez-nous un Message</h3>

                        @if(session('success'))
                            <div class="mb-8 p-4 bg-green-50 border-l-4 border-[var(--primary)] text-[var(--primary)] font-bold text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nom Complet</label>
                                    <input type="text" name="name" required class="w-full h-14 bg-slate-50 border-slate-200 rounded-none px-6 text-sm font-bold focus:ring-1 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all outline-none" placeholder="Adama Ndiaye">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Professionnel</label>
                                    <input type="email" name="email" required class="w-full h-14 bg-slate-50 border-slate-200 rounded-none px-6 text-sm font-bold focus:ring-1 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all outline-none" placeholder="adama@entreprise.com">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sujet</label>
                                <input type="text" name="subject" class="w-full h-14 bg-slate-50 border-slate-200 rounded-none px-6 text-sm font-bold focus:ring-1 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all outline-none" placeholder="Demande de devis / Partenariat">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Message</label>
                                <textarea name="message" rows="6" required class="w-full bg-slate-50 border-slate-200 rounded-none px-6 py-4 text-sm font-bold focus:ring-1 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all outline-none resize-none" placeholder="Décrivez votre besoin..."></textarea>
                            </div>

                            <button type="submit" class="w-full h-16 bg-[var(--primary)] text-white font-black text-sm uppercase tracking-[0.2em] hover:bg-[var(--primary-hover)] transition-all shadow-xl shadow-[var(--primary)]/10">
                                Envoyer la demande
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAP SECTION -->
    <section class="h-[500px] w-full bg-slate-200 grayscale contrast-125">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d123485.4093959146!2d-17.4666822!3d14.716677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xec172fd97cc5013%3A0xe5a3c98ba9c51234!2sDakar%2C%20Sngal!5e0!3m2!1sfr!2sfr!4v1712880000000!5m2!1sfr!2sfr" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </section>
</x-app-layout>
