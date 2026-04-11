<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-2">Galerie d'Images</h1>
            <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span>/</span>
                <span class="text-slate-900">Galerie</span>
            </nav>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.gallery.create') }}" class="btn-thiotty py-3 px-6 text-sm shadow-xl shadow-primary/20">
                <i class="fas fa-plus mr-2 text-xs"></i> Ajouter une Image
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 font-bold text-sm flex items-center gap-3 fade-in">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($items as $item)
            <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden group">
                <div class="relative aspect-square overflow-hidden bg-slate-50">
                    <img src="{{ $item->image_url }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ route('admin.gallery.edit', $item) }}" class="w-10 h-10 bg-white text-slate-900 rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer cette image ?')">
                            @csrf
                            @method('DELETE')
                            <button class="w-10 h-10 bg-white text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-[9px] font-black text-primary uppercase tracking-widest mb-1 block">{{ $item->category }}</span>
                    <h4 class="text-sm font-black text-slate-900 line-clamp-1">{{ $item->title }}</h4>
                </div>
            </div>
        @endforeach
    </div>

    @if($items->hasPages())
        <div class="mt-12">
            {{ $items->links() }}
        </div>
    @endif
</x-admin-layout>
