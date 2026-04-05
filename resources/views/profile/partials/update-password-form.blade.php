<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div class="space-y-1">
            <label for="update_password_current_password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Mot de passe actuel</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full bg-white border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans shadow-sm" autocomplete="current-password">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label for="update_password_password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nouveau mot de passe</label>
                <input id="update_password_password" name="password" type="password" class="w-full bg-white border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans shadow-sm" autocomplete="new-password">
            </div>

            <div class="space-y-1">
                <label for="update_password_password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Confirmer mot de passe</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full bg-white border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans shadow-sm" autocomplete="new-password">
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-lahad py-3 px-8 text-sm shadow-lg shadow-primary/10 text-white">Changer le mot de passe</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-bold text-green-600">
                    <i class="fas fa-shield-check mr-1"></i> Sécurisé avec succès
                </p>
            @endif
        </div>
    </form>
</section>
