<?php

namespace App\Http\Controllers;

use App\Models\Contributeur;
use App\Models\Cotisation;
use Illuminate\Http\Request;

class CotisationController extends Controller
{
    public function index()
    {
        $cotisations = Cotisation::with('contributeur')->orderByDesc('created_at')->paginate(15);

        return view('cotisations.index', compact('cotisations'));
    }

    public function create()
    {
        $contributeurs = Contributeur::orderBy('nom')->get();

        return view('cotisations.create', compact('contributeurs'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'contributeur_id' => 'nullable|exists:contributeurs,id',
        'nouveau_prenom' => 'nullable|string|max:255',
        'nouveau_nom' => 'nullable|string|max:255',
        'nouveau_quartier' => 'nullable|string|max:255',
        'montant' => 'required|numeric|min:0',
        'date_paiement' => 'nullable|date',
        'periode' => 'required|string|max:20',
        'statut' => 'required|in:payé,en_attente,en_retard',
    ]);

    // Si un nouveau contributeur est renseigne, on le cree d'abord
    if (empty($validated['contributeur_id'])) {
        $request->validate([
            'nouveau_prenom' => 'required|string|max:255',
            'nouveau_nom' => 'required|string|max:255',
            'nouveau_quartier' => 'required|string|max:255',
        ]);

        $contributeur = \App\Models\Contributeur::create([
            'prenom' => $validated['nouveau_prenom'],
            'nom' => $validated['nouveau_nom'],
            'quartier' => $validated['nouveau_quartier'],
        ]);

        $validated['contributeur_id'] = $contributeur->id;
    }

    Cotisation::create([
        'contributeur_id' => $validated['contributeur_id'],
        'montant' => $validated['montant'],
        'date_paiement' => $validated['date_paiement'] ?? null,
        'periode' => $validated['periode'],
        'statut' => $validated['statut'],
    ]);

    return redirect()->route('cotisations.index')
        ->with('success', 'Cotisation enregistrée avec succès.');
}

    public function edit(Cotisation $cotisation)
    {
        $contributeurs = Contributeur::orderBy('nom')->get();

        return view('cotisations.edit', compact('cotisation', 'contributeurs'));
    }

    public function update(Request $request, Cotisation $cotisation)
    {
        $validated = $request->validate([
            'contributeur_id' => 'required|exists:contributeurs,id',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'nullable|date',
            'periode' => 'required|string|max:20',
            'statut' => 'required|in:paye,en_attente,en_retard',
        ]);

        $cotisation->update($validated);

        return redirect()->route('cotisations.index')
            ->with('success', 'Cotisation mise a jour avec succès.');
    }

    public function destroy(Cotisation $cotisation)
    {
        $cotisation->delete();

        return redirect()->route('cotisations.index')
            ->with('success', 'Cotisation supprimée avec succès.');
    }
}