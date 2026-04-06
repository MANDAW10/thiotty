<x-admin-layout>
    <div class="mb-12">
        <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.products.index') }}" class="hover:text-primary transition-colors">Produits</a>
            <span>/</span>
            <span class="text-slate-900">Modifier</span>
        </nav>
        <h1 class="text-3xl font-black text-slate-900">Modifier le produit</h1>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')
        
        <!-- Left Column: Main Info -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 md:p-10 rounded-[40px] border border-slate-100 shadow-sm space-y-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nom du Produit</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Description Détaillée</label>
                    <textarea name="description" rows="8" required 
                              class="w-full bg-slate-50 border-none rounded-3xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">{{ old('description', $product->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-[40px] border border-slate-100 shadow-sm">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 pb-4 border-b border-slate-50">Logistique & Prix</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Prix (CFA)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required 
                               class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Stock Initial</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required 
                               class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar Meta -->
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm space-y-6">
                <!-- Preview Current Image -->
                @if($product->image)
                    <div class="w-full aspect-[4/3] rounded-3xl overflow-hidden border border-slate-100 bg-slate-50 mb-4">
                        <img src="{{ $product->image }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Catégorie</label>
                    <select name="category_id" required 
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all appearance-none">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">URL de l'Image</label>
                    <input type="text" name="image" value="{{ old('image', $product->image) }}" 
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                </div>

                <div class="pt-4 border-t border-slate-50">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-6 h-6 rounded-lg border-slate-200 text-primary focus:ring-primary/20 transition-all">
                        <span class="text-xs font-bold text-slate-600 group-hover:text-slate-900">Mettre en Vedette (Home)</span>
                    </label>
                </div>
            </div>

            <div class="bg-slate-900 p-8 rounded-[40px] shadow-2xl shadow-primary/20">
                <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-6">Mise à jour</p>
                <div class="space-y-4">
                    <button type="submit" class="btn-thiotty w-full py-4 shadow-none">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="w-full py-4 flex items-center justify-center text-xs font-black text-slate-400 uppercase tracking-widest hover:text-white transition-colors">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>
