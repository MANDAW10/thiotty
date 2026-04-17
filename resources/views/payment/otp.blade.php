<x-app-layout>
<div class="min-h-screen bg-slate-50 py-12 px-4 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100 text-center">
        
        <div class="w-20 h-20 bg-green-50 rounded-full mx-auto flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>

        <h2 class="text-2xl font-black text-slate-900 mb-2">Vérification de sécurité</h2>
        <p class="text-slate-500 text-sm mb-6">Pour valider définitivement votre paiement, veuillez entrer le code à 6 chiffres que nous venons de vous envoyer par SMS.</p>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-bold mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('payment.otp.verify', $order) }}" method="POST">
            @csrf
            <div class="mb-6">
                <input type="text" name="otp_code" placeholder="Entrez le code" required maxlength="6"
                       class="w-full text-center text-3xl tracking-widest font-black text-slate-800 bg-slate-50 border-2 border-slate-200 rounded-xl py-4 focus:outline-none focus:border-[var(--primary)] focus:ring-0 transition-colors">
            </div>

            <button type="submit" class="w-full bg-[var(--primary)] hover:opacity-90 text-white font-black py-4 rounded-xl transition-all shadow-lg active:scale-95">
                Vérifier mon code
            </button>
        </form>

        <p class="text-xs text-slate-400 mt-6">
            Si vous n'avez pas reçu le SMS, <a href="#" class="text-[var(--primary)] font-bold">cliquez ici pour renvoyer</a>.
        </p>

    </div>
</div>
</x-app-layout>
