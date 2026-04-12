<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12">
                <div class="flex justify-between items-start md:items-center gap-6 md:gap-0 flex-col md:flex-row">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter mb-2">
                            Bienvenue, <span class="text-primary">{{ explode(' ', Auth::user()->name)[0] }}</span>!
                        </h1>
                        <p class="text-slate-600">Gérez votre compte Thiotty et vos commandes</p>
                    </div>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-lg font-black text-sm transition-colors">
                        <i class="fas fa-shopping-bag"></i> Continuer les achats
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <!-- Commandes -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xl">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <span class="text-xs font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                            @choice('commande|commandes', $totalOrders)
                        </span>
                    </div>
                    <p class="text-slate-600 text-sm font-medium">Commandes totales</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $totalOrders }}</p>
                </div>

                <!-- Favoris -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-600 text-xl">
                            <i class="fas fa-heart"></i>
                        </div>
                        <span class="text-xs font-black text-red-600 bg-red-50 px-3 py-1 rounded-full">
                            @choice('favori|favoris', $totalWishlists)
                        </span>
                    </div>
                    <p class="text-slate-600 text-sm font-medium">Articles favoris</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $totalWishlists }}</p>
                </div>

                <!-- Avis -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-600 text-xl">
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs font-black text-yellow-600 bg-yellow-50 px-3 py-1 rounded-full">
                            @choice('avis|avis', $totalReviews)
                        </span>
                    </div>
                    <p class="text-slate-600 text-sm font-medium">Avis publiés</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $totalReviews }}</p>
                </div>

                <!-- Paiements -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 text-xl">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <span class="text-xs font-black text-green-600 bg-green-50 px-3 py-1 rounded-full">
                            @choice('paiement|paiements', $totalPayments)
                        </span>
                    </div>
                    <p class="text-slate-600 text-sm font-medium">Transactions</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $totalPayments }}</p>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Commandes Récentes (2 colonnes) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h2 class="text-lg font-black text-slate-900">Commandes Récentes</h2>
                            <a href="{{ route('orders.index') }}" class="text-sm text-primary hover:underline font-black">
                                Voir tout →
                            </a>
                        </div>

                        @if($recentOrders->count() > 0)
                            <div class="divide-y divide-slate-100">
                                @foreach($recentOrders as $order)
                                    <div class="p-6 hover:bg-slate-50 transition-colors">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h3 class="font-black text-slate-900">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
                                                <p class="text-xs text-slate-500 mt-1">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                                            </div>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black
                                                @if($order->status === 'delivered') bg-green-100 text-green-700
                                                @elseif($order->status === 'shipping') bg-blue-100 text-blue-700
                                                @elseif($order->status === 'preparing') bg-yellow-100 text-yellow-700
                                                @else bg-slate-100 text-slate-700
                                                @endif">
                                                {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-slate-600 mb-3">{{ $order->items->count() }} article(s) - {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</p>
                                        <a href="{{ route('orders.show', $order) }}" class="text-primary hover:underline text-sm font-black">
                                            Détails de la commande →
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <i class="fas fa-shopping-bag text-4xl text-slate-300 mb-4 block"></i>
                                <p class="text-slate-600 mb-4">Aucune commande pour le moment</p>
                                <a href="{{ route('shop.index') }}" class="inline-block bg-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-primary/90 transition-colors">
                                    Commencer les achats
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar Infos -->
                <div class="space-y-6">
                    <!-- Profil -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-black text-slate-900 mb-4">Infos Profil</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-slate-500 font-black uppercase tracking-widest">Nom</p>
                                <p class="text-slate-900 font-bold">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-black uppercase tracking-widest">Email</p>
                                <p class="text-slate-900 font-bold break-all">{{ Auth::user()->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-black uppercase tracking-widest">Téléphone</p>
                                <p class="text-slate-900 font-bold">+221 {{ Auth::user()->phone }}</p>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="mt-6 w-full block text-center bg-slate-100 hover:bg-slate-200 text-slate-900 px-4 py-2 rounded-lg font-black text-sm transition-colors">
                            Modifier mon profil
                        </a>
                    </div>

                    <!-- Liens Rapides -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-black text-slate-900 mb-4">Accès Rapide</h3>
                        <div class="space-y-3">
                            <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                <i class="fas fa-heart text-red-600"></i>
                                <span class="font-bold text-slate-900">Mes Favoris</span>
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                                <span class="font-bold text-slate-900">Toutes Commandes</span>
                            </a>
                            <a href="{{ route('payment.history') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                <i class="fas fa-credit-card text-green-600"></i>
                                <span class="font-bold text-slate-900">Historique Paiement</span>
                            </a>
                            <a href="{{ route('cart.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                <i class="fas fa-shopping-bag text-purple-600"></i>
                                <span class="font-bold text-slate-900">Mon Panier</span>
                            </a>
                        </div>
                    </div>

                    <!-- Besoin d'Aide? -->
                    <div class="bg-gradient-to-br from-primary/10 to-primary/5 rounded-2xl p-6 border border-primary/20">
                        <h3 class="text-lg font-black text-slate-900 mb-3">Besoin d'aide?</h3>
                        <p class="text-sm text-slate-600 mb-4">Pour toute question ou problème, contactez-nous.</p>
                        <a href="{{ route('contact') }}" class="inline-block bg-primary text-white px-4 py-2 rounded-lg font-black text-sm hover:bg-primary/90 transition-colors">
                            Contacter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
