<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Cotisation;
use App\Models\Depense;
use App\Models\Joueur;
use App\Models\MatchGame;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $monJoueur = null;
    if ($user->hasAnyRole(['joueur', 'cadet'])) {
        $monJoueur = \App\Models\Joueur::where('user_id', $user->id)->first();
    }

    // Determine la/les categorie(s) pertinente(s) pour cet utilisateur
    if ($user->hasRole('cadet')) {
        $categories = ['cadet'];
    } elseif ($user->hasRole('joueur')) {
        $categories = ['senior'];
    } else {
        // admin, coach, supporter voient tout
        $categories = ['senior', 'cadet'];
    }

    $data = [
        'monJoueur' => $monJoueur,
        'nombreJoueurs' => Joueur::whereIn('categorie', $categories)->count(),
        'prochainsMatchs' => MatchGame::where('statut', 'a_venir')
            ->whereIn('categorie', $categories)
            ->orderBy('date_match')
            ->limit(3)
            ->get(),
        'dernieresAnnonces' => Annonce::orderByDesc('date_publication')->limit(8)->get(),
    ];

    if ($user->hasAnyRole(['admin_asc', 'coach'])) {
        $data['nombreMatchsJoues'] = MatchGame::where('statut', 'joue')->whereIn('categorie', $categories)->count();
        $data['victoires'] = MatchGame::where('statut', 'joue')
            ->whereIn('categorie', $categories)
            ->whereColumn('score_asc', '>', 'score_adversaire')
            ->count();
    }

    if ($user->hasRole('admin_asc')) {
        $data['totalCotisations'] = Cotisation::where('statut', 'paye')->sum('montant');
        $data['totalDepenses'] = Depense::sum('montant');
        $data['solde'] = $data['totalCotisations'] - $data['totalDepenses'];
        $data['cotisationsEnRetard'] = Cotisation::where('statut', 'en_retard')->count();

        $data['cotisationsParMois'] = Cotisation::where('statut', 'paye')
            ->where('date_paiement', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(fn ($c) => $c->date_paiement->format('Y-m'))
            ->map(fn ($groupe) => $groupe->sum('montant'));

        $data['depensesParCategorie'] = Depense::selectRaw('categorie, SUM(montant) as total')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');
    }

    return view('dashboard', $data);
}
}