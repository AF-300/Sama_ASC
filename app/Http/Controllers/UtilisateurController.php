<?php

namespace App\Http\Controllers;

use App\Models\User;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs = User::with('roles')->orderBy('name')->get();

        return view('utilisateurs.index', compact('utilisateurs'));
    }

    public function destroy(User $user)
    {
        // Empeche de se supprimer soi-meme par erreur
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tu ne peux pas supprimer ton propre compte.');
        }

        $user->delete();

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur supprime avec succes.');
    }
}