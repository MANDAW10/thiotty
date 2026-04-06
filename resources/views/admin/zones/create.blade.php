<x-admin-layout>
    <div class="mb-12">
        <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.zones.index') }}" class="hover:text-primary transition-colors">Zones</a>
            <span>/</span>
            <span class="text-slate-900">Nouveau</span>
        </nav>
        <h1 class="text-3xl font-black text-slate-900">Ajouter une Zone</h1>
    </div>

    <div class="max-w-2xl bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 shadow-sm">
        <form action="{{ route('admin.zones.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nom de la Zone</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ex: Dakar Ville, Thiès, etc."
                       class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Frais de Livraison (CFA)</label>
                <input type="number" name="fee" value="{{ old('fee') }}" required placeholder="2000"
                       class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                <x-input-error :messages="$errors->get('fee')" class="mt-2" />
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-thiotty w-full py-4 shadow-xl shadow-primary/20">
                    Enregistrer la Zone
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
