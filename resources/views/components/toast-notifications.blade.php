@php
    $allErrors = $errors->all();
    $success = session('success');
    $status = session('status');
@endphp

<div x-data="{ 
    toasts: [],
    addToast(message, type = 'success') {
        const id = Date.now();
        this.toasts.push({ id, message, type, show: false });
        setTimeout(() => {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index !== -1) this.toasts[index].show = true;
        }, 10);
        
        // Auto-remove after 8 seconds
        setTimeout(() => this.removeToast(id), 8000);
    },
    removeToast(id) {
        const index = this.toasts.findIndex(t => t.id === id);
        if (index !== -1) {
            this.toasts[index].show = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 300);
        }
    },
    init() {
        @if($success)
            this.addToast('{{ addslashes($success) }}', 'success');
        @endif

        @if($status && is_string($status))
            this.addToast('{{ addslashes($status) }}', 'info');
        @endif

        @if($errors->any())
            @foreach($allErrors as $error)
                this.addToast('{{ addslashes($error) }}', 'error');
            @endforeach
        @endif
    }
}" @add-toast.window="addToast($event.detail.message, $event.detail.type)"
class="fixed top-auto bottom-6 left-4 right-4 md:top-6 md:bottom-auto md:right-6 md:left-auto z-[9999] flex flex-col gap-4 w-auto md:w-full md:max-w-[380px] pointer-events-none transition-all duration-500">
    
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-x-12 scale-90"
             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-x-0 scale-100"
             x-transition:leave-end="opacity-0 translate-x-12 scale-90"
             class="pointer-events-auto bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/50 dark:border-slate-700/50 shadow-2xl rounded-[24px] p-4 flex items-center gap-4 group relative overflow-hidden">
            
            <!-- Type-specific Icon & Background Glow -->
            <div :class="{
                'bg-emerald-500 shadow-emerald-500/20': toast.type === 'success',
                'bg-primary shadow-primary/20': toast.type === 'error',
                'bg-blue-500 shadow-blue-500/20': toast.type === 'info'
            }" class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 text-white shadow-lg transition-transform group-hover:scale-110">
                <i x-show="toast.type === 'success'" class="fas fa-check text-sm"></i>
                <i x-show="toast.type === 'error'" class="fas fa-exclamation-triangle text-sm"></i>
                <i x-show="toast.type === 'info'" class="fas fa-info-circle text-sm"></i>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <p :class="{
                    'text-emerald-600': toast.type === 'success',
                    'text-primary': toast.type === 'error',
                    'text-blue-600': toast.type === 'info'
                }" class="text-[9px] font-black uppercase tracking-[0.2em] mb-0.5" x-text="toast.type === 'error' ? 'Attention' : 'Notification'"></p>
                <p class="text-xs font-bold text-slate-800 dark:text-slate-100 leading-tight break-words" x-text="toast.message"></p>
            </div>

            <!-- Close Action -->
            <button @click="removeToast(toast.id)" class="w-7 h-7 rounded-full flex items-center justify-center text-slate-300 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                <i class="fas fa-times text-[10px]"></i>
            </button>

            <!-- Life Progress Bar -->
            <div class="absolute bottom-0 left-0 h-0.5 bg-current opacity-20 animation-life w-full group-hover:opacity-40" 
                 :class="{
                    'text-emerald-500': toast.type === 'success',
                    'text-primary': toast.type === 'error',
                    'text-blue-500': toast.type === 'info'
                 }"></div>
        </div>
    </template>
</div>

<style>
    .animation-life {
        animation: life 8s linear forwards;
    }
    @keyframes life {
        from { width: 100%; }
        to { width: 0%; }
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
    }
</style>
