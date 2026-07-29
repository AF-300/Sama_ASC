<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class JoueurController extends Controller
{
    public function index()
    {
        $joueurs = Joueur::orderBy('nom')->paginate(15);

        return view('joueurs.index', compact('joueurs'));
    }

    public function create()
{
    $utilisateursDisponibles = \App\Models\User::role('joueur')
        ->whereDoesntHave('joueur')
        ->get();

    return view('joueurs.create', compact('utilisateursDisponibles'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'nullable|integer|min:5|max:60',
            'poste' => 'nullable|in:gardien,defenseur,milieu,attaquant',
            'numero_maillot' => 'nullable|integer|min:1|max:99',
            'quartier' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
    $validated['photo'] = $this->compresserEtStockerPhoto($request->file('photo'));
}
        Joueur::create($validated);

        return redirect()->route('joueurs.index')
            ->with('success', 'Joueur ajouté avec succès.');
    }

    public function show(Joueur $joueur)
    {
        $joueur->load(['statistiques.match', 'presences']);

        return view('joueurs.show', compact('joueur'));
    }

    public function edit(Joueur $joueur)
{
    $utilisateursDisponibles = \App\Models\User::role('joueur')
        ->where(function ($query) use ($joueur) {
            $query->whereDoesntHave('joueur')
                ->orWhere('id', $joueur->user_id);
        })
        ->get();

    return view('joueurs.edit', compact('joueur', 'utilisateursDisponibles'));
}
    public function update(Request $request, Joueur $joueur)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'nullable|integer|min:5|max:60',
            'poste' => 'nullable|in:gardien,defenseur,milieu,attaquant',
            'numero_maillot' => 'nullable|integer|min:1|max:99',
            'quartier' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
    $validated['photo'] = $this->compresserEtStockerPhoto($request->file('photo'));
}

        $joueur->update($validated);

        return redirect()->route('joueurs.index')
            ->with('success', 'Joueur mis a jour avec succès.');
    }

    public function destroy(Joueur $joueur)
    {
        $joueur->delete();

        return redirect()->route('joueurs.index')
            ->with('success', 'Joueur supprimé avec succès.');
    }

   private function compresserEtStockerPhoto($fichier): string
{
    $manager = new ImageManager(new Driver());
    $image = $manager->read($fichier);
    $image->scaleDown(width: 500);

    // Encode en JPEG compresse en memoire (pas de sauvegarde locale)
    $imageEncodee = (string) $image->toJpeg(75);

    $resultat = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::uploadApi()->upload(
    'data:image/jpeg;base64,'.base64_encode($imageEncodee),
    ['folder' => 'sama-asc/joueurs']
)['secure_url'];
return $resultat;
}
}