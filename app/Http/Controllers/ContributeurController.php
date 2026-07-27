<?php

namespace App\Http\Controllers;

use App\Models\Contributeur;
use Illuminate\Http\Request;

class ContributeurController extends Controller
{
    public function index()
    {
        $contributeurs = Contributeur::orderBy('quartier')->orderBy('nom')->paginate(15);

        return view('contributeurs.index', compact('contributeurs'));
    }

    public function create()
    {
        return view('contributeurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'quartier' => 'required|string|max:255',
        ]);

        Contributeur::create($validated);

        return redirect()->route('contributeurs.index')
            ->with('success', 'Contributeur ajouté avec succès.');
    }

    public function edit(Contributeur $contributeur)
    {
        return view('contributeurs.edit', compact('contributeur'));
    }

    public function update(Request $request, Contributeur $contributeur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'quartier' => 'required|string|max:255',
        ]);

        $contributeur->update($validated);

        return redirect()->route('contributeurs.index')
            ->with('success', 'Contributeur mis a jour avec succès.');
    }

    public function destroy(Contributeur $contributeur)
    {
        $contributeur->delete();

        return redirect()->route('contributeurs.index')
            ->with('success', 'Contributeur supprimé avec succès.');
    }
}