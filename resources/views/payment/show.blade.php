<x-app-layout>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Paiement sécurisé</h1>
            <p class="text-slate-600">Commande #{{ $order->id }} • {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y à H:i') }}</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 font-bold flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-xl hover:scale-110 transition-transform"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Payment Methods -->
            <div class="lg:col-span-2">
                @php
                    $payment = \App\Models\Payment::where('order_id', $order->id)->first();
                    $callbackUrl    = route('payment.callback.wave', $payment ?? 1);
                    $waveBaseUrl    = 'https://pay.wave.com/m/M_sn_EyJvzOI5RXM7/c/sn/?amount=' . round($order->total_amount);
                    $wavePayUrl     = $waveBaseUrl . '&success_url=' . urlencode($callbackUrl);
                    $qrApiUrl       = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&margin=4&ecc=L&data=' . urlencode($waveBaseUrl);
                @endphp
                @if($order->payment_method === 'wave' || $order->payment_method === 'mobile')
                    <!-- Interface Wave simplifiée -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100 mb-6 text-center">
                        <div class="w-24 h-24 mx-auto flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-20 h-20 shadow-sm rounded-2xl">
                                <rect width="100" height="100" rx="20" fill="#1ebff6"/>
                                <path d="M 50 15 C 33 15, 29 42, 29 65 C 29 82, 40 85, 50 85 C 60 85, 71 82, 71 65 C 71 42, 67 15, 50 15 Z" fill="#111827"/>
                                <path d="M 50 42 C 40 42, 35 55, 35 68 C 35 78, 41 82, 50 82 C 59 82, 65 78, 65 68 C 65 55, 60 42, 50 42 Z" fill="#ffffff"/>
                                <circle cx="42" cy="32" r="3.5" fill="#ffffff"/>
                                <circle cx="58" cy="32" r="3.5" fill="#ffffff"/>
                                <path d="M 45 38 L 55 38 L 50 43 Z" fill="#f59e0b"/>
                                <path d="M 33 42 C 20 42, 18 30, 18 30 C 18 30, 25 55, 32 60 Z" fill="#111827"/>
                                <ellipse cx="38" cy="85" rx="8" ry="4" fill="#f59e0b"/>
                                <ellipse cx="62" cy="85" rx="8" ry="4" fill="#f59e0b"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 mb-2">Paiement via Wave</h2>
                        <p class="text-slate-400 text-sm mb-8">Après votre paiement Wave, vous recevrez automatiquement un <strong class="text-slate-700">code de confirmation par email</strong>.</p>

                        <!-- MOBILE -->
                        <div class="block md:hidden">
                            <a href="{{ $wavePayUrl }}"
                               style="background-color: #1ebff6; color: white;"
                               class="inline-flex items-center justify-center gap-3 w-full max-w-xs mx-auto font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-xl active:scale-95 text-lg mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-7 h-7 bg-white rounded-lg p-0.5">
                                    <rect width="100" height="100" rx="20" fill="#1ebff6"/>
                                    <path d="M 50 15 C 33 15, 29 42, 29 65 C 29 82, 40 85, 50 85 C 60 85, 71 82, 71 65 C 71 42, 67 15, 50 15 Z" fill="#111827"/>
                                    <path d="M 50 42 C 40 42, 35 55, 35 68 C 35 78, 41 82, 50 82 C 59 82, 65 78, 65 68 C 65 55, 60 42, 50 42 Z" fill="#ffffff"/>
                                    <circle cx="42" cy="32" r="3.5" fill="#ffffff"/>
                                    <circle cx="58" cy="32" r="3.5" fill="#ffffff"/>
                                    <path d="M 45 38 L 55 38 L 50 43 Z" fill="#f59e0b"/>
                                    <path d="M 33 42 C 20 42, 18 30, 18 30 C 18 30, 25 55, 32 60 Z" fill="#111827"/>
                                    <ellipse cx="38" cy="85" rx="8" ry="4" fill="#f59e0b"/>
                                    <ellipse cx="62" cy="85" rx="8" ry="4" fill="#f59e0b"/>
                                </svg>
                                Payer {{ number_format($order->total_amount, 0, ',', ' ') }} CFA
                            </a>

                            <!-- Bouton "J'ai payé" -->
                            <form action="{{ route('payment.process', $order) }}" method="POST" class="mt-8" id="waveFormMobile">
                                @csrf
                                <input type="hidden" name="payment_method" value="wave">
                                
                                <div class="mb-4 text-left border-t border-slate-100 pt-6">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-1 text-center">Code de transaction SMS</label>
                                    <p class="text-[10px] text-slate-400 mb-3 text-center">Prouvez votre paiement en collant l'ID reçu par SMS de Wave.</p>
                                    <input type="text" name="wave_transaction_id" id="waveCodeMobile" required placeholder="Ex: CI2409ABCD..."
                                        class="w-full max-w-xs block mx-auto px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-[#1ebff6] outline-none transition text-sm font-bold text-slate-900 text-center uppercase">
                                </div>

                                <button type="submit" id="waveBtnMobile" disabled
                                    class="w-full max-w-xs mx-auto flex flex-col items-center justify-center py-3 px-6 bg-slate-300 text-white font-black rounded-2xl shadow-none transition-all active:scale-95 duration-200 cursor-not-allowed">
                                    <span class="flex items-center gap-2"><i class="fas fa-check-circle"></i> Valider ce code</span>
                                    <span class="text-[9px] font-normal opacity-90 uppercase mt-1 tracking-wider" id="btnHelpTextMobile">Numéro Wave manquant</span>
                                </button>
                            </form>
                        </div>

                        <!-- DESKTOP -->
                        <div class="hidden md:block">
                            <p class="text-slate-500 mb-4 text-sm">Scannez ce QR code avec votre téléphone pour payer, ou utilisez le bouton ci-dessous.</p>
                            <div class="mx-auto mb-4" style="max-width: 150px;">
                                <div class="bg-white rounded-xl p-2 border-2 border-slate-200">
                                    <img src="{{ $qrApiUrl }}" alt="QR Code Wave" class="w-full h-auto" style="width: 150px; height: 150px; display: block;">
                                </div>
                            </div>
                            <div class="text-2xl font-black text-slate-900 mb-5">
                                {{ number_format($order->total_amount, 0, ',', ' ') }} <span class="text-base text-slate-400">CFA</span>
                            </div>

                            <!-- Bouton desktop Wave -->
                            <a href="{{ $wavePayUrl }}" target="_blank"
                               style="background-color: #1ebff6; color: white;"
                               class="inline-flex items-center justify-center gap-3 font-black py-4 px-8 rounded-2xl transition-all duration-300 shadow-xl mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-6 h-6 bg-white rounded-lg p-0.5">
                                    <rect width="100" height="100" rx="20" fill="#1ebff6"/>
                                    <path d="M 50 15 C 33 15, 29 42, 29 65 C 29 82, 40 85, 50 85 C 60 85, 71 82, 71 65 C 71 42, 67 15, 50 15 Z" fill="#111827"/>
                                    <path d="M 50 42 C 40 42, 35 55, 35 68 C 35 78, 41 82, 50 82 C 59 82, 65 78, 65 68 C 65 55, 60 42, 50 42 Z" fill="#ffffff"/>
                                    <circle cx="42" cy="32" r="3.5" fill="#ffffff"/>
                                    <circle cx="58" cy="32" r="3.5" fill="#ffffff"/>
                                    <path d="M 45 38 L 55 38 L 50 43 Z" fill="#f59e0b"/>
                                    <path d="M 33 42 C 20 42, 18 30, 18 30 C 18 30, 25 55, 32 60 Z" fill="#111827"/>
                                    <ellipse cx="38" cy="85" rx="8" ry="4" fill="#f59e0b"/>
                                    <ellipse cx="62" cy="85" rx="8" ry="4" fill="#f59e0b"/>
                                </svg>
                                Ouvrir Wave pour payer
                            </a>

                            <!-- Bouton "J'ai payé" desktop -->
                            <form action="{{ route('payment.process', $order) }}" method="POST" id="waveFormDesktop" class="mt-8">
                                @csrf
                                <input type="hidden" name="payment_method" value="wave">
                                
                                <div class="mb-4 max-w-sm mx-auto text-left border-t border-slate-100 pt-6">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-1 text-center">Code de transaction Wave</label>
                                    <p class="text-[10px] text-slate-400 mb-3 text-center">Le code secret de transaction que vous avez reçu par SMS.</p>
                                    <input type="text" name="wave_transaction_id" id="waveCodeDesktop" required placeholder="Collez l'ID reçu par SMS"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-[#1ebff6] outline-none transition text-sm font-bold text-slate-900 text-center uppercase">
                                </div>

                                <button type="submit" id="waveBtnDesktop" disabled
                                    class="flex flex-col items-center justify-center mx-auto py-3 px-10 bg-slate-300 text-white font-black rounded-2xl shadow-none transition-all duration-200 cursor-not-allowed">
                                    <span class="flex items-center gap-2 text-base"><i class="fas fa-check-circle"></i> Valider la transaction</span>
                                    <span class="text-[10px] font-normal opacity-90 uppercase mt-1 tracking-wider" id="btnHelpTextDesktop">Numéro Wave manquant</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Anciennes commandes (ex. orange_money) : plus de flux automatisé ici --}}
                    <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 p-8 mb-6">
                        <h2 class="text-lg font-semibold text-slate-900 mb-4">Paiement non pris en charge sur cette page</h2>
                        <p class="text-slate-600 mb-6">Ce mode de paiement n’est plus géré en ligne pour les nouvelles commandes. Pour cette commande, contactez-nous sur WhatsApp avec votre référence <strong>#{{ str_pad((string) $order->id, 5, '0', STR_PAD_LEFT) }}</strong>.</p>
                        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center justify-center w-full sm:w-auto bg-slate-900 text-white font-bold py-3 px-6 rounded-xl">Voir ma commande</a>
                    </div>
                @endif
            </div>

            <!-- Right: Delivery Info -->
            <div class="lg:col-span-1">
                <!-- Delivery Information -->
                <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 p-8 mb-6">
                    <h3 class="text-lg font-black uppercase tracking-widest text-slate-900 mb-6">Livraison</h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Nom du client</p>
                            <p class="font-black text-slate-900">{{ $order->customer_name }}</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Téléphone</p>
                            <p class="font-black text-slate-900">{{ $order->customer_phone }}</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Adresse</p>
                            <p class="font-medium text-slate-700 text-sm leading-relaxed">{{ $order->customer_address }}</p>
                        </div>
                        <div class="p-4 bg-[var(--primary)]/5 rounded-2xl border border-[var(--primary)]/10">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[var(--primary)] mb-1">Zone de livraison</p>
                            <p class="font-black text-slate-900">{{ $order->deliveryZone->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Récapitulatif -->
                <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 p-8">
                    <h3 class="text-lg font-black uppercase tracking-widest text-slate-900 mb-6">Récapitulatif</h3>
                    <div class="space-y-3 mb-6 pb-6 border-b border-slate-100">
                        <div class="flex justify-between text-sm font-bold text-slate-500">
                            <span>Sous-total</span>
                            <span class="text-slate-900">{{ number_format($order->total_amount - $order->delivery_fee, 0, ',', ' ') }} CFA</span>
                        </div>
                        @if($order->delivery_fee > 0)
                            <div class="flex justify-between text-sm font-bold text-slate-500">
                                <span>Livraison</span>
                                <span class="text-slate-900">{{ number_format($order->delivery_fee, 0, ',', ' ') }} CFA</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-400">Total</span>
                        <span class="text-2xl font-black text-[var(--primary)]">{{ number_format($order->total_amount, 0, ',', ' ') }} CFA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logique Mobile
        const inputMob = document.getElementById('waveCodeMobile');
        const btnMob = document.getElementById('waveBtnMobile');
        const textMob = document.getElementById('btnHelpTextMobile');

        // Logique Desktop
        const inputDesk = document.getElementById('waveCodeDesktop');
        const btnDesk = document.getElementById('waveBtnDesktop');
        const textDesk = document.getElementById('btnHelpTextDesktop');

        function validateInput(input, btn, text) {
            if (!input || !btn) return;
            input.addEventListener('input', function(e) {
                let val = e.target.value.trim();
                // Check if it's long enough to be a Wave ID
                if (val.length >= 5) {
                    btn.disabled = false;
                    btn.classList.remove('bg-slate-300', 'shadow-none', 'cursor-not-allowed');
                    btn.classList.add('bg-[#206B13]', 'shadow-lg', 'hover:bg-slate-900');
                    text.textContent = "Poursuivre par email";
                } else {
                    btn.disabled = true;
                    btn.classList.add('bg-slate-300', 'shadow-none', 'cursor-not-allowed');
                    btn.classList.remove('bg-[#206B13]', 'shadow-lg', 'hover:bg-slate-900');
                    text.textContent = "Numéro Wave manquant";
                }
            });
        }

        validateInput(inputMob, btnMob, textMob);
        validateInput(inputDesk, btnDesk, textDesk);
    });
</script>
</x-app-layout>
