<?php

namespace App\Http\Controllers;

use App\Models\Composition;
use App\Models\Joueur;
use App\Models\MatchGame;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $matchs = MatchGame::query()
            ->where('categorie', 'senior')
            ->when($request->recherche, function ($query, $recherche) {
                $query->where('adversaire', 'like', "%{$recherche}%");
            })
            ->orderByDesc('date_match')
            ->paginate(15)
            ->withQueryString();

        return view('matchs.index', compact('matchs'));
    }

    public function create()
    {
        return view('matchs.create');
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

        $validated['categorie'] = 'senior';

        MatchGame::create($validated);

        return redirect()->route('matchs.index')
            ->with('success', 'Match cree avec succes.');
    }

    public function show(MatchGame $match)
    {
        $match->load(['compositions.joueur', 'statistiques.joueur']);

        return view('matchs.show', compact('match'));
    }

    public function edit(MatchGame $match)
    {
        return view('matchs.edit', compact('match'));
    }

    public function update(Request $request, MatchGame $match)
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

        $match->update($validated);

        return redirect()->route('matchs.index')
            ->with('success', 'Match mis a jour avec succes.');
    }

    public function destroy(MatchGame $match)
    {
        $match->delete();

        return redirect()->route('matchs.index')
            ->with('success', 'Match supprime avec succes.');
    }

    public function composition(MatchGame $match)
    {
        $joueurs = Joueur::where('categorie', 'senior')->orderBy('nom')->get();
        $selectionnes = $match->compositions()->pluck('titulaire', 'joueur_id');

        return view('matchs.composition', compact('match', 'joueurs', 'selectionnes'));
    }

    public function storeComposition(Request $request, MatchGame $match)
    {
        $validated = $request->validate([
            'joueurs' => 'array',
            'joueurs.*' => 'exists:joueurs,id',
            'titulaires' => 'array',
            'titulaires.*' => 'exists:joueurs,id',
        ]);

        $joueursSelectionnes = $validated['joueurs'] ?? [];
        $titulaires = $validated['titulaires'] ?? [];

        Composition::where('match_id', $match->id)->delete();

        foreach ($joueursSelectionnes as $joueurId) {
            Composition::create([
                'match_id' => $match->id,
                'joueur_id' => $joueurId,
                'titulaire' => in_array($joueurId, $titulaires),
            ]);
        }

        return redirect()->route('matchs.show', $match)
            ->with('success', 'Composition enregistree avec succes.');
    }

    public function mesConvocations()
    {
        $joueur = \App\Models\Joueur::where('user_id', auth()->id())->first();

        if (! $joueur) {
            return view('matchs.mes-convocations', ['convocations' => collect(), 'aFicheJoueur' => false]);
        }

        $convocations = MatchGame::where('statut', 'a_venir')
            ->where('categorie', $joueur->categorie)
            ->orderBy('date_match')
            ->get()
            ->map(function ($match) use ($joueur) {
                $composition = $match->compositions->firstWhere('joueur_id', $joueur->id);
                $match->statutConvocation = $composition
                    ? ($composition->titulaire ? 'titulaire' : 'remplacant')
                    : 'non_convoque';
                return $match;
            });

        return view('matchs.mes-convocations', ['convocations' => $convocations, 'aFicheJoueur' => true]);
    }
}