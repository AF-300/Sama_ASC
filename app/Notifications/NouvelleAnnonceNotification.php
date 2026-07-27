<?php

namespace App\Notifications;

use App\Models\Annonce;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NouvelleAnnonceNotification extends Notification
{
    use Queueable;

    public function __construct(public Annonce $annonce)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'annonce',
            'annonce_id' => $this->annonce->id,
            'titre' => $this->annonce->titre,
            'message' => 'Nouvelle annonce : '.$this->annonce->titre,
            'url' => route('annonces.show', $this->annonce),
        ];
    }
}