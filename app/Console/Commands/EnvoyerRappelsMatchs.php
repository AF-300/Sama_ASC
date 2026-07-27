<?php

namespace App\Console\Commands;

use App\Models\MatchGame;
use App\Models\User;
use App\Notifications\RappelMatchNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class EnvoyerRappelsMatchs extends Command
{
    protected $signature = 'app:envoyer-rappels-matchs';
    protected $description = 'Envoie un rappel pour les matchs prevus demain';

    public function handle(): void
    {
        $matchsDemain = MatchGame::where('statut', 'a_venir')
            ->whereDate('date_match', now()->addDay()->toDateString())
            ->get();

        if ($matchsDemain->isEmpty()) {
            $this->info('Aucun match prevu demain.');
            return;
        }

        $utilisateurs = User::all();

        foreach ($matchsDemain as $match) {
            Notification::send($utilisateurs, new RappelMatchNotification($match));
            $this->info('Rappel envoye pour le match vs '.$match->adversaire);
        }
    }
}