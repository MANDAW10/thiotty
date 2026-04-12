<x-admin-layout>
    <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900">Avis clients</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Modération avant publication sur les fiches produits</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.reviews.index', ['filter' => 'pending']) }}"
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $filter === 'pending' ? 'bg-[var(--primary)] text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
                En attente @if($pendingCount > 0)<span class="ml-1 opacity-80">({{ $pendingCount }})</span>@endif
            </a>
            <a href="{{ route('admin.reviews.index', ['filter' => 'approved']) }}"
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $filter === 'approved' ? 'bg-[var(--primary)] text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
                Publiés
            </a>
            <a href="{{ route('admin.reviews.index', ['filter' => 'all']) }}"
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $filter === 'all' ? 'bg-[var(--primary)] text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
                Tous
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 text-green-800 text-sm font-bold border border-green-100">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400">Date</th>
                        <th class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400">Client</th>
                        <th class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400">Produit</th>
                        <th class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400">Note</th>
                        <th class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400">Commentaire</th>
                        <th class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-slate-50/80">
                            <td class="p-4 text-slate-500 font-medium whitespace-nowrap">{{ $review->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-4 font-bold text-slate-800">{{ $review->user?->name ?? '—' }}</td>
                            <td class="p-4">
                                <a href="{{ route('shop.product', $review->product) }}" target="_blank" class="text-primary font-bold hover:underline">{{ \Illuminate\Support\Str::limit($review->product?->name, 40) }}</a>
                            </td>
                            <td class="p-4 text-amber-500 font-black">{{ $review->rating }}/5</td>
                            <td class="p-4 text-slate-600 max-w-xs truncate">{{ $review->body ?: '—' }}</td>
                            <td class="p-4 text-right space-x-2 whitespace-nowrap">
                                @if(! $review->is_approved)
                                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-[var(--primary)] text-white text-[10px] font-black uppercase rounded-lg hover:opacity-90">Publier</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.reviews.delete', $review) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet avis ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 text-[10px] font-black uppercase rounded-lg hover:bg-red-100">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 font-bold">Aucun avis dans cette liste.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $reviews->links() }}
        </div>
    </div>
</x-admin-layout>
