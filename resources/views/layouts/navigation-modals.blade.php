<!-- Login Modal -->
<div x-show="showLogin" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
     style="display: none;"
     @click.self="showLogin = false">
    
    <div x-show="showLogin"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="bg-white w-full max-w-sm rounded-none p-8 md:p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar"
         x-data="{ showPass: false, loading: false }">
        
        <button @click="showLogin = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>

        <div class="mb-10 text-center">
            <div class="w-12 h-12 bg-primary/10 text-primary rounded-none flex items-center justify-center mx-auto mb-4 border border-primary/20">
                <i class="fas fa-user text-xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-1 uppercase tracking-tight">Connexion</h2>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Accédez à votre compte <span class="text-primary font-black">Thiotty</span></p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6" @submit="loading = true">
            @csrf
            <div class="space-y-1.5">
                <label for="modal_email" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.email') }}</label>
                <input id="modal_email" name="email" type="email" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-none py-4 px-6 font-bold text-slate-900 text-base md:text-sm focus:ring-1 focus:ring-primary focus:border-primary transition-all placeholder:text-slate-300" 
                       placeholder="votre@email.com"
                       required autofocus shadow-none>
            </div>

            <div class="space-y-1.5">
                <div class="flex justify-between items-center ml-1">
                    <label for="modal_password" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">{{ __('messages.password') }}</label>
                    <button type="button" @click="showLogin = false; showForgot = true" class="text-[9px] font-black text-primary uppercase tracking-widest hover:underline">{{ __('messages.forgot_password') }}</button>
                </div>
                <div class="relative group">
                    <input id="modal_password" name="password" :type="showPass ? 'text' : 'password'" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-none py-4 pl-6 pr-12 font-bold text-slate-900 text-base md:text-sm focus:ring-1 focus:ring-primary focus:border-primary transition-all placeholder:text-slate-300" 
                           placeholder="••••••••"
                           required>
                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-primary transition-colors">
                        <i class="fas" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-thiotty w-full py-4 text-base shadow-none text-white transition-all" :disabled="loading">
                    <span x-show="!loading">{{ __('messages.login_btn') }}</span>
                    <span x-show="loading" class="flex items-center justify-center gap-3" style="display: none;">
                        <i class="fas fa-circle-notch animate-spin"></i>
                    </span>
                </button>
            </div>

            <div class="text-center pt-2">
                <p class="text-[11px] font-bold text-slate-400">
                    {{ __('messages.no_account') }} 
                    <button type="button" @click="showLogin = false; showRegister = true" class="text-primary hover:underline ml-1 font-black">{{ __('messages.register_now') }}</button>
                </p>
            </div>
        </form>
    </div>
</div>

<!-- Register Modal -->
<div x-show="showRegister" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
     style="display: none;"
     @click.self="showRegister = false">
    
    <div x-show="showRegister"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="bg-white w-full max-w-md rounded-none p-8 md:p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar"
         x-data="{ showPass: false, showConfirm: false, loading: false }">
        
        <button @click="showRegister = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>

        <div class="mb-8 text-center">
            <div class="w-12 h-12 bg-primary/10 text-primary rounded-none flex items-center justify-center mx-auto mb-4 border border-primary/20">
                <i class="fas fa-user-plus text-xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-1 uppercase tracking-tight">Inscription</h2>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('messages.join_family') }}</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4" @submit="loading = true">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="modal_reg_name" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.full_name') }}</label>
                    <input id="modal_reg_name" name="name" type="text" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 px-5 font-bold text-slate-900 text-base md:text-xs focus:ring-1 focus:ring-primary transition-all placeholder:text-slate-300" 
                           required placeholder="{{ __('messages.full_name') }}" value="{{ old('name') }}">
                </div>
                <div class="space-y-1.5">
                    <label for="modal_reg_phone" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.phone_number') }}</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-[10px] font-black text-primary bg-primary/10 px-1.5 py-0.5 rounded-none border border-primary/20">+221</span>
                        <input id="modal_reg_phone" name="phone" type="tel" x-on:input="formatPhone($event)" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 pl-14 pr-4 font-bold text-slate-900 text-base md:text-xs focus:ring-1 focus:ring-primary transition-all font-sans placeholder:text-slate-300" 
                               required placeholder="7x xxx xx" value="{{ old('phone') }}">
                    </div>
                </div>
            </div>
            
            <div class="space-y-1.5">
                <label for="modal_reg_email" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email</label>
                <input id="modal_reg_email" name="email" type="email" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 px-5 font-bold text-slate-900 text-base md:text-xs focus:ring-1 focus:ring-primary transition-all placeholder:text-slate-300" 
                       required placeholder="votre@email.com" value="{{ old('email') }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="modal_reg_password" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.password') }}</label>
                    <div class="relative group">
                        <input id="modal_reg_password" name="password" :type="showPass ? 'text' : 'password'" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 pl-5 pr-10 font-bold text-slate-900 text-base md:text-xs focus:ring-1 focus:ring-primary transition-all placeholder:text-slate-300" 
                               required placeholder="••••">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-primary transition-colors">
                            <i class="fas text-[10px]" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label for="modal_reg_confirm" class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">{{ __('messages.confirm_password') }}</label>
                    <div class="relative group">
                        <input id="modal_reg_confirm" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 pl-5 pr-10 font-bold text-slate-900 text-base md:text-xs focus:ring-1 focus:ring-primary transition-all placeholder:text-slate-300" 
                               required placeholder="••••">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-primary transition-colors">
                            <i class="fas text-[10px]" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-thiotty w-full py-4 text-sm shadow-none text-white relative overflow-hidden group" :disabled="loading">
                    <span x-show="!loading">{{ __('messages.continue') }}</span>
                    <span x-show="loading" class="flex items-center justify-center gap-3" style="display: none;">
                        <i class="fas fa-circle-notch animate-spin"></i>
                    </span>
                </button>
            </div>

            <div class="text-center pt-2">
                <p class="text-[11px] font-bold text-slate-400">
                    {{ __('messages.already_registered') }} 
                    <button type="button" @click="showRegister = false; showLogin = true" class="text-primary hover:underline ml-1 font-black">{{ __('messages.login') }}</button>
                </p>
            </div>
        </form>
    </div>
</div>

<!-- Forgot Password Modal -->
<div x-show="showForgot" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
     style="display: none;"
     @click.self="showForgot = false">
    
    <div x-show="showForgot"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="bg-white w-full max-w-md rounded-none p-8 md:p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar">
        
        <button @click="showForgot = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>

        <div class="mb-6 text-center">
            <div class="w-12 h-12 bg-primary/10 text-primary rounded-none flex items-center justify-center mx-auto mb-4 border border-primary/20">
                <i class="fas fa-shield-halved text-xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-1 uppercase tracking-tight">Récupération</h2>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-8">{{ __('messages.forgot_text') }}</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-bold text-sm text-green-600 bg-green-50 p-4 rounded-none border border-green-100">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.verify-identity') }}" class="space-y-4">
            @csrf
            <div class="space-y-1">
                <label for="forgot_email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{ __('messages.email') }}</label>
                <input id="forgot_email" name="email" type="email" class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 px-6 font-bold text-slate-900 focus:ring-1 focus:ring-primary transition-all" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="space-y-1">
                <label for="forgot_phone" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{ __('messages.phone_number') }}</label>
                <input id="forgot_phone" name="phone" type="tel" x-on:input="formatPhone($event)" class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 px-6 font-bold text-slate-900 focus:ring-1 focus:ring-primary transition-all font-sans" required placeholder="7x xxx xx xx">
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <x-input-error :messages="$errors->get('forgot_identity')" class="mt-1" />

            <div class="pt-4">
                <button type="submit" class="btn-thiotty w-full py-4 text-base shadow-none text-white">{{ __('messages.verify_identity') }}</button>
            </div>
        </form>

        <div class="text-center pt-2">
            <button type="button" @click="showForgot = false; showLogin = true" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-colors">
                {{ __('messages.back_to_login') }}
            </button>
        </div>
    </div>
</div>

<!-- Reset Password Modal (Step 2) -->
<div x-show="showResetForm" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
     style="display: none;"
     @click.self="showResetForm = false">
    
    <div x-show="showResetForm"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="bg-white w-full max-w-md rounded-none p-8 md:p-10 shadow-2xl relative">
        
        <button @click="showResetForm = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>

        <div class="mb-6 text-center">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-none flex items-center justify-center mx-auto mb-4 border border-green-200">
                <i class="fas fa-key-skeleton text-xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-1 uppercase tracking-tight">{{ __('messages.reset_password') }}</h2>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-8">{{ __('messages.reset_text') }}</p>
        </div>

        @if (session('password_reset_success'))
            <div class="mb-4 text-center">
                <div class="text-green-600 font-bold mb-4">
                    <i class="fas fa-check-circle text-4xl mb-2 block"></i>
                    {{ session('password_reset_success') }}
                </div>
                <button @click="showResetForm = false; showLogin = true" class="btn-thiotty w-full py-4 text-white">Se connecter maintenant</button>
            </div>
        @else
            <form method="POST" action="{{ route('password.custom-reset') }}" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="reset_password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nouveau mot de passe</label>
                    <input id="reset_password" name="password" type="password" class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 px-6 font-bold text-slate-900 focus:ring-1 focus:ring-primary transition-all" required autofocus>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="space-y-1">
                    <label for="reset_password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Confirmer mot de passe</label>
                    <input id="reset_password_confirmation" name="password_confirmation" type="password" class="w-full bg-slate-50 border border-slate-200 rounded-none py-3 px-6 font-bold text-slate-900 focus:ring-1 focus:ring-primary transition-all font-sans" required>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <x-input-error :messages="$errors->get('reset_error')" class="mt-1" />

                <div class="pt-4">
                    <button type="submit" class="btn-thiotty w-full py-4 text-base shadow-none text-white">{{ __('messages.reset_btn') }}</button>
                </div>
            </form>
        @endif
    </div>
</div>

<!-- Profile Modal -->
@auth
<div x-show="showProfile" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
     style="display: none;"
     @click.self="showProfile = false">
    
    <div x-show="showProfile"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="bg-white w-full max-w-2xl rounded-none p-6 md:p-8 shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
        
        <button @click="showProfile = false" class="absolute top-6 right-6 text-slate-300 hover:text-primary transition-colors z-10">
            <i class="fas fa-times text-xl"></i>
        </button>

        <div class="mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-none flex items-center justify-center border border-primary/20">
                    <i class="fas fa-user-gear text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">{{ __('messages.profile') }}</h2>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-8 pb-4">
            <!-- Info Section -->
            <div class="bg-slate-50 rounded-none p-6 border border-slate-200">
                @include('profile.partials.update-profile-information-form', ['user' => Auth::user()])
            </div>

            <!-- Password Section -->
            <div class="bg-slate-50 rounded-none p-6 border border-slate-200">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endauth
