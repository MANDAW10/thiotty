<x-admin-layout>
    <div class="mb-12">
        <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.alerts.index') }}" class="hover:text-primary transition-colors">Alertes</a>
            <span>/</span>
            <span class="text-slate-900">Nouvelle</span>
        </nav>
        <h1 class="text-3xl font-black text-slate-900">Diffuser une Alerte</h1>
    </div>

    <div class="max-w-2xl bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 shadow-sm">
        <form action="{{ route('admin.alerts.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Titre de l'Alerte</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ex: Maintenance programmée"
                       class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Type d'Alerte</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="info" checked class="peer sr-only">
                        <div class="p-4 rounded-2xl border border-slate-100 text-center peer-checked:bg-blue-500 peer-checked:text-white transition-all">
                            <i class="fas fa-info-circle mb-2 block"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest">Info</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="warning" class="peer sr-only">
                        <div class="p-4 rounded-2xl border border-slate-100 text-center peer-checked:bg-amber-500 peer-checked:text-white transition-all">
                            <i class="fas fa-exclamation-triangle mb-2 block"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest">Alerte</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="success" class="peer sr-only">
                        <div class="p-4 rounded-2xl border border-slate-100 text-center peer-checked:bg-green-500 peer-checked:text-white transition-all">
                            <i class="fas fa-check-circle mb-2 block"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest">Succès</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Message</label>
                <textarea name="message" rows="4" required placeholder="Tapez votre message ici..."
                          class="w-full bg-slate-50 border-none rounded-3xl py-6 px-8 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all"></textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-lahad w-full py-4 shadow-xl shadow-primary/20">
                    Lancer la Diffusion
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
