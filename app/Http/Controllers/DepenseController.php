<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function index()
    {
        $depenses = Depense::orderByDesc('date_depense')->paginate(15);

        return view('depenses.index', compact('depenses'));
    }

    public function create()
    {
        return view('depenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'categorie' => 'required|in:materiel,coach,transport,autre',
            'date_depense' => 'required|date',
        ]);

        Depense::create($validated);

        return redirect()->route('depenses.index')
            ->with('success', 'Depense enregistrée avec succès.');
    }

    public function edit(Depense $depense)
    {
        return view('depenses.edit', compact('depense'));
    }

    public function update(Request $request, Depense $depense)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'categorie' => 'required|in:materiel,coach,transport,autre',
            'date_depense' => 'required|date',
        ]);

        $depense->update($validated);

        return redirect()->route('depenses.index')
            ->with('success', 'Depense mise a jour avec succès.');
    }

    public function destroy(Depense $depense)
    {
        $depense->delete();

        return redirect()->route('depenses.index')
            ->with('success', 'Depense supprimée avec succès.');
    }
}