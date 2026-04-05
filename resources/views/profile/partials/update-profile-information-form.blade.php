<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label for="profile_name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nom Complet</label>
                <input id="profile_name" name="name" type="text" class="w-full bg-white border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans shadow-sm" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="space-y-1">
                <label for="profile_phone" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Numéro de téléphone</label>
                <input id="profile_phone" name="phone" type="tel" x-on:input="formatPhone($event)" class="w-full bg-white border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans shadow-sm" value="{{ old('phone', $user->phone) }}" required placeholder="7x xxx xx xx">
            </div>
        </div>

        <div class="space-y-1">
            <label for="profile_email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email</label>
            <input id="profile_email" name="email" type="email" class="w-full bg-white border-none rounded-2xl py-3 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all font-sans shadow-sm" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-lahad py-3 px-8 text-sm shadow-lg shadow-primary/10 text-white">Mettre à jour</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-bold text-green-600">
                    <i class="fas fa-check-circle mr-1"></i> Modifié avec succès
                </p>
            @endif
        </div>
    </form>
</section>
