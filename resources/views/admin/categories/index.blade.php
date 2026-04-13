<x-admin-layout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-1">Catégories</h1>
            <p class="text-[9px] md:text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Thiotty Enterprise — Gestion des catégories</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 font-bold text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 font-bold text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Category Form -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm sticky top-24">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    Nouvelle Catégorie
                </h3>

                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Nom de la catégorie</label>
                        <input type="text" name="name" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" placeholder="Ex: Élevage, Terroir...">
                        @error('name') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Catégorie Parente (Optionnel)</label>
                        <select name="parent_id" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all">
                            <option value="">Aucune (Catégorie principale)</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-[8px] text-slate-400 font-bold mt-1 ml-1">Choisissez si c'est une sous-catégorie.</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Icône (FontAwesome class)</label>
                        <input type="text" name="icon" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300" placeholder="Ex: fa-cow, fa-leaf...">
                        <p class="text-[8px] text-slate-400 font-bold mt-1 ml-1">Utilisé dans la navigation mobile.</p>
                    </div>

                    <div class="space-y-1.5" x-data="{ photoName: null, photoPreview: null }">
                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-1">Image (Optionnel)</label>
                        
                        <div class="mt-1 flex flex-col items-center">
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
                                <div class="w-full h-32 rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-primary/50 group-hover:bg-primary/5">
                                    <template x-if="!photoPreview">
                                        <div class="text-center">
                                            <i class="fas fa-image text-xl text-slate-300 mb-1"></i>
                                            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Choisir</p>
                                        </div>
                                    </template>
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="w-full h-full object-cover">
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-thiotty w-full py-4 text-xs">
                        Créer la catégorie
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                        <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                        Liste des Catégories
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Nom</th>
                                <th class="px-8 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-center">Parente</th>
                                <th class="px-8 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-center">Icône</th>
                                <th class="px-8 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-center">Produits</th>
                                <th class="px-8 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($categories as $category)
                            <tr class="hover:bg-slate-50/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        @if($category->image)
                                            <img src="{{ $category->image_url }}" class="w-10 h-10 rounded-xl object-cover border border-slate-100">
                                        @else
                                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-folder text-slate-300"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-black text-slate-900">{{ $category->name }}</p>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $category->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @if($category->parent)
                                        <span class="px-3 py-1 bg-primary/5 text-primary text-[9px] font-black uppercase tracking-widest border border-primary/10 rounded-full">
                                            {{ $category->parent->name }}
                                        </span>
                                    @else
                                        <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">Principale</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @if($category->icon)
                                        <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center mx-auto">
                                            <i class="fas {{ $category->icon }}"></i>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-300">Aucun</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-xs font-black text-slate-900">{{ $category->products_count }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-500 rounded-lg hover:bg-blue-500 hover:text-white transition-all">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-all">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($categories->isEmpty())
                    <div class="p-12 text-center">
                        <p class="text-sm font-bold text-slate-400">Aucune catégorie pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
