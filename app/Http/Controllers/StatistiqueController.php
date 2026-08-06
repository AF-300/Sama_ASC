<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\MatchGame;
use App\Models\StatistiqueJoueur;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    /**
     * Formulaire de saisie des stats pour un match donne.
     * On ne propose que les joueurs convoques (presents dans compositions).
     */
    public function edit(MatchGame $match)
    {
        $match->load('compositions.joueur');

        $statsExistantes = StatistiqueJoueur::where('match_id', $match->id)
            ->get()
            ->keyBy('joueur_id');

        return view('statistiques.edit', compact('match', 'statsExistantes'));
    }

    public function update(Request $request, MatchGame $match)
    {
        $validated = $request->validate([
            'stats' => 'array',
            'stats.*.buts' => 'nullable|integer|min:0',
            'stats.*.passes_decisives' => 'nullable|integer|min:0',
            'stats.*.cartons_jaunes' => 'nullable|integer|min:0',
            'stats.*.cartons_rouges' => 'nullable|integer|min:0',
        ]);

        foreach ($validated['stats'] ?? [] as $joueurId => $stats) {
            StatistiqueJoueur::updateOrCreate(
                ['match_id' => $match->id, 'joueur_id' => $joueurId],
                [
                    'buts' => $stats['buts'] ?? 0,
                    'passes_decisives' => $stats['passes_decisives'] ?? 0,
                    'cartons_jaunes' => $stats['cartons_jaunes'] ?? 0,
                    'cartons_rouges' => $stats['cartons_rouges'] ?? 0,
                ]
            );
        }

       $route = $match->categorie === 'cadet' ? 'matchs-cadets.show' : 'matchs.show';

return redirect()->route($route, $match)
    ->with('success', 'Statistiques enregistrees avec succes.');
    }

    /**
     * Classement des buteurs (visible par tous les roles connectes).
     */
   public function classement()
{
    $prochainMatchSenior = \App\Models\MatchGame::where('statut', 'a_venir')
        ->where('categorie', 'senior')
        ->orderBy('date_match')
        ->with('compositions.joueur')
        ->first();

    $prochainMatchCadet = \App\Models\MatchGame::where('statut', 'a_venir')
        ->where('categorie', 'cadet')
        ->orderBy('date_match')
        ->with('compositions.joueur')
        ->first();

    return view('statistiques.classement', compact('prochainMatchSenior', 'prochainMatchCadet'));
}
}