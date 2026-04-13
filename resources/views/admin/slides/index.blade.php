<x-admin-layout>
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Gestion du Slider Hero</h1>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Gérez les bannières dynamiques de votre page d'accueil</p>
        </div>
        <a href="{{ route('admin.slides.create') }}" class="btn-thiotty py-3 px-6 text-xs">
            <i class="fas fa-plus mr-2"></i> Ajouter une Diapositive
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl mb-8 text-xs font-bold flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aperçu</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Titres & Textes</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Priorité</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($slides as $slide)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="w-24 h-16 rounded-xl overflow-hidden shadow-sm border border-slate-100">
                                <img src="{{ $slide->image_url }}" alt="" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-black text-slate-900 uppercase tracking-tight">{{ $slide->title ?: 'Sans titre' }}</span>
                                <span class="text-[10px] font-bold text-slate-400 truncate max-w-xs">{{ $slide->subtitle }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[9px] font-black uppercase tracking-widest">
                                #{{ $slide->order_priority }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.slides.edit', $slide) }}" class="p-2 text-slate-400 hover:text-primary transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Supprimer ce slide ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
