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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Sidebar Filters (Structured) -->
                <aside class="hidden lg:block lg:col-span-3 space-y-12 h-fit sticky top-36">
                    <!-- Categories -->
                    <div class="bg-slate-50 border border-slate-100 p-8">
                        <h3 class="text-[11px] font-black text-slate-800 uppercase tracking-[0.3em] mb-8 border-b border-slate-200 pb-4">{{ __('messages.collections') }}</h3>
                        <div class="space-y-1">
                             <a href="{{ route('shop.index') }}" 
                                class="flex items-center justify-between p-3 px-4 transition-all {{ !request('category') || request('category') == 'all' ? 'bg-[var(--primary)] text-white' : 'text-slate-600 hover:bg-white hover:border-slate-200 border border-transparent' }}">
                                <span class="text-[10px] font-bold uppercase tracking-widest">{{ __('messages.view_all') }}</span>
                                <span class="text-[9px] font-bold opacity-60">({{ \App\Models\Product::count() }})</span>
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('shop.index', ['category' => $cat->slug] + request()->except('category', 'page')) }}" 
                                   class="flex items-center justify-between p-3 px-4 transition-all {{ request('category') == $cat->slug ? 'bg-[var(--primary)] text-white' : 'text-slate-600 hover:bg-white hover:border-slate-200 border border-transparent' }}">
                                    <span class="text-[10px] font-bold uppercase tracking-widest truncate">{{ $cat->display_name }}</span>
                                    <span class="text-[9px] font-bold opacity-60">({{ $cat->products_count }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="bg-slate-50 border border-slate-100 p-8">
                        <h3 class="text-[11px] font-black text-slate-800 uppercase tracking-[0.3em] mb-8 border-b border-slate-200 pb-4">{{ __('messages.budget') }}</h3>
                        <form action="{{ route('shop.index') }}" method="GET" class="space-y-4">
                             @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                             
                             <div class="grid grid-cols-1 gap-4">
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Min (CFA)</label>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" class="w-full bg-white border border-slate-200 rounded-none py-3 px-4 text-xs font-bold focus:ring-1 focus:ring-[var(--primary)]">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Max (CFA)</label>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" class="w-full bg-white border border-slate-200 rounded-none py-3 px-4 text-xs font-bold focus:ring-1 focus:ring-[var(--primary)]">
                                </div>
                             </div>
                             
                             <button type="submit" class="w-full py-4 bg-slate-800 text-white rounded-none text-[10px] font-black uppercase tracking-widest hover:bg-[var(--primary)] transition-all">
                                {{ __('messages.apply_filter') }}
                             </button>
                        </form>
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
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-0 border-t border-l border-slate-100">
                            @foreach($products as $product)
                                <div class="border-r border-b border-slate-100 p-4 bg-white hover:bg-slate-50 transition-colors">
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
