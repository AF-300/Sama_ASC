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
    $userId = Auth::id();

    $contacts = User::where('id', '!=', $userId)->orderBy('name')->get();

    $derniersMessages = Message::where('expediteur_id', $userId)
        ->orWhere('destinataire_id', $userId)
        ->orderByDesc('created_at')
        ->get()
        ->groupBy(function ($message) use ($userId) {
            return $message->expediteur_id === $userId
                ? $message->destinataire_id
                : $message->expediteur_id;
        })
        ->map(fn ($messages) => $messages->first());

    $nonLus = Message::where('destinataire_id', $userId)
        ->where('lu', false)
        ->get()
        ->groupBy('expediteur_id')
        ->map->count();

    // Trie les contacts : d'abord ceux avec messages non lus,
    // puis par date du dernier message (plus recent en premier),
    // puis les contacts sans aucun message a la fin (par nom)
    $contacts = $contacts->sort(function ($a, $b) use ($nonLus, $derniersMessages) {
        $aNonLu = $nonLus->get($a->id, 0);
        $bNonLu = $nonLus->get($b->id, 0);

        // Priorite 1 : les non lus passent devant
        if (($aNonLu > 0) !== ($bNonLu > 0)) {
            return $bNonLu <=> $aNonLu;
        }

        $aDernier = $derniersMessages->get($a->id);
        $bDernier = $derniersMessages->get($b->id);

        // Priorite 2 : le message le plus recent en premier
        if ($aDernier && $bDernier) {
            return $bDernier->created_at <=> $aDernier->created_at;
        }

        // Les contacts avec au moins un message passent avant ceux sans aucun message
        if ($aDernier || $bDernier) {
            return $aDernier ? -1 : 1;
        }

        // Sinon, tri alphabetique par defaut
        return strcmp($a->name, $b->name);
    })->values();

    return view('messages.index', compact('contacts', 'derniersMessages', 'nonLus'));
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
            'statut' => 'required|in:a_venir,joué,annulé',
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