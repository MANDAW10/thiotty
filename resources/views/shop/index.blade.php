<x-app-layout>
    <div class="py-12 bg-white min-h-screen" x-data="{ showFilters: false }">
        <div class="container-custom">
            <!-- Header Section (Industrial) -->
            <div class="mb-16 border-l-8 border-[var(--primary)] pl-8">
                <nav class="flex text-[10px] font-black text-slate-300 uppercase tracking-widest gap-2 mb-4">
                    <a href="{{ route('home') }}" class="hover:text-[var(--primary)] transition-colors">{{ __('messages.home') }}</a>
                    <span>/</span>
                    <span class="text-slate-900">{{ __('messages.shop') }}</span>
                </nav>
                <h1 class="text-4xl md:text-6xl font-black text-slate-800 uppercase tracking-tight">
                    {{ __('messages.shop') }}<span class="text-[var(--primary)]">.</span>
                </h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                <!-- Sidebar Filters (Structured) -->
                <aside class="hidden lg:block lg:col-span-3 space-y-12 h-fit sticky top-36">
                    <!-- Categories (New Industrial Design) -->
                    <div class="bg-white border-b-2 border-slate-100 pb-8">
                        <h3 class="text-[12px] font-black text-slate-900 uppercase tracking-[0.2em] mb-6 flex items-center justify-between">
                            {{ __('messages.collections') }}
                            <span class="w-8 h-[2px] bg-[var(--primary)]"></span>
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('shop.index') }}" class="group flex items-center justify-between text-[11px] font-bold uppercase tracking-widest {{ !request('category') || request('category') == 'all' ? 'text-[var(--primary)]' : 'text-slate-500 hover:text-slate-900' }}">
                                <span>{{ __('messages.view_all') }}</span>
                                <span class="text-[9px] opacity-40 group-hover:opacity-100">({{ \App\Models\Product::count() }})</span>
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('shop.index', ['category' => $cat->slug] + request()->except('category', 'page')) }}"
                                   class="group flex items-center justify-between text-[11px] font-bold uppercase tracking-widest {{ request('category') == $cat->slug ? 'text-[var(--primary)]' : 'text-slate-500 hover:text-slate-900' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-[9px] opacity-40 group-hover:opacity-100">({{ $cat->products_count }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter (Price Slider Style) -->
                    <div class="bg-white border-b-2 border-slate-100 pb-10" x-data="{ min: {{ request('min_price', 0) }}, max: {{ request('max_price', $maxPriceInDb) }}, maxLimit: {{ $maxPriceInDb }} }">
                        <h3 class="text-[12px] font-black text-slate-900 uppercase tracking-[0.2em] mb-10 flex items-center justify-between">
                            Filter By Price
                            <span class="w-8 h-[2px] bg-[var(--primary)]"></span>
                        </h3>

                        <div class="px-2">
                            <!-- Dual Range Slider Simulation -->
                            <div class="relative h-1 w-full bg-slate-100 rounded-full mb-8">
                                <div class="absolute h-full bg-[var(--primary)] rounded-full" :style="'left:' + (min/maxLimit*100) + '%; right:' + (100 - (max/maxLimit*100)) + '%'"></div>
                                <input type="range" x-model="min" min="0" :max="maxLimit" step="100" class="absolute inset-0 w-full h-1 bg-transparent appearance-none pointer-events-auto cursor-pointer accent-[var(--primary)]" @change="window.location.href = '{{ route('shop.index', request()->except(['min_price', 'page'])) }}' + '&min_price=' + min + '&max_price=' + max">
                                <input type="range" x-model="max" min="0" :max="maxLimit" step="100" class="absolute inset-0 w-full h-1 bg-transparent appearance-none pointer-events-auto cursor-pointer accent-[var(--primary)]" @change="window.location.href = '{{ route('shop.index', request()->except(['max_price', 'page'])) }}' + '&min_price=' + min + '&max_price=' + max">
                            </div>

                            <div class="flex items-center justify-between text-[11px] font-black uppercase tracking-widest text-slate-800">
                                <span>Prix: <span class="text-[var(--primary)]">CFA <span x-text="new Intl.NumberFormat('fr-FR').format(min)"></span></span></span>
                                <span>-</span>
                                <span class="text-[var(--primary)]">CFA <span x-text="new Intl.NumberFormat('fr-FR').format(max)"></span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Best Selling Products -->
                    <div class="bg-white">
                        <h3 class="text-[12px] font-black text-slate-900 uppercase tracking-[0.2em] mb-8 flex items-center justify-between">
                            Best Selling Products
                            <span class="w-8 h-[2px] bg-[var(--primary)]"></span>
                        </h3>
                        <div class="space-y-6">
                            @foreach($bestSellers as $bs)
                                <a href="{{ route('shop.product', $bs->slug) }}" class="flex items-center gap-4 group">
                                    <div class="w-16 h-16 shrink-0 bg-slate-50 overflow-hidden border border-slate-100">
                                        <img src="{{ $bs->image_url }}" alt="{{ $bs->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-[11px] font-black uppercase tracking-widest text-slate-800 group-hover:text-[var(--primary)] transition-colors truncate">{{ $bs->display_name }}</h4>
                                        <p class="text-[10px] font-bold text-[#206B13] mt-1 uppercase">CFA {{ number_format($bs->selling_price, 0, ',', ' ') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <!-- Products Grid -->
                <main class="lg:col-span-9">
                    <!-- Sorting & Layout -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 pb-4 border-b border-slate-100 gap-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">
                            {{ __('messages.showing') }} {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} / {{ $products->total() }}
                        </p>

                        <div class="flex items-center gap-4">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('messages.sort_by') }} :</label>
                            <select onchange="window.location.href = this.value" class="bg-white border border-slate-200 rounded-none py-2 pl-4 pr-10 text-[10px] font-bold uppercase tracking-widest focus:ring-1 focus:ring-[var(--primary)] cursor-pointer">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('messages.newest') }}</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('messages.price_asc_label') }}</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('messages.price_desc_label') }}</option>
                            </select>
                        </div>
                    </div>

                    @if($products->isEmpty())
                        <div class="bg-slate-50 border border-slate-100 p-24 text-center">
                             <h2 class="text-xl font-black text-slate-800 uppercase mb-4">{{ __('messages.no_results') }}</h2>
                             <a href="{{ route('shop.index') }}" class="text-[10px] font-black text-[var(--primary)] uppercase tracking-[0.3em] hover:underline">{{ __('messages.reset_all') }}</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-y-24 gap-x-20">
                            @foreach($products as $product)
                                <div class="bg-white group transition-all duration-300 p-4">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-16">
                            {{ $products->links('vendor.pagination.simple-industrial') }}
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
