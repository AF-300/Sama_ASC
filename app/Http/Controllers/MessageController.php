<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Liste des conversations de l'utilisateur connecte,
     * avec le dernier message de chaque conversation.
     */
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

        return view('messages.index', compact('contacts', 'derniersMessages', 'nonLus'));
    }

    /**
     * Conversation avec un utilisateur donne.
     */
    public function show(User $user)
    {
        $userId = Auth::id();

        $messages = Message::where(function ($q) use ($userId, $user) {
                $q->where('expediteur_id', $userId)->where('destinataire_id', $user->id);
            })
            ->orWhere(function ($q) use ($userId, $user) {
                $q->where('expediteur_id', $user->id)->where('destinataire_id', $userId);
            })
            ->orderBy('created_at')
            ->get();

        // Marquer comme lus les messages recus de cet utilisateur
        Message::where('expediteur_id', $user->id)
            ->where('destinataire_id', $userId)
            ->where('lu', false)
            ->update(['lu' => true]);

        return view('messages.show', compact('messages', 'user'));
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'contenu' => 'required|string|max:2000',
        ]);

        Message::create([
            'expediteur_id' => Auth::id(),
            'destinataire_id' => $user->id,
            'contenu' => $validated['contenu'],
            'lu' => false,
        ]);

        return redirect()->route('messages.show', $user);
    }
}