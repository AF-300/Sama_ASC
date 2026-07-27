<?php

namespace App\Notifications;

use App\Models\MatchGame;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RappelMatchNotification extends Notification
{
    use Queueable;

    public function __construct(public MatchGame $match)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'match',
            'match_id' => $this->match->id,
            'message' => 'Rappel : match contre '.$this->match->adversaire.' demain'.($this->match->heure ? ' a '.$this->match->heure : ''),
            'url' => route('matchs.show', $this->match),
        ];
    }
}