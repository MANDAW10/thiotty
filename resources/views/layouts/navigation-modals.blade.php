<!-- Auth Drawers (Login & Register) - Standardized Width (max-w-md) -->

<!-- Login Drawer -->
<div x-show="showLogin" 
     class="fixed inset-0 z-[1500]" 
     style="display: none;">
    
    <!-- Backdrop -->
    <div x-show="showLogin"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="showLogin = false"
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    <!-- Drawer Content -->
    <div x-show="showLogin"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col border-l-4 border-[#206B13]"
         x-data="{ showPass: false, loading: false }">
        
        <!-- Header -->
        <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h2 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">{{ __('messages.welcome_back') }}</h2>
            <button @click="showLogin = false" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Form Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 md:p-12">
            <div class="mb-10">
                <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tighter mb-2">Connexion</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">Accédez à votre espace professionnel Thiotty Enterprise.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-8" @submit="loading = true">
                @csrf
                
                <div class="space-y-3">
                    <label for="drawer_login_email" class="block text-[10px] font-black uppercase tracking-widest text-slate-500">{{ __('messages.email') }}</label>
                    <input id="drawer_login_email" name="email" type="email" 
                           class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 text-slate-900 focus:bg-white focus:border-[#206B13] focus:ring-0 transition-all font-bold text-sm" 
                           required autofocus placeholder="exemple@thiotty.com">
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <label for="drawer_login_password" class="block text-[10px] font-black uppercase tracking-widest text-slate-500">{{ __('messages.password') }}</label>
                    </div>
                    <div class="relative group">
                        <input id="drawer_login_password" name="password" :type="showPass ? 'text' : 'password'" 
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 pr-12 text-slate-900 focus:bg-white focus:border-[#206B13] focus:ring-0 transition-all font-bold text-sm" 
                               required placeholder="••••••••">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#206B13] transition-colors">
                            <i class="fas" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <button type="button" @click="showLogin = false; showForgot = true" class="text-[9px] font-black text-[#206B13] uppercase tracking-widest hover:underline mt-2 inline-block">{{ __('messages.forgot_password') }}</button>
                </div>

                <div class="flex items-center">
                    <input id="drawer_remember" name="remember" type="checkbox" class="w-4 h-4 text-[#206B13] border-slate-300 rounded-none focus:ring-0">
                    <label for="drawer_remember" class="ml-3 text-[10px] font-black text-slate-600 uppercase tracking-widest">Rester connecté</label>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-[#206B13] text-white font-black text-[11px] uppercase tracking-[0.2em] rounded-none hover:bg-slate-900 transition-all flex items-center justify-center gap-4 group" :disabled="loading">
                        <span x-show="!loading">{{ __('messages.login_btn') }}</span>
                        <i x-show="!loading" class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                        <span x-show="loading" class="flex items-center gap-2">
                            <i class="fas fa-circle-notch animate-spin"></i> Traitement...
                        </span>
                    </button>
                </div>
            </form>

            <div class="mt-12 pt-12 border-t border-slate-100 text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Nouveau sur Thiotty ?</p>
                <button type="button" @click="showLogin = false; showRegister = true" 
                        class="w-full py-4 border-2 border-slate-100 text-slate-900 font-black text-[10px] uppercase tracking-[0.2em] hover:border-[#206B13] hover:text-[#206B13] transition-all">
                    {{ __('messages.register_now') }}
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Register Drawer -->
<div x-show="showRegister" 
     class="fixed inset-0 z-[1500]" 
     style="display: none;">
    
    <!-- Backdrop -->
    <div x-show="showRegister"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="showRegister = false"
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    <!-- Drawer Content -->
    <div x-show="showRegister"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col border-l-4 border-[#206B13]"
         x-data="{ showPass: false, showConfirm: false, loading: false }">
        
        <!-- Header -->
        <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h2 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">{{ __('messages.register_title') }}</h2>
            <button @click="showRegister = false" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Form Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 md:p-12">
            <div class="mb-8">
                <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tighter mb-2">Inscription</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">Créez votre compte professionnel pour accéder à nos produits exclusifs.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6" @submit="loading = true">
                @csrf
                
                <div class="space-y-3">
                    <label for="drawer_reg_name" class="block text-[10px] font-black uppercase tracking-widest text-slate-500">{{ __('messages.full_name') }}</label>
                    <input id="drawer_reg_name" name="name" type="text" 
                           class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 text-slate-900 focus:bg-white focus:border-[#206B13] focus:ring-0 transition-all font-bold text-sm" 
                           required placeholder="M. Sidy Diop">
                </div>

                <div class="space-y-3">
                    <label for="drawer_reg_phone" class="block text-[10px] font-black uppercase tracking-widest text-slate-500">{{ __('messages.phone_number') }}</label>
                    <input id="drawer_reg_phone" name="phone" type="tel" x-on:input="formatPhone($event)" 
                           class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 text-slate-900 focus:bg-white focus:border-[#206B13] focus:ring-0 transition-all font-bold text-sm font-sans" 
                           required placeholder="7x xxx xx xx">
                </div>

                <div class="space-y-3">
                    <label for="drawer_reg_email" class="block text-[10px] font-black uppercase tracking-widest text-slate-500">E-mail</label>
                    <input id="drawer_reg_email" name="email" type="email" 
                           class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 text-slate-900 focus:bg-white focus:border-[#206B13] focus:ring-0 transition-all font-bold text-sm" 
                           required placeholder="contact@industrie.sn">
                </div>

                <div class="space-y-6">
                    <div class="space-y-3">
                        <label for="drawer_reg_password" class="block text-[10px] font-black uppercase tracking-widest text-slate-500">{{ __('messages.password') }}</label>
                        <div class="relative">
                            <input id="drawer_reg_password" name="password" :type="showPass ? 'text' : 'password'" 
                                   class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 text-slate-900 focus:bg-white focus:border-[#206B13] focus:ring-0 transition-all font-bold text-sm" 
                                   required placeholder="••••">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400">
                                <i class="fas text-xs" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label for="drawer_reg_confirm" class="block text-[10px] font-black uppercase tracking-widest text-slate-500">{{ __('messages.confirm_password') }}</label>
                        <div class="relative">
                            <input id="drawer_reg_confirm" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" 
                                   class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 text-slate-900 focus:bg-white focus:border-[#206B13] focus:ring-0 transition-all font-bold text-sm" 
                                   required placeholder="••••">
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400">
                                <i class="fas text-xs" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-[#206B13] text-white font-black text-[11px] uppercase tracking-[0.2em] rounded-none hover:bg-slate-900 transition-all flex items-center justify-center gap-4 group" :disabled="loading">
                        <span x-show="!loading">{{ __('messages.register_btn') }}</span>
                        <i x-show="!loading" class="fas fa-user-plus transition-transform group-hover:scale-110"></i>
                        <span x-show="loading" class="flex items-center gap-2">
                            <i class="fas fa-circle-notch animate-spin"></i> Création...
                        </span>
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Déjà membre ?</p>
                <button type="button" @click="showRegister = false; showLogin = true" 
                        class="text-[#206B13] font-black text-[10px] uppercase tracking-[0.2em] hover:underline">
                    Retour à la connexion
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Forgot Password Drawer -->
<div x-show="showForgot" 
     class="fixed inset-0 z-[1600]" 
     style="display: none;">
    
    <div x-show="showForgot" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="showForgot = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    <div x-show="showForgot" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         class="absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col border-l-4 border-amber-500">
        
        <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h2 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Récupération</h2>
            <button @click="showForgot = false" class="text-slate-400 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
        </div>

        <div class="p-8 md:p-12 overflow-y-auto custom-scrollbar">
            <div class="mb-10 text-center">
                <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-none flex items-center justify-center mx-auto mb-6 border border-amber-100">
                    <i class="fas fa-key text-2xl"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">{{ __('messages.forgot_text') }}</p>
            </div>

            @if (session('status'))
                <div class="mb-8 font-black text-xs text-green-600 bg-green-50 p-6 border-l-4 border-green-500">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify-identity') }}" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">E-mail de secours</label>
                    <input name="email" type="email" class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-0 transition-all font-bold text-sm" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Numéro de téléphone</label>
                    <input name="phone" type="tel" x-on:input="formatPhone($event)" class="w-full bg-slate-50 border-2 border-slate-100 rounded-none py-4 px-5 text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-0 transition-all font-bold text-sm font-sans" required>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-amber-500 text-white font-black text-[11px] uppercase tracking-[0.2em] hover:bg-slate-900 transition-all">
                        Vérifier mon identité
                    </button>
                </div>
            </form>

            <button type="button" @click="showForgot = false; showLogin = true" class="w-full mt-8 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-900 transition-colors">
                Retour à la connexion
            </button>
        </div>
    </div>
</div>


<!-- Profile Drawer -->
@auth
<div x-show="showProfile" 
     class="fixed inset-0 z-[1500]" 
     style="display: none;">
    
    <div x-show="showProfile" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="showProfile = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    <div x-show="showProfile" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         class="absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col border-l-4 border-[#206B13]">
        
        <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h2 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">Mon Profil</h2>
            <button @click="showProfile = false" class="text-slate-400 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 space-y-12">
            <!-- Info Section -->
            <div class="space-y-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-[#206B13]/10 text-[#206B13] flex items-center justify-center"><i class="fas fa-id-card"></i></div>
                    <h4 class="font-black text-[10px] uppercase tracking-widest text-slate-900">Informations de base</h4>
                </div>
                @include('profile.partials.update-profile-information-form', ['user' => Auth::user()])
            </div>

            <div class="h-[1px] bg-slate-100"></div>

            <!-- Password Section -->
            <div class="space-y-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-[#206B13]/10 text-[#206B13] flex items-center justify-center"><i class="fas fa-lock"></i></div>
                    <h4 class="font-black text-[10px] uppercase tracking-widest text-slate-900">Sécurité du compte</h4>
                </div>
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endauth
