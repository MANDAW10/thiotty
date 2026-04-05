<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-[#FDFDFD] overflow-x-hidden">
        <!-- Session Notifications -->
        @if (session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 8000)"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-[-20px] scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed top-8 left-1/2 -translate-x-1/2 z-[300] w-[calc(100%-2rem)] max-w-md">
                <div class="bg-white/80 backdrop-blur-xl border border-emerald-500/20 shadow-[0_32px_64px_-16px_rgba(16,185,129,0.2)] rounded-[28px] p-5 flex items-center gap-5 overflow-hidden relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shrink-0 shadow-lg shadow-emerald-500/20 rotate-3 group-hover:rotate-0 transition-transform">
                        <i class="fas fa-check text-lg"></i>
                    </div>
                    <div class="flex-1 relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mb-1">Félicitations</p>
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-300 hover:text-slate-600 hover:bg-slate-100 transition-all">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
        @endif

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/">
                    <x-application-logo class="w-auto h-12" />
                </a>
            </div>

            <div class="w-[calc(100%-2rem)] sm:max-w-md bg-white shadow-[0_32px_64px_-16px_rgba(0,0,0,0.08)] overflow-hidden rounded-[32px] sm:rounded-[40px] border border-slate-50 p-6 sm:p-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
