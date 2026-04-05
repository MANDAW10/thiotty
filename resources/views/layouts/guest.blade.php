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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-[#FDFDFD]">
        <!-- Session Notifications -->
        @if (session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="fixed top-8 left-1/2 -translate-x-1/2 z-[200] w-full max-w-sm px-6">
                <div class="bg-white border-2 border-primary/20 shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-[24px] p-4 flex items-center gap-4">
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-0.5">Notification</p>
                        <p class="text-xs font-bold text-slate-900">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-slate-300 hover:text-slate-600 transition-colors">
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
