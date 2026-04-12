<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord utilisateur
     * Redirige automatiquement vers le bon endroit selon le type d'utilisateur
     */
    public function index(): View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Récupérer les statistiques
        $totalOrders = $user->orders()->count();
        $totalWishlists = $user->wishlists()->count();
        $totalReviews = $user->reviews()->count();
        $totalPayments = $user->payments()->count();

        // Dernières commandes
        $recentOrders = $user->orders()->latest()->take(5)->get();

        // Derniers favoris
        $recentWishlists = $user->wishlists()->latest()->take(8)->with('product')->get();

        return view('dashboard', compact(
            'user',
            'totalOrders',
            'totalWishlists',
            'totalReviews',
            'totalPayments',
            'recentOrders',
            'recentWishlists'
        ));
    }
}
