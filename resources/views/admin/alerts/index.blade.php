<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-2">Alertes & Diffusions</h1>
            <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span>/</span>
                <span class="text-slate-900">Alertes</span>
            </nav>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.alerts.create') }}" class="btn-lahad py-3 px-6 text-sm shadow-xl shadow-primary/20">
                <i class="fas fa-bullhorn mr-2 text-xs"></i> Nouvelle Alerte
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 font-bold text-sm flex items-center gap-3 fade-in">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        @foreach($alerts as $alert)
            <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-start gap-6">
                        <div class="w-14 h-14 shrink-0 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110
                            @if($alert->type == 'info') bg-blue-50 text-blue-500 @elseif($alert->type == 'warning') bg-amber-50 text-amber-500 @else bg-green-50 text-green-500 @endif">
                            <i class="fas @if($alert->type == 'info') fa-info-circle @elseif($alert->type == 'warning') fa-exclamation-triangle @else fa-check-circle @endif text-2xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-xl font-black text-slate-900">{{ $alert->title }}</h3>
                                <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-full 
                                    @if($alert->is_active) bg-green-500 text-white shadow-lg shadow-green-500/20 @else bg-slate-100 text-slate-400 @endif">
                                    {{ $alert->is_active ? 'Active' : 'Désactivée' }}
                                </span>
                            </div>
                            <p class="text-slate-500 font-medium leading-relaxed max-w-2xl">{{ $alert->message }}</p>
                            <div class="mt-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Diffusée le {{ $alert->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-2 shrink-0">
                        <form action="{{ route('admin.alerts.toggle', $alert) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-4 rounded-2xl border border-slate-100 text-slate-400 hover:text-primary transition-all">
                                <i class="fas {{ $alert->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.alerts.destroy', $alert) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette alerte ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-4 rounded-2xl border border-slate-100 text-slate-400 hover:text-red-500 transition-all">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($alerts->hasPages())
        <div class="mt-12">
            {{ $alerts->links() }}
        </div>
    @endif
</x-admin-layout>
