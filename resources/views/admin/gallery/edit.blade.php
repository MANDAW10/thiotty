<x-admin-layout>
    <div class="mb-12">
        <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.gallery.index') }}" class="hover:text-primary transition-colors">Galerie</a>
            <span>/</span>
            <span class="text-slate-900">Modifier</span>
        </nav>
        <h1 class="text-3xl font-black text-slate-900">Modifier l'Image</h1>
    </div>

    <div class="max-w-2xl bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 shadow-sm">
        <form action="{{ route('admin.gallery.update', $item) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Image Preview -->
            <div class="w-full aspect-video rounded-3xl overflow-hidden border border-slate-100 bg-slate-50 mb-8">
                <img src="{{ $item->image }}" class="w-full h-full object-cover">
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">URL de l'Image</label>
                <input type="text" name="image" value="{{ old('image', $item->image) }}" required
                       class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Titre</label>
                    <input type="text" name="title" value="{{ old('title', $item->title) }}" required
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Catégorie</label>
                    <select name="category" required 
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer">
                        <option value="Terroir" {{ $item->category == 'Terroir' ? 'selected' : '' }}>Terroir</option>
                        <option value="Elevage" {{ $item->category == 'Elevage' ? 'selected' : '' }}>Elevage</option>
                        <option value="Culture" {{ $item->category == 'Culture' ? 'selected' : '' }}>Culture</option>
                        <option value="Processus" {{ $item->category == 'Processus' ? 'selected' : '' }}>Processus</option>
                        <option value="Engagement" {{ $item->category == 'Engagement' ? 'selected' : '' }}>Engagement</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Description (Optionnel)</label>
                <textarea name="description" rows="4" 
                          class="w-full bg-slate-50 border-none rounded-3xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">{{ old('description', $item->description) }}</textarea>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-thiotty w-full py-4 shadow-xl shadow-primary/20">
                    Mettre à jour l'Image
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
