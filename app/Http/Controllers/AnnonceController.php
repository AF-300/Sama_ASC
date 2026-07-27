<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::with('auteur')->orderByDesc('date_publication')->paginate(10);

        return view('annonces.index', compact('annonces'));
    }

    public function create()
    {
        return view('annonces.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'contenu' => 'required|string',
    ]);

    $validated['auteur_id'] = auth()->id();
    $validated['date_publication'] = now();

    $annonce = Annonce::create($validated);

    // On notifie tous les utilisateurs sauf l'auteur de l'annonce
    $destinataires = \App\Models\User::where('id', '!=', auth()->id())->get();
    \Illuminate\Support\Facades\Notification::send(
        $destinataires,
        new \App\Notifications\NouvelleAnnonceNotification($annonce)
    );

    return redirect()->route('annonces.index')
        ->with('success', 'Annonce publiée avec succès.');
}

    public function show(Annonce $annonce)
    {
        $annonce->load('auteur');

        return view('annonces.show', compact('annonce'));
    }

    public function edit(Annonce $annonce)
    {
        return view('annonces.edit', compact('annonce'));
    }

    public function update(Request $request, Annonce $annonce)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        $annonce->update($validated);

        return redirect()->route('annonces.index')
            ->with('success', 'Annonce mise a jour avec succès.');
    }

    public function destroy(Annonce $annonce)
    {
        $annonce->delete();

        return redirect()->route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}