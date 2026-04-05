<x-guest-layout>
    <div class="mb-10 text-center">
        <div class="w-16 h-16 bg-primary/5 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-lock text-2xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-2">Mot de passe oublié</h2>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Réinitialisez votre accès en <span class="text-primary">quelques clics</span></p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email</label>
            <input id="email" name="email" type="email" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" 
                   value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="btn-lahad w-full py-5 text-[10px] sm:text-sm shadow-xl shadow-primary/10 whitespace-normal leading-relaxed px-4">
            Envoyer le lien de réinitialisation
        </button>

        <div class="text-center pt-4">
            <a href="{{ route('login') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-colors">
                <i class="fas fa-arrow-left text-[10px] mr-2"></i> Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>
