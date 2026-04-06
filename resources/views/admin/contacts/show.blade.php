<x-admin-layout>
    <div class="mb-12">
        <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest gap-2 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.contacts.index') }}" class="hover:text-primary transition-colors">Messages</a>
            <span>/</span>
            <span class="text-slate-900">Lecture</span>
        </nav>
        <h1 class="text-3xl font-black text-slate-900">Lecture Message</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Message Content -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 shadow-sm">
                <div class="flex justify-between items-start mb-10 pb-6 border-b border-slate-50">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 mb-2">{{ $message->subject ?? 'Sans Sujet' }}</h2>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="text-primary italic">{{ $message->name }}</span>
                            <span>&bull;</span>
                            <span>{{ $message->email }}</span>
                        </div>
                    </div>
                    <div class="text-xs font-bold text-slate-400 italic">
                        Le {{ $message->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
                
                <div class="prose prose-slate max-w-none">
                    <p class="text-slate-600 leading-loose whitespace-pre-line font-medium">{{ $message->message }}</p>
                </div>
            </div>

            <!-- Reply Section -->
            <div class="bg-slate-900 p-8 md:p-12 rounded-[40px] shadow-2xl shadow-primary/20 text-white">
                <h3 class="text-xl font-black text-primary mb-8 flex items-center gap-3">
                    <i class="fas fa-reply text-sm"></i> Répondre au client
                </h3>
                
                @if($message->replied_at)
                    <div class="mb-8 p-6 bg-white/5 border border-white/10 rounded-3xl">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Votre réponse le {{ $message->replied_at->format('d/m/Y') }}</p>
                        <p class="text-white/80 leading-relaxed font-medium italic">{{ $message->reply_content }}</p>
                    </div>
                @endif

                <form action="{{ route('admin.contacts.reply', $message) }}" method="POST" class="space-y-6">
                    @csrf
                    <textarea name="reply_content" rows="6" required placeholder="Tapez votre réponse ici..."
                              class="w-full bg-white/5 border-none rounded-3xl py-6 px-8 font-bold text-white focus:ring-2 focus:ring-primary/40 transition-all placeholder:text-white/20"></textarea>
                    
                    <div class="flex justify-between items-center pt-2">
                        <p class="text-[9px] text-slate-500 font-bold max-w-[200px] leading-relaxed italic">
                            Note: Enregistrer la réponse marque le message comme "traité" dans votre historique.
                        </p>
                        <button type="submit" class="btn-thiotty py-4 px-12"> ENVOYER LA RÉPONSE </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Informations Client</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-primary font-black">
                            {{ substr($message->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900">{{ $message->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold truncate max-w-[150px]">{{ $message->email }}</div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-50">
                        <a href="mailto:{{ $message->email }}" class="flex items-center gap-3 text-xs font-black text-slate-600 hover:text-primary transition-colors">
                            <i class="fas fa-paper-plane text-slate-300"></i>
                            Contacter par Email
                        </a>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                @csrf
                @method('DELETE')
                <button class="w-full py-4 rounded-3xl border border-red-50 text-red-500 font-black text-[10px] uppercase tracking-widest hover:bg-red-50 transition-all">
                    Supprimer le Message
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
