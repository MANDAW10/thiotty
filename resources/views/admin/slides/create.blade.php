<x-admin-layout>
    <div class="mb-10">
        <a href="{{ route('admin.slides.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-primary transition-colors flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Retour à la Liste
        </a>
        <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Nouvelle Diapositive</h1>
    </div>

    <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
        @csrf
        
        <div class="bg-white p-10 rounded-[40px] border border-slate-100 shadow-sm space-y-8">
            <!-- Image Upload -->
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4">Image de la Bannière (Fichier image)</label>
                <div class="relative group h-[250px] bg-slate-50 border-2 border-dashed border-slate-200 rounded-[32px] flex items-center justify-center overflow-hidden transition-all hover:border-primary/50">
                    <input type="file" name="image" required class="absolute inset-0 opacity-0 cursor-pointer z-10" id="imageInput">
                    <div class="text-center" id="uploadPlaceholder">
                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm text-slate-300 flex items-center justify-center mx-auto mb-4 group-hover:text-primary transition-colors">
                            <i class="fas fa-cloud-upload-alt text-2xl"></i>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Cliquez ou glissez une image ici</p>
                    </div>
                    <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover hidden" alt="Aperçu">
                </div>
                @error('image') <p class="text-red-500 text-[10px] font-bold mt-2 uppercase">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Title -->
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Titre Principal</label>
                    <input type="text" name="title" value="{{ old('title') }}" 
                           class="w-full bg-slate-50 border-none px-6 py-4 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary/20 outline-none" 
                           placeholder="Ex: L'Excellence Bovine">
                </div>

                <!-- Subtitle -->
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Sous-titre (Description courte)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" 
                           class="w-full bg-slate-50 border-none px-6 py-4 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary/20 outline-none" 
                           placeholder="Ex: Élevage moderne au Sénégal">
                </div>

                <!-- Button Text -->
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Texte du Bouton</label>
                    <input type="text" name="button_text" value="{{ old('button_text', 'Voir Boutique') }}" 
                           class="w-full bg-slate-50 border-none px-6 py-4 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary/20 outline-none">
                </div>

                <!-- Button URL -->
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Lien URL (Optionnel)</label>
                    <input type="text" name="button_url" value="{{ old('button_url', '/shop') }}" 
                           class="w-full bg-slate-50 border-none px-6 py-4 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary/20 outline-none">
                </div>

                <!-- Order Priority -->
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Ordre d'affichage</label>
                    <input type="number" name="order_priority" value="{{ old('order_priority', 0) }}" 
                           class="w-full bg-slate-50 border-none px-6 py-4 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary/20 outline-none">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end">
                <button type="submit" class="btn-thiotty py-5 px-12 text-xs">
                    Créer la Diapositive
                </button>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('imageInput').onchange = function(evt) {
            const [file] = this.files;
            if (file) {
                document.getElementById('imagePreview').src = URL.createObjectURL(file);
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('uploadPlaceholder').classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>
