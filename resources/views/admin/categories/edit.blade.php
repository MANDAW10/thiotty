<x-admin-layout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-1">Modifier la Catégorie</h1>
            <p class="text-[9px] md:text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Thiotty Enterprise — Édition de {{ $category->name }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 shadow-sm transition-all hover:shadow-md group">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-10 flex items-center gap-3">
                <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                Détails de la Catégorie
            </h3>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')
                
                <div class="space-y-1.5">
                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Nom de la catégorie</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300">
                    @error('name') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Icône (FontAwesome)</label>
                        <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Slug (Auto-généré)</label>
                        <input type="text" disabled value="{{ $category->slug }}" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-300 cursor-not-allowed">
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-50">
                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Image de couverture</label>
                    <div class="flex items-center gap-6">
                        @if($category->image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $category->image) }}" class="w-24 h-24 rounded-3xl object-cover border border-slate-100 shadow-sm">
                                <div class="absolute inset-0 bg-black/40 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fas fa-image text-white text-xl"></i>
                                </div>
                            </div>
                        @else
                            <div class="w-24 h-24 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <div class="relative group">
                                <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="w-full bg-slate-100 border-2 border-dashed border-slate-200 rounded-3xl py-6 px-10 flex flex-col items-center justify-center gap-2 group-hover:border-primary/40 transition-all">
                                    <i class="fas fa-cloud-upload-alt text-slate-300 group-hover:text-primary transition-colors text-2xl"></i>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Modifier l'image</span>
                                </div>
                            </div>
                            <p class="text-[9px] text-slate-400 font-bold mt-3 italic">Laissez vide pour conserver l'image actuelle.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="btn-thiotty w-full py-5 text-sm shadow-xl shadow-primary/20">
                        Enregistrer les modifications
                    </button>
                    <p class="text-center mt-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        ID: {{ $category->id }} • Créé le {{ $category->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
