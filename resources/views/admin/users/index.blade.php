<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-2">Utilisateurs</h1>
            <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span>/</span>
                <span class="text-slate-900">Utilisateurs</span>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 font-bold text-sm flex items-center gap-3 fade-in">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-8 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 font-bold text-sm flex items-center gap-3 fade-in">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                        <th class="p-8">Utilisateur</th>
                        <th class="p-8">Contact</th>
                        <th class="p-8">Rôle</th>
                        <th class="p-8">Inscrit le</th>
                        <th class="p-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-bold text-slate-600">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-black">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="text-slate-900">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="p-8">
                                <div class="text-xs">{{ $user->email }}</div>
                                <div class="text-[10px] text-slate-400 mt-1">{{ $user->phone ?? 'S/N' }}</div>
                            </td>
                            <td class="p-8">
                                @if($user->is_admin)
                                    <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-full">Admin</span>
                                @else
                                    <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-full">Client</span>
                                @endif
                            </td>
                            <td class="p-8">
                                <div class="text-xs">{{ $user->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="p-8 text-right">
                                <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl border border-slate-100 hover:bg-slate-50 transition-all">
                                        {{ $user->is_admin ? 'Retirer Admin' : 'Nommer Admin' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-8 bg-slate-50/30 border-t border-slate-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
