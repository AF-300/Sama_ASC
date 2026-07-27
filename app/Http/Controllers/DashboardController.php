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

        $data = [
            'nombreJoueurs' => Joueur::count(),
            'prochainsMatchs' => MatchGame::where('statut', 'a_venir')
                ->orderBy('date_match')
                ->limit(3)
                ->get(),
            'dernieresAnnonces' => Annonce::orderByDesc('date_publication')->limit(3)->get(),
        ];

        if ($user->hasAnyRole(['admin_asc', 'coach'])) {
            $data['nombreMatchsJoues'] = MatchGame::where('statut', 'joue')->count();
            $data['victoires'] = MatchGame::where('statut', 'joue')
                ->whereColumn('score_asc', '>', 'score_adversaire')
                ->count();
        }

        if ($user->hasRole('admin_asc')) {
            $data['totalCotisations'] = Cotisation::where('statut', 'paye')->sum('montant');
            $data['totalDepenses'] = Depense::sum('montant');
            $data['solde'] = $data['totalCotisations'] - $data['totalDepenses'];
            $data['cotisationsEnRetard'] = Cotisation::where('statut', 'en_retard')->count();
        }

        return view('dashboard', $data);
    }
}