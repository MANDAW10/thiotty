<x-guest-layout>
    <div class="mb-8 text-center" x-data="{ loading: false }">
        <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/10">
            <i class="fas fa-user-plus text-2xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-2">Inscription</h2>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rejoignez la <span class="text-primary">famille Lahad</span></p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ show: false, showConfirm: false, loading: false, 
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
    }" @submit="loading = true">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Nom</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-primary transition-colors">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <input id="name" name="name" type="text" 
                           class="w-full bg-slate-50 border-none rounded-xl py-3 pl-12 pr-4 font-bold text-slate-900 text-xs focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" 
                           placeholder="Nom complet"
                           value="{{ old('name') }}" required autofocus autocomplete="name">
                </div>
            </div>

            <!-- Phone Number -->
            <div class="space-y-1.5">
                <label for="phone" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Numéro</label>
                <div class="relative group flex items-center">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <span class="text-[10px] font-black text-primary bg-primary/10 px-1.5 py-0.5 rounded-md">+221</span>
                    </div>
                    <input id="phone" name="phone" type="tel" x-on:input="formatPhone($event)"
                           class="w-full bg-slate-50 border-none rounded-xl py-3 pl-14 pr-4 font-bold text-slate-900 text-xs focus:ring-2 focus:ring-primary/20 transition-all font-sans placeholder:text-slate-300" 
                           value="{{ old('phone') }}" required placeholder="7x xxx xx">
                </div>
            </div>
        </div>

        <x-input-error :messages="$errors->get('name')" class="mt-1" />
        <x-input-error :messages="$errors->get('phone')" class="mt-1" />

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-primary transition-colors">
                    <i class="fas fa-envelope text-sm"></i>
                </div>
                <input id="email" name="email" type="email" 
                       class="w-full bg-slate-50 border-none rounded-xl py-3 pl-12 pr-4 font-bold text-slate-900 text-xs focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" 
                       placeholder="votre@email.com"
                       value="{{ old('email') }}" required autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Pass</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-primary transition-colors">
                        <i class="fas fa-lock text-sm"></i>
                    </div>
                    <input id="password" name="password" :type="show ? 'text' : 'password'" 
                           class="w-full bg-slate-50 border-none rounded-xl py-3 pl-12 pr-10 font-bold text-slate-900 text-xs focus:ring-2 focus:ring-primary/20 transition-all font-sans placeholder:text-slate-300" 
                           placeholder="••••"
                           required autocomplete="new-password">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-primary transition-colors">
                        <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye' text-[10px]"></i>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <label for="password_confirmation" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Confirmer</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-primary transition-colors">
                        <i class="fas fa-check-double text-sm"></i>
                    </div>
                    <input id="password_confirmation" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" 
                           class="w-full bg-slate-50 border-none rounded-xl py-3 pl-12 pr-10 font-bold text-slate-900 text-xs focus:ring-2 focus:ring-primary/20 transition-all font-sans placeholder:text-slate-300" 
                           placeholder="••••"
                           required autocomplete="new-password">
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-primary transition-colors">
                        <i class="fas" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye' text-[10px]"></i>
                    </button>
                </div>
            </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-1" />

        <div class="pt-4">
            <button type="submit" class="btn-lahad w-full py-4 text-base shadow-xl shadow-primary/20 relative overflow-hidden group" :disabled="loading">
                <span x-show="!loading" class="flex items-center justify-center gap-3">
                    S'inscrire <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </span>
                <span x-show="loading" class="flex items-center justify-center gap-3" style="display: none;">
                    <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
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


