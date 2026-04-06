<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-2">Zones de Livraison</h1>
            <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span>/</span>
                <span class="text-slate-900">Zones</span>
            </nav>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.zones.create') }}" class="btn-thiotty py-3 px-6 text-sm shadow-xl shadow-primary/20">
                <i class="fas fa-plus mr-2 text-xs"></i> Nouvelle Zone
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 font-bold text-sm flex items-center gap-3 fade-in">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($zones as $zone)
            <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                        <i class="fas fa-truck text-xl"></i>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.zones.edit', $zone) }}" class="p-2 text-slate-400 hover:text-blue-500 transition-colors">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.zones.destroy', $zone) }}" method="POST" onsubmit="return confirm('Supprimer cette zone ?')">
                            @csrf
                            @method('DELETE')
                            <button class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">{{ $zone->name }}</h3>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-black text-primary">{{ number_format($zone->fee, 0, ',', ' ') }}</span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">CFA / Livraison</span>
                </div>
            </div>
        @endforeach
    </div>
</x-admin-layout>
