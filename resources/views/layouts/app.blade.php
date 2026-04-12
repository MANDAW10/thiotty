<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Hotwire Turbo for SPA-like navigation -->
        <script src="https://unpkg.com/@hotwired/turbo@8.0.0/dist/turbo.es2017-umd.js" defer></script>
        <style>
            .turbo-progress-bar {
                height: 3px;
                background-color: var(--primary);
                box-shadow: 0 0 10px rgba(43, 122, 11, 0.5);
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-[#FDFDFD]">
        <!-- Global Toast Notifications -->
        <x-toast-notifications />

        <!-- Global Broadcast Alerts -->
        @php
            $activeAlerts = \App\Models\Broadcast::where('is_active', true)->latest()->get();
        @endphp
        
        @if($activeAlerts->count() > 0)
            <div class="relative z-[150]">
                @foreach($activeAlerts as $alert)
                    <div x-data="{ show: true }" x-show="show" 
                         class="relative flex items-center justify-center gap-4 px-6 py-3 text-white transition-all
                                @if($alert->type == 'info') bg-blue-600 @elseif($alert->type == 'warning') bg-amber-500 @else bg-[var(--primary)] @endif">
                        <div class="flex items-center gap-3">
                            <i class="fas @if($alert->type == 'info') fa-info-circle @elseif($alert->type == 'warning') fa-exclamation-triangle @else fa-check-circle @endif animate-pulse"></i>
                            <span class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em]">{{ $alert->title }}:</span>
                            <span class="text-[10px] md:text-sm font-bold tracking-wide">{{ $alert->message }}</span>
                        </div>
                        <button @click="show = false" class="absolute right-6 hover:scale-110 transition-transform opacity-70 hover:opacity-100">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="min-h-screen" x-data="{ showSearch: false }">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Floating WhatsApp Button (Sharp) -->
            <a x-data="{ isMobile: /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) }"
               :href="isMobile ? 'whatsapp://send?phone=221783577431' : 'https://wa.me/221783577431'" 
               target="_blank" 
               class="fixed bottom-20 right-4 sm:bottom-28 sm:right-8 z-50 w-12 h-12 sm:w-16 sm:h-16 bg-[#25D366] text-white rounded-none shadow-2xl flex items-center justify-center transition-all transform hover:scale-110 active:scale-95 border-none group">
                <i class="fab fa-whatsapp text-2xl sm:text-3xl"></i>
                <div class="absolute right-full mr-4 bg-white px-4 py-2 rounded-none shadow-xl border border-slate-100 text-slate-800 text-[10px] font-black uppercase tracking-widest whitespace-nowrap opacity-0 group-hover:opacity-100 transition-all pointer-events-none">
                    WhatsApp Support
                </div>
            </a>

            <!-- Chatbot Component (Sharp) -->
            <div x-data="{ 
                open: false, 
                isMobile: /iPhone|iPad|iPod|Android/i.test(navigator.userAgent),
                messages: [
                    { role: 'bot', text: {{ json_encode(__('messages.assistant_greeting')) }} }
                ],
                quickActions: [
                    { label: '📦 ' + {{ json_encode(__('messages.track_order')) }}, action: 'track' },
                    { label: '🐔 ' + {{ json_encode(__('messages.our_products')) }}, action: 'products' },
                    { label: '📞 ' + {{ json_encode(__('messages.talk_to_agent')) }}, action: 'whatsapp' }
                ],
                handleAction(action) {
                    if (action === 'track') {
                        this.messages.push({ role: 'user', text: {{ json_encode(__('messages.track_order')) }} });
                        setTimeout(() => {
                            this.messages.push({ role: 'bot', text: {{ json_encode(__('messages.track_order_response') ?? 'Pour suivre votre commande, merci de vous connecter à votre compte.') }} });
                        }, 500);
                    } else if (action === 'products') {
                        window.location.href = '{{ route('shop.index') }}';
                    } else if (action === 'whatsapp') {
                        const link = this.isMobile ? 'whatsapp://send?phone=221783577431' : 'https://wa.me/221783577431';
                        window.open(link, '_blank');
                    }
                }
            }" class="fixed bottom-4 right-4 sm:bottom-8 sm:right-8 z-50">
                
                <!-- Chat Window (Sharp) -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-10"
                     class="absolute bottom-16 sm:bottom-20 right-0 w-[calc(100vw-2rem)] sm:w-[350px] bg-white rounded-none shadow-2xl border border-slate-100 overflow-hidden flex flex-col max-h-[70vh] sm:max-h-[500px]"
                     style="display: none;">
                    
                    <!-- Header -->
                    <div class="bg-[var(--primary)] p-5 sm:p-6 text-white border-b-4 border-[var(--secondary)]">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-none flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-robot text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-xs uppercase tracking-wider">{{ __('messages.assistant_name') }}</h3>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    <span class="text-[10px] font-bold text-white/80 uppercase tracking-widest">{{ __('messages.assistant_online') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-4 bg-slate-50/50 custom-scrollbar">
                        <template x-for="msg in messages">
                            <div :class="msg.role === 'bot' ? 'flex justify-start' : 'flex justify-end'">
                                <div :class="msg.role === 'bot' ? 'bg-white text-slate-800 border-l-4 border-[var(--primary)]' : 'bg-[var(--primary)] text-white'" 
                                     class="max-w-[85%] p-4 text-[11px] font-bold leading-relaxed shadow-sm"
                                     x-text="msg.text">
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Actions -->
                    <div class="p-4 bg-white border-t border-slate-100 space-y-2">
                        <div class="flex flex-wrap gap-2">
                            <template x-for="action in quickActions">
                                <button @click="handleAction(action.action)" 
                                        class="bg-slate-50 hover:bg-[var(--primary)] hover:text-white border border-slate-100 text-slate-600 px-3 py-2 rounded-none text-[9px] font-black uppercase tracking-widest transition-all">
                                    <span x-text="action.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Toggle Button (Sharp) -->
                <button @click="open = !open" 
                        :class="open ? 'bg-slate-900' : 'bg-[var(--primary)]'"
                        class="w-12 h-12 sm:w-16 sm:h-16 rounded-none shadow-2xl flex items-center justify-center text-white transition-all transform hover:scale-110 active:scale-95 border-none group">
                    <i class="fas fa-comment-dots text-xl sm:text-2xl transition-transform" :class="open ? 'rotate-90 scale-0 opacity-0' : 'rotate-0 scale-100 opacity-100'"></i>
                    <i class="fas fa-times text-xl sm:text-2xl absolute transition-transform" :class="open ? 'rotate-0 scale-100 opacity-100' : '-rotate-90 scale-0 opacity-0'"></i>
                </button>
            </div>

            <!-- Premium Search Overlay (Alpine.js) -->
            <div x-show="showSearch" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 backdrop-blur-0"
                 x-transition:enter-end="opacity-100 backdrop-blur-md"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 backdrop-blur-md"
                 x-transition:leave-end="opacity-0 backdrop-blur-0"
                 class="fixed inset-0 z-[200] flex flex-col bg-slate-900/95 p-6 sm:p-20"
                 style="display: none;"
                 @keydown.window.escape="showSearch = false">
                
                <div class="flex justify-end mb-10">
                    <button @click="showSearch = false" class="text-white/50 hover:text-white transition-colors group">
                        <i class="fas fa-times text-2xl sm:text-4xl group-hover:rotate-90 transition-transform duration-300"></i>
                    </button>
                </div>

                <div class="flex-1 flex flex-col items-center justify-start mt-20">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.5em] text-[var(--primary)] mb-8 animate-bounce">Que cherchez-vous ?</h2>
                    <form action="{{ route('shop.search') }}" method="GET" class="w-full max-w-4xl relative">
                        <input type="text" name="query" autofocus
                               placeholder="Saisissez un produit, une catégorie..."
                               class="w-full bg-transparent border-0 border-b-2 border-white/10 py-8 px-4 text-3xl sm:text-6xl font-black text-white focus:ring-0 focus:border-[var(--primary)] transition-all placeholder:text-white/10 uppercase tracking-tighter">
                        <button type="submit" class="absolute right-4 bottom-8 text-white/20 hover:text-[var(--primary)] transition-colors">
                            <i class="fas fa-arrow-right text-3xl sm:text-5xl"></i>
                        </button>
                    </form>

                    <div class="mt-16 flex flex-wrap justify-center gap-4 sm:gap-8 animate-fade-in">
                        <p class="w-full text-center text-white/30 text-[9px] font-black uppercase tracking-widest mb-4">Recherches Populaires</p>
                        @foreach(['Poulet', 'Boeuf', 'Gaine', 'Miel', 'Poussins'] as $tag)
                            <a href="{{ route('shop.search', ['query' => $tag]) }}" class="px-6 py-3 bg-white/5 hover:bg-[var(--primary)] text-white/50 hover:text-white border border-white/10 text-xs font-black uppercase tracking-widest transition-all">
                                {{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="py-10 text-center">
                    <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em]">THIOTTY ENTERPRISE INDUSTRY &copy; {{ date('Y') }}</p>
                </div>
            </div>

            <!-- INDUSTRIAL PREMIUM FOOTER -->
            <footer class="bg-slate-900 pt-24 pb-12 text-white border-t-8 border-[var(--primary)]">
                <div class="container-custom">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-24">
                        <!-- About -->
                        <div class="space-y-8">
                            <h4 class="text-3xl font-black tracking-tighter uppercase leading-none">THIOTTY<span class="text-[var(--primary)]">.</span></h4>
                            <p class="text-slate-400 font-medium leading-relaxed text-sm">
                                {{ __('messages.hero_text') }}
                            </p>
                            <div class="flex items-center gap-4">
                                <a href="#" class="w-10 h-10 bg-white/5 flex items-center justify-center hover:bg-[var(--primary)] transition-all"><i class="fab fa-facebook-f text-xs"></i></a>
                                <a href="#" class="w-10 h-10 bg-white/5 flex items-center justify-center hover:bg-[var(--primary)] transition-all"><i class="fab fa-instagram text-xs"></i></a>
                                <a href="#" class="w-10 h-10 bg-white/5 flex items-center justify-center hover:bg-[var(--primary)] transition-all"><i class="fab fa-linkedin-in text-xs"></i></a>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-[var(--primary)] mb-8">{{ __('messages.our_universes') }}</h4>
                            <ul class="space-y-4">
                                @foreach(\App\Models\Category::take(5)->get() as $cat)
                                    <li><a href="{{ route('shop.category', $cat->slug) }}" class="text-slate-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">{{ $cat->display_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Shop Info -->
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-[var(--primary)] mb-8">{{ __('messages.assistance') }}</h4>
                            <ul class="space-y-4">
                                <li><a href="{{ route('shop.index') }}" class="text-slate-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">{{ __('messages.shop') }}</a></li>
                                <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">{{ __('messages.track_order') }}</a></li>
                                <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">Contact Pro</a></li>
                                <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">FAQ</a></li>
                            </ul>
                        </div>

                        <!-- Contact -->
                        <div class="bg-white/5 p-8 border-l border-white/10">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-[var(--primary)] mb-8">CONTACT</h4>
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <i class="fas fa-location-dot text-[var(--secondary)] mt-1"></i>
                                    <p class="text-xs font-bold text-slate-400 leading-relaxed uppercase tracking-widest">Dakar, Senegal <br> Zone Industrielle</p>
                                </div>
                                <div class="flex items-start gap-4">
                                    <i class="fas fa-phone text-[var(--secondary)] mt-1"></i>
                                    <p class="text-xs font-black text-white">+221 78 357 74 31</p>
                                </div>
                                <div class="flex items-start gap-4">
                                    <i class="fas fa-envelope text-[var(--secondary)] mt-1"></i>
                                    <p class="text-xs font-black text-white">contact@thiotty.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-center pt-12 border-t border-white/5 gap-6">
                        <p class="text-[9px] font-black uppercase tracking-[0.5em] text-slate-500">
                            © {{ date('Y') }} Thiotty Enterprise Industry. All Rights Reserved.
                        </p>
                        <div class="flex items-center gap-8 text-[9px] font-black uppercase tracking-widest text-slate-500">
                            <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                            <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
