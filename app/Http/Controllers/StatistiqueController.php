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

        return redirect()->route('matchs.show', $match)
            ->with('success', 'Statistiques enregistrées avec succès.');
    }

    /**
     * Classement des buteurs (visible par tous les roles connectes).
     */
    public function classement()
    {
        $buteurs = Joueur::withSum('statistiques as total_buts', 'buts')
            ->withSum('statistiques as total_passes', 'passes_decisives')
            ->withCount('matchsJoues')
            ->orderByDesc('total_buts')
            ->get()
            ->filter(fn ($j) => $j->total_buts > 0)
            ->values();

        return view('statistiques.classement', compact('buteurs'));
    }
}