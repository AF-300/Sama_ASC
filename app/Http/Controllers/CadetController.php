<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use Illuminate\Http\Request;

class CadetController extends Controller
{
    public function index(Request $request)
    {
        $joueurs = Joueur::query()
            ->where('categorie', 'cadet')
            ->when($request->recherche, function ($query, $recherche) {
                $query->where(function ($q) use ($recherche) {
                    $q->where('nom', 'like', "%{$recherche}%")
                        ->orWhere('prenom', 'like', "%{$recherche}%")
                        ->orWhere('quartier', 'like', "%{$recherche}%");
                });
            })
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();

        return view('cadets.index', compact('joueurs'));
    }

    public function create()
    {
        return view('cadets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'nullable|integer|min:5|max:60',
            'poste' => 'nullable|in:gardien,defenseur,milieu,attaquant',
            'numero_maillot' => 'nullable|integer|min:1|max:99',
            'quartier' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $validated['categorie'] = 'cadet';

        if ($request->hasFile('photo')) {
            $validated['photo'] = app(JoueurController::class)->compresserEtStockerPhoto($request->file('photo'));
        }

        Joueur::create($validated);

        return redirect()->route('cadets.index')
            ->with('success', 'Cadet ajoute avec succes.');
    }

    public function edit(Joueur $cadet)
    {
        return view('cadets.edit', ['joueur' => $cadet]);
    }

    public function update(Request $request, Joueur $cadet)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'nullable|integer|min:5|max:60',
            'poste' => 'nullable|in:gardien,defenseur,milieu,attaquant',
            'numero_maillot' => 'nullable|integer|min:1|max:99',
            'quartier' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = app(JoueurController::class)->compresserEtStockerPhoto($request->file('photo'));
        }

        $cadet->update($validated);

        return redirect()->route('cadets.index')
            ->with('success', 'Cadet mis a jour avec succes.');
    }

    public function destroy(Joueur $cadet)
    {
        $cadet->delete();

        return redirect()->route('cadets.index')
            ->with('success', 'Cadet supprime avec succes.');
    }
}