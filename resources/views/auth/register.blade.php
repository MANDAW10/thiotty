<x-guest-layout>
    <div class="mb-10 text-center">
        <div class="w-16 h-16 bg-primary/5 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-user-plus text-2xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-2">Rejoindre Lahad</h2>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Créez votre compte en <span class="text-primary">quelques secondes</span></p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="space-y-1">
            <label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nom Complet</label>
            <input id="name" name="name" type="text" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" 
                   value="{{ old('name') }}" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email</label>
            <input id="email" name="email" type="email" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all" 
                   value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="space-y-1" x-data="{ 
            formatPhone(e) {
                let val = e.target.value.replace(/\D/g, '');
                if (val.length > 9) val = val.substring(0, 9);
                let formatted = '';
                if (val.length > 0) {
                    formatted = val.substring(0, 2);
                    if (val.length > 2) formatted += ' ' + val.substring(2, 5);
                    if (val.length > 5) formatted += ' ' + val.substring(5, 7);
                    if (val.length > 7) formatted += ' ' + val.substring(7, 9);
                }
                e.target.value = formatted;
            }
        }">
            <label for="phone" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Numéro de téléphone</label>
            <input id="phone" name="phone" type="tel" x-on:input="formatPhone($event)"
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" 
                   value="{{ old('phone') }}" required placeholder="7x xxx xx xx">
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Mot de passe</label>
            <input id="password" name="password" type="password" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" 
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Confirmer mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" 
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-lahad w-full py-5 text-lg shadow-xl shadow-primary/10">
                S'inscrire
            </button>
        </div>

        <div class="text-center pt-4">
            <p class="text-xs font-bold text-slate-400">
                Déjà inscrit ? 
                <a href="{{ route('login') }}" class="text-primary hover:underline ml-1 font-black">Se connecter</a>
            </p>
        </div>
    </form>
</x-guest-layout>
