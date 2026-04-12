<x-guest-layout>
    <div class="mb-10 text-center" x-data="{ loading: false } text-center">
        <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/10">
            <i class="fas fa-user text-2xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-2">Bienvenue</h2>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Accédez à votre compte <span class="text-primary">Thiotty</span></p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <!-- Afficher les erreurs -->
    <x-form-errors />

    <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ show: false, loading: false }" @submit="loading = true">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-primary transition-colors">
                    <i class="fas fa-envelope text-sm"></i>
                </div>
                <input id="email" name="email" type="email"
                       class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-12 pr-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300"
                       placeholder="votre@email.com"
                       value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between items-center ml-1">
                <label for="password" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a class="text-[9px] font-black text-primary uppercase tracking-widest hover:underline" href="{{ route('password.request') }}">
                        Oublié ?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-primary transition-colors">
                    <i class="fas fa-lock text-sm"></i>
                </div>
                <input id="password" name="password" :type="show ? 'text' : 'password'"
                       class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-12 pr-12 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300"
                       placeholder="••••••••"
                       required autocomplete="current-password">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-primary transition-colors">
                    <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between ml-1">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-200 text-primary shadow-sm focus:ring-primary/20 w-5 h-5 cursor-pointer" name="remember">
                <label for="remember_me" class="ms-3 text-xs font-bold text-slate-500 cursor-pointer">Se souvenir de moi</label>
            </div>
        </div>

        <button type="submit" class="btn-thiotty w-full py-5 text-lg shadow-xl shadow-primary/20 relative overflow-hidden group" :disabled="loading">
            <span x-show="!loading" class="flex items-center justify-center gap-3">
                Se Connecter <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </span>
            <span x-show="loading" class="flex items-center justify-center gap-3" style="display: none;">
                <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Connexion...
            </span>
        </button>

        <div class="text-center pt-4">
            <p class="text-xs font-bold text-slate-400">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-primary hover:underline ml-1 font-black">Inscrivez-vous ici</a>
            </p>
        </div>
    </form>
</x-guest-layout>


