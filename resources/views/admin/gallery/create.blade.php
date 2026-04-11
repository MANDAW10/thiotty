<x-admin-layout>
    <div class="mb-12">
        <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.gallery.index') }}" class="hover:text-primary transition-colors">Galerie</a>
            <span>/</span>
            <span class="text-slate-900">Nouveau</span>
        </nav>
        <h1 class="text-3xl font-black text-slate-900">Ajouter une Image</h1>
    </div>

    <div class="max-w-2xl bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 shadow-sm">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="space-y-1" x-data="{ photoName: null, photoPreview: null }">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Image de la Galerie</label>
                
                <div class="mt-2 flex flex-col items-center">
                    <input type="file" name="image" class="hidden" x-ref="image"
                           @change="
                                photoName = $refs.image.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.image.files[0]);
                           ">
                    
                    <div class="relative group cursor-pointer w-full" @click.prevent="$refs.image.click()">
                        <div class="w-full h-64 rounded-[2.5rem] bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-primary/50 group-hover:bg-primary/5">
                            <template x-if="!photoPreview">
                                <div class="text-center">
                                    <i class="fas fa-image text-3xl text-slate-300 mb-3"></i>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cliquer pour uploader</p>
                                </div>
                            </template>
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                        </div>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Titre</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ex: Elevage de Bovins"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Catégorie</label>
                    <select name="category" required 
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer">
                        <option value="Terroir">Terroir</option>
                        <option value="Elevage">Elevage</option>
                        <option value="Culture">Culture</option>
                        <option value="Processus">Processus</option>
                        <option value="Engagement">Engagement</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Description (Optionnel)</label>
                <textarea name="description" rows="4" 
                          class="w-full bg-slate-50 border-none rounded-3xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">{{ old('description') }}</textarea>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-thiotty w-full py-4 shadow-xl shadow-primary/20">
                    Ajouter à la Galerie
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
