<?php

namespace App\Http\Controllers;

use App\Models\Composition;
use App\Models\Joueur;
use App\Models\MatchGame;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
{
    $matchs = MatchGame::orderByDesc('date_match')->paginate(15);

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

        MatchGame::create($validated);

        return redirect()->route('matchs.index')
            ->with('success', 'Match créé avec succès.');
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
            ->with('success', 'Match mis a jour avec succès.');
    }

    public function destroy(MatchGame $match)
    {
        $match->delete();

        return redirect()->route('matchs.index')
            ->with('success', 'Match supprimé avec succès.');
    }

    /**
     * Formulaire de composition d'equipe pour un match donne.
     */
    public function composition(MatchGame $match)
    {
        $joueurs = Joueur::orderBy('nom')->get();
        $selectionnes = $match->compositions()->pluck('titulaire', 'joueur_id');

        return view('matchs.composition', compact('match', 'joueurs', 'selectionnes'));
    }

    /**
     * Enregistrement de la composition d'equipe.
     */
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

        // On repart de zero pour ce match
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

    /**
 * Liste des matchs a venir avec le statut de convocation
 * du joueur actuellement connecte.
 */
public function mesConvocations()
{
    $joueur = \App\Models\Joueur::where('user_id', auth()->id())->first();

    if (! $joueur) {
        return view('matchs.mes-convocations', ['convocations' => collect(), 'aFicheJoueur' => false]);
    }

    $convocations = MatchGame::where('statut', 'a_venir')
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