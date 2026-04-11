<x-app-layout>
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-6">
                <div>
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight mb-4 tracking-tighter">
                        {{ explode(' ', __('messages.my_orders'))[0] }} <span class="text-primary italic">{{ count(explode(' ', __('messages.my_orders'))) > 1 ? explode(' ', __('messages.my_orders'))[1] : '' }}</span>.
                    </h1>
                    <p class="text-lg text-slate-500 font-bold uppercase tracking-widest opacity-40">
                        {{ __('messages.track_purchases') }}
                    </p>
                    <p class="text-lg text-slate-500 font-bold uppercase tracking-widest opacity-40">
                        {{ __('messages.order_history') }}
                    </p>
                </div>
            </div>

            @if($orders->isEmpty())
                <div class="bg-[#FCFCFC] rounded-[40px] p-24 text-center border border-slate-100 flex flex-col items-center justify-center">
                    <div class="w-24 h-24 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mb-8">
                        <i class="fas fa-shopping-bag text-5xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-4">{{ __('messages.no_orders') }}</h2>
                    <p class="text-slate-400 mb-12 max-w-sm mx-auto font-bold uppercase tracking-widest text-xs">{{ __('messages.explore_shop') }}</p>
                    <a href="{{ route('shop.index') }}" class="btn-thiotty py-5 px-10">
                        {{ __('messages.start_shopping') }}
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <a href="{{ route('orders.show', $order) }}" 
                           class="group flex flex-col md:flex-row items-center justify-between p-10 bg-white border border-slate-100 rounded-[40px] hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500">
                            
                            <div class="flex items-center gap-10 w-full md:w-auto mb-8 md:mb-0">
                                <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center text-primary border-2 border-white shadow-sm flex-shrink-0 group-hover:bg-primary group-hover:text-white transition-colors duration-500">
                                    <span class="text-xl font-black">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1">{{ __('messages.placed_on') }} {{ $order->created_at->format('d/m/Y') }}</p>
                                    <h3 class="text-2xl font-black text-slate-900 truncate tracking-tighter">{{ number_format($order->total_amount, 0, ',', ' ') }} <small class="text-sm italic opacity-30 ml-1 font-black">Xof</small></h3>
                                </div>
                            </div>

                            <div class="flex items-center gap-12 w-full md:w-auto justify-between md:justify-end">
                                <div class="text-right">
                                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2 leading-none">{{ __('messages.status') }}</p>
                                    <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full 
                                        @if($order->status == 'pending') bg-amber-50 text-amber-600 @elseif($order->status == 'validated') bg-blue-50 text-blue-600 @elseif($order->status == 'delivered') bg-emerald-50 text-emerald-600 @else bg-slate-100 text-slate-500 @endif font-black text-[10px] uppercase tracking-widest border-2 border-white shadow-sm">
                                        <div class="w-1.5 h-1.5 rounded-full animate-pulse
                                            @if($order->status == 'pending') bg-amber-600 @elseif($order->status == 'validated') bg-blue-600 @elseif($order->status == 'delivered') bg-emerald-600 @else bg-slate-500 @endif"></div>
                                        <span>
                                            @if($order->status == 'pending') {{ __('messages.pending') }} @elseif($order->status == 'validated') {{ __('messages.validated') }} @elseif($order->status == 'delivered') {{ __('messages.delivered') }} @elseif($order->status == 'cancelled') {{ __('messages.cancelled') }} @else {{ $order->status }} @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 group-hover:translate-x-3 group-hover:bg-primary/10 group-hover:text-primary transition-all duration-500">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <div class="mt-20 flex justify-between items-center bg-[#FCFCFC] p-4 rounded-[32px] border border-slate-50">
                    <div>
                        @if($orders->onFirstPage())
                            <span class="px-8 py-4 rounded-2xl bg-slate-50 text-slate-300 font-black text-[10px] uppercase tracking-widest cursor-not-allowed">{{ __('messages.previous') }}</span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="px-8 py-4 rounded-2xl bg-white text-slate-900 border border-slate-100 hover:border-primary hover:text-primary transition-all font-black text-[10px] uppercase tracking-widest shadow-sm">{{ __('messages.previous') }}</a>
                        @endif
                    </div>

                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest opacity-50">
                        {{ __('messages.page') }} {{ $orders->currentPage() }}
                    </div>

                    <div>
                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="px-8 py-4 rounded-2xl bg-slate-900 text-white hover:bg-primary transition-all font-black text-[10px] uppercase tracking-widest shadow-xl shadow-slate-900/10 flex items-center gap-3 group">
                                {{ __('messages.next') }}
                                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                            </a>
                        @else
                            <span class="px-8 py-4 rounded-2xl bg-slate-50 text-slate-300 font-black text-[10px] uppercase tracking-widest cursor-not-allowed">{{ __('messages.next') }}</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
