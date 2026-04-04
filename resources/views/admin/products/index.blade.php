<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-2">Gestion des Produits</h1>
            <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span>/</span>
                <span class="text-slate-900">Produits</span>
            </nav>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.products.create') }}" class="btn-lahad py-3 px-6 text-sm">
                <i class="fas fa-plus mr-2 text-xs"></i> Nouveau Produit
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 font-bold text-sm flex items-center gap-3 fade-in">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                        <th class="p-8">Produit</th>
                        <th class="p-8">Catégorie</th>
                        <th class="p-8">Prix</th>
                        <th class="p-8">Stock</th>
                        <th class="p-8">Statut</th>
                        <th class="p-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($products as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-50 shrink-0 border border-slate-100">
                                        <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=200&auto=format&fit=crop' }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900">{{ $product->name }}</div>
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">#{{ $product->id }} — {{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-8">
                                <span class="px-3 py-1 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="p-8">
                                <div class="font-black text-slate-900">{{ number_format($product->price, 0, ',', ' ') }} <small class="text-[10px] opacity-40 uppercase ml-1">CFA</small></div>
                            </td>
                            <td class="p-8">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $product->stock > 10 ? 'bg-green-500' : ($product->stock > 0 ? 'bg-amber-500' : 'bg-red-500') }}"></span>
                                    <span class="font-bold text-slate-600">{{ $product->stock }} en stock</span>
                                </div>
                            </td>
                            <td class="p-8 text-center">
                                @if($product->is_featured)
                                    <span class="bg-primary/10 text-primary px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest">
                                        <i class="fas fa-star mr-1"></i> Vedette
                                    </span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="p-8 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-primary/10 hover:text-primary transition-all">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-all">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
