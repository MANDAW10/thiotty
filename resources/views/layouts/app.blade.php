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
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Theme Initialization Script -->
    <script>
        (function() {
            const theme = localStorage.getItem('lahad-theme') || 'light';
            let accent = localStorage.getItem('lahad-accent') || '#FF5722';
            let accentRGB = localStorage.getItem('lahad-accent-rgb') || '255, 87, 34';
            
            // Migration for old primary color to new vibrant one
            if (accent === '#E65100') {
                accent = '#FF5722';
                accentRGB = '255, 87, 34';
                localStorage.setItem('lahad-accent', accent);
                localStorage.setItem('lahad-accent-rgb', accentRGB);
            }
            
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
            
            document.documentElement.style.setProperty('--primary', accent);
            document.documentElement.style.setProperty('--shadow-color', accentRGB);
        })();
    </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                                @if($alert->type == 'info') bg-blue-600 @elseif($alert->type == 'warning') bg-amber-500 @else bg-green-600 @endif">
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

        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Chatbot Component -->
            <div x-data="{ 
                open: false, 
                messages: [
                    { role: 'bot', text: '{{ addslashes(__('messages.assistant_greeting')) }}' }
                ],
                quickActions: [
                    { label: '📦 {{ addslashes(__('messages.track_order')) }}', action: 'track' },
                    { label: '🐔 {{ addslashes(__('messages.our_products')) }}', action: 'products' },
                    { label: '📞 {{ addslashes(__('messages.talk_to_agent')) }}', action: 'whatsapp' }
                ],
                handleAction(action) {
                    if (action === 'track') {
                        this.messages.push({ role: 'user', text: '{{ addslashes(__('messages.track_order')) }}' });
                        setTimeout(() => {
                            this.messages.push({ role: 'bot', text: '{{ addslashes(__('messages.track_order_response') ?? 'Pour suivre votre commande, merci de vous connecter à votre compte.') }}' });
                        }, 500);
                    } else if (action === 'products') {
                        window.location.href = '{{ route('shop.index') }}';
                    } else if (action === 'whatsapp') {
                        window.open('https://wa.me/221773004050', '_blank');
                    }
                }
            }" class="fixed bottom-4 right-4 sm:bottom-8 sm:right-8 z-50">
                
                <!-- Chat Window -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-10"
                     class="absolute bottom-16 sm:bottom-20 right-0 w-[calc(100vw-2rem)] sm:w-[350px] bg-white rounded-[32px] shadow-2xl border border-slate-100 overflow-hidden flex flex-col max-h-[70vh] sm:max-h-[500px]"
                     style="display: none;">
                    
                    <!-- Header -->
                    <div class="bg-primary p-5 sm:p-6 text-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/20 rounded-lg sm:rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-robot text-base sm:text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-xs sm:text-sm uppercase tracking-wider">{{ __('messages.assistant_name') }}</h3>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    <span class="text-[9px] sm:text-[10px] font-bold text-white/80">{{ __('messages.assistant_online') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-4 bg-slate-50/50 custom-scrollbar">
                        <template x-for="msg in messages">
                            <div :class="msg.role === 'bot' ? 'flex justify-start' : 'flex justify-end'">
                                <div :class="msg.role === 'bot' ? 'bg-white text-slate-800 rounded-2xl rounded-tl-none shadow-sm border border-slate-100' : 'bg-primary text-white rounded-2xl rounded-tr-none shadow-md'" 
                                     class="max-w-[85%] p-3 text-xs font-bold leading-relaxed"
                                     x-text="msg.text">
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Actions -->
                    <div class="p-4 bg-white border-t border-slate-50 space-y-2">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2">{{ __('messages.quick_actions') }}</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="action in quickActions">
                                <button @click="handleAction(action.action)" 
                                        class="bg-slate-50 hover:bg-primary/5 hover:text-primary border border-slate-100 text-slate-600 px-3 py-2 rounded-xl text-[9px] sm:text-[10px] font-black transition-all">
                                    <span x-text="action.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Toggle Button -->
                <button @click="open = !open" 
                        :class="open ? 'bg-slate-900 border-slate-800' : 'bg-primary border-primary'"
                        class="w-12 h-12 sm:w-16 sm:h-16 rounded-[18px] sm:rounded-[24px] shadow-2xl flex items-center justify-center text-white transition-all transform hover:scale-110 active:scale-95 border-[3px] sm:border-4 group">
                    <i class="fas fa-comment-dots text-xl sm:text-2xl transition-transform" :class="open ? 'rotate-90 scale-0 opacity-0' : 'rotate-0 scale-100 opacity-100'"></i>
                    <i class="fas fa-times text-xl sm:text-2xl absolute transition-transform" :class="open ? 'rotate-0 scale-100 opacity-100' : '-rotate-90 scale-0 opacity-0'"></i>
                    
                    <div x-show="!open" class="hidden sm:block absolute right-full mr-4 bg-white px-4 py-2 rounded-xl shadow-xl border border-slate-50 text-slate-800 text-xs font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-all pointer-events-none">
                        {{ __('messages.need_help') }}
                    </div>
                </button>
            </div>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-100 py-12 mt-24">
                <div class="container-custom">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                        <p class="text-sm text-slate-500">
                            © {{ date('Y') }} Lahad Enterprise — {{ __('messages.footer_text') }}
                        </p>
                        <div class="flex items-center gap-6">
                            <a href="#" class="text-slate-400 hover:text-primary transition-colors"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-slate-400 hover:text-primary transition-colors"><i class="fab fa-instagram"></i></a>
                            <a href="https://wa.me/221773004050" class="text-slate-400 hover:text-primary transition-colors"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
