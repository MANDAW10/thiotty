<x-guest-layout>
    <div class="mb-10 text-center">
        <div class="w-16 h-16 bg-primary/5 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-user text-2xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-2">Bienvenue</h2>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Accédez à votre compte <span class="text-primary">Lahad</span></p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email</label>
            <input id="email" name="email" type="email" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" 
                   value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between items-center ml-1">
                <label for="password" class="text-[10px] font-black uppercase tracking-widest text-slate-400">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline" href="{{ route('password.request') }}">
                        Oublié ?
                    </a>
                @endif
            </div>
            <input id="password" name="password" type="password" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" 
                   required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded-lg border-slate-200 text-primary shadow-sm focus:ring-primary/20 w-5 h-5 cursor-pointer" name="remember">
            <label for="remember_me" class="ms-3 text-xs font-bold text-slate-500 cursor-pointer">Se souvenir de moi</label>
        </div>

        <button type="submit" class="btn-lahad w-full py-5 text-lg shadow-xl shadow-primary/10">
            Se Connecter
        </button>

        <div class="text-center pt-4">
            <p class="text-xs font-bold text-slate-400">
                Pas encore de compte ? 
                <a href="{{ route('register') }}" class="text-primary hover:underline ml-1">Inscrivez-vous ici</a>
            </p>
        </div>
    </form>
</x-guest-layout>
