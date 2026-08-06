<?php

namespace App\Http\Controllers;

use App\Models\Composition;
use App\Models\Joueur;
use App\Models\MatchGame;
use Illuminate\Http\Request;

class CadetMatchController extends Controller
{
    public function index(Request $request)
    {
        $matchs = MatchGame::query()
            ->where('categorie', 'cadet')
            ->when($request->recherche, function ($query, $recherche) {
                $query->where('adversaire', 'like', "%{$recherche}%");
            })
            ->orderByDesc('date_match')
            ->paginate(15)
            ->withQueryString();

        return view('matchs-cadets.index', compact('matchs'));
    }

    public function create()
    {
        return view('matchs-cadets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'adversaire' => 'required|string|max:255',
            'date_match' => 'required|date',
            'heure' => 'nullable',
            'lieu' => 'nullable|string|max:255',
            'statut' => 'required|in:a_venir,joue,annule',
        ]);

        $validated['categorie'] = 'cadet';

        MatchGame::create($validated);

        return redirect()->route('matchs-cadets.index')
            ->with('success', 'Match cree avec succes.');
    }

    public function show(MatchGame $matchesCadet)
    {
        $matchesCadet->load(['compositions.joueur', 'statistiques.joueur']);

        return view('matchs-cadets.show', ['match' => $matchesCadet]);
    }

    public function edit(MatchGame $matchesCadet)
    {
        return view('matchs-cadets.edit', ['match' => $matchesCadet]);
    }

    public function update(Request $request, MatchGame $matchesCadet)
    {
        $validated = $request->validate([
            'adversaire' => 'required|string|max:255',
            'date_match' => 'required|date',
            'heure' => 'nullable',
            'lieu' => 'nullable|string|max:255',
            'score_asc' => 'nullable|integer|min:0',
            'score_adversaire' => 'nullable|integer|min:0',
            'statut' => 'required|in:a_venir,joue,annule',
        ]);

        $matchesCadet->update($validated);

        return redirect()->route('matchs-cadets.index')
            ->with('success', 'Match mis a jour avec succes.');
    }

    public function destroy(MatchGame $matchesCadet)
    {
        $matchesCadet->delete();

        return redirect()->route('matchs-cadets.index')
            ->with('success', 'Match supprime avec succes.');
    }

    public function composition(MatchGame $matchesCadet)
    {
        $joueurs = Joueur::where('categorie', 'cadet')->orderBy('nom')->get();
        $selectionnes = $matchesCadet->compositions()->pluck('titulaire', 'joueur_id');

        return view('matchs-cadets.composition', ['match' => $matchesCadet, 'joueurs' => $joueurs, 'selectionnes' => $selectionnes]);
    }

    public function storeComposition(Request $request, MatchGame $matchesCadet)
    {
        $validated = $request->validate([
            'joueurs' => 'array',
            'joueurs.*' => 'exists:joueurs,id',
            'titulaires' => 'array',
            'titulaires.*' => 'exists:joueurs,id',
        ]);

        $joueursSelectionnes = $validated['joueurs'] ?? [];
        $titulaires = $validated['titulaires'] ?? [];

        Composition::where('match_id', $matchesCadet->id)->delete();

        foreach ($joueursSelectionnes as $joueurId) {
            Composition::create([
                'match_id' => $matchesCadet->id,
                'joueur_id' => $joueurId,
                'titulaire' => in_array($joueurId, $titulaires),
            ]);
        }

        return redirect()->route('matchs-cadets.show', $matchesCadet)
            ->with('success', 'Composition enregistree avec succes.');
    }
}