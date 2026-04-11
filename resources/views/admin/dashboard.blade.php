<x-admin-layout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-1">Tableau de Bord</h1>
            <p class="text-[9px] md:text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Thiotty Enterprise — Administration</p>
        </div>
        <div class="flex flex-wrap w-full sm:w-auto gap-3">
            <a href="{{ route('admin.alerts.create') }}" class="btn-thiotty-outline w-full sm:w-auto py-3 px-6 text-xs text-center">
                <i class="fas fa-bullhorn mr-2"></i> Diffuser Alerte
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn-thiotty w-full sm:w-auto py-3 px-6 text-xs text-center">
                <i class="fas fa-plus mr-2"></i> Nouveau Produit
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10 md:mb-12">
        <div class="bg-white p-6 md:p-8 rounded-[28px] md:rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md group">
            <div class="w-12 h-12 bg-orange-50 text-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i class="fas fa-shopping-bag text-xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Commandes</p>
            <h3 class="text-3xl font-black text-slate-900">{{ $stats['total_orders'] }}</h3>
        </div>
        
        <div class="bg-white p-6 md:p-8 rounded-[28px] md:rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md group">
            <div class="w-12 h-12 bg-green-50 text-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i class="fas fa-coins text-xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Revenu Total</p>
            <h3 class="text-3xl font-black text-slate-900">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} <small class="text-xs uppercase opacity-30">CFA</small></h3>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-[28px] md:rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md group">
            <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i class="fas fa-box-open text-xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Produits</p>
            <h3 class="text-3xl font-black text-slate-900">{{ $stats['total_products'] }}</h3>
        </div>

        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md group">
            <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Clients</p>
            <h3 class="text-3xl font-black text-slate-900">{{ $stats['total_users'] }}</h3>
        </div>
    </div>

    <!-- Quick Actions / Bottom Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-8 md:p-10 rounded-[40px] border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-3">
                <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                Dernières Commandes
            </h3>
            <div class="space-y-4">
                <p class="text-xs text-slate-400 font-bold italic">Consultez l'onglet Commandes pour gérer les livraisons récentes.</p>
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-xs font-black text-primary uppercase tracking-widest hover:translate-x-2 transition-transform">
                    Voir toutes les commandes <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <div class="bg-slate-900 p-8 md:p-10 rounded-[40px] shadow-2xl shadow-primary/20 text-white">
            <h3 class="text-sm font-black text-primary uppercase tracking-widest mb-8">Support & Maintenance</h3>
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-life-ring"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Assistance Technique</p>
                        <p class="text-xs font-bold text-slate-400 mt-1">Contactez le support pour toute anomalie technique sur la plateforme.</p>
                    </div>
                </div>
                <div class="pt-4 border-t border-white/5">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Version de la plateforme</p>
                    <p class="text-xs font-black mt-2">Thiotty Enterprise v2.1.0 — <span class="text-green-500">Stable</span></p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
