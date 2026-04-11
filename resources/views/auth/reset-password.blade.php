<x-guest-layout>
    <div class="mb-10 text-center">
        <div class="w-16 h-16 bg-primary/5 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-key text-2xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-2">Nouveau mot de passe</h2>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Sécurisez votre compte <span class="text-primary">Thiotty</span></p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email</label>
            <input id="email" name="email" type="email" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" 
                   value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" 
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Confirmer le mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" 
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans" 
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-thiotty w-full py-5 text-lg shadow-xl shadow-primary/10">
                Réinitialiser le mot de passe
            </button>
        </div>
    </form>
</x-guest-layout>
