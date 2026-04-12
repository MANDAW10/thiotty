<x-app-layout>
    <header class="py-10 bg-slate-50 border-b border-slate-100">
        <div class="container-custom">
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight">{{ __('messages.compare_title') }}</h1>
            <p class="text-sm text-slate-500 mt-2 font-medium">{{ $products->count() }} produit(s)</p>
        </div>
    </header>

    <div class="py-12 bg-white min-h-[50vh]">
        <div class="container-custom overflow-x-auto">
            @if($products->isEmpty())
                <p class="text-center text-slate-500 font-bold py-16">{{ __('messages.compare_empty') }}</p>
                <div class="text-center">
                    <a href="{{ route('shop.index') }}" class="inline-flex px-10 py-4 bg-[var(--primary)] text-white font-black text-[11px] uppercase tracking-widest hover:bg-slate-900 transition-colors">
                        {{ __('messages.shop') }}
                    </a>
                </div>
            @else
                <table class="w-full min-w-[640px] border border-slate-100 text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="p-4 font-black uppercase text-[10px] tracking-widest text-slate-400 w-40"></th>
                            @foreach($products as $p)
                                <th class="p-4 align-bottom">
                                    <div class="aspect-square max-w-[140px] border border-slate-100 mb-3">
                                        <img src="{{ $p->image_url }}" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <a href="{{ route('shop.product', $p) }}" class="font-black text-slate-900 uppercase text-xs hover:text-[var(--primary)]">{{ $p->display_name }}</a>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400">{{ __('messages.categories_label') }}</td>
                            @foreach($products as $p)
                                <td class="p-4 font-bold text-slate-700">{{ $p->category->display_name }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400">Prix</td>
                            @foreach($products as $p)
                                <td class="p-4 font-black text-[var(--primary)]">{{ number_format($p->price, 0, ',', ' ') }} CFA</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400">{{ __('messages.in_stock') }}</td>
                            @foreach($products as $p)
                                <td class="p-4 font-bold">{{ $p->stock > 0 ? $p->stock : __('messages.out_of_stock') }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="p-4 font-black text-[10px] uppercase tracking-widest text-slate-400"></td>
                            @foreach($products as $p)
                                <td class="p-4">
                                    <a href="{{ route('shop.product', $p) }}" class="inline-block px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-[var(--primary)] transition-colors">
                                        {{ __('messages.view_items') }}
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
