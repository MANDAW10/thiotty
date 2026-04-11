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

                <div class="space-y-4 pt-4 border-t border-slate-50" x-data="{ photoName: null, photoPreview: '{{ $category->image_url }}' }">
                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Image de couverture</label>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        
                        <div class="relative group cursor-pointer w-full sm:w-48" @click.prevent="$refs.image.click()">
                            <input type="file" name="image" class="hidden" x-ref="image"
                                   @change="
                                        photoName = $refs.image.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.image.files[0]);
                                   ">
                            
                            <div class="w-full h-48 rounded-[2rem] bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-primary/50 group-hover:bg-primary/5">
                                <template x-if="!photoPreview">
                                    <div class="text-center">
                                        <i class="fas fa-image text-2xl text-slate-300 mb-2"></i>
                                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Choisir</p>
                                    </div>
                                </template>
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                            </div>
                        </div>

                        <div class="flex-1 space-y-2">
                            <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Nouvelle Image</p>
                            <p class="text-[9px] text-slate-400 font-bold italic leading-relaxed">
                                Cliquez sur la zone pour sélectionner une nouvelle image. Laissez vide pour conserver l'image actuelle.
                            </p>
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
