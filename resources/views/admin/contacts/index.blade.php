<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-2">Messages Contact</h1>
            <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span>/</span>
                <span class="text-slate-900">Messages</span>
            </nav>
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
                        <th class="p-8">Status</th>
                        <th class="p-8">Client</th>
                        <th class="p-8">Sujet / Aperçu</th>
                        <th class="p-8">Date</th>
                        <th class="p-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-bold text-slate-600">
                    @foreach($messages as $message)
                        <tr class="hover:bg-slate-50/50 transition-colors {{ !$message->is_read ? 'bg-primary/5' : '' }}">
                            <td class="p-8">
                                @if(!$message->is_read)
                                    <span class="w-3 h-3 bg-primary rounded-full block" title="Nouveau"></span>
                                @elseif($message->replied_at)
                                    <i class="fas fa-reply text-green-500" title="Répondu"></i>
                                @else
                                    <span class="w-3 h-3 bg-slate-200 rounded-full block"></span>
                                @endif
                            </td>
                            <td class="p-8">
                                <div class="text-slate-900">{{ $message->name }}</div>
                                <div class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">{{ $message->email }}</div>
                            </td>
                            <td class="p-8">
                                <div class="text-sm text-slate-900 mb-1">{{ $message->subject ?? 'Sans sujet' }}</div>
                                <div class="text-[10px] text-slate-400 truncate max-w-xs font-medium">{{ $message->message }}</div>
                            </td>
                            <td class="p-8 text-xs">
                                {{ $message->created_at->diffForHumans() }}
                            </td>
                            <td class="p-8 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.contacts.show', $message) }}" class="w-10 h-10 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" onsubmit="return confirm('Supprimer ce message ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-10 h-10 bg-slate-100 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($messages->hasPages())
            <div class="p-8 bg-slate-50/30 border-t border-slate-50">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
