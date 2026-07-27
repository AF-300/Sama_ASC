<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistiqueJoueur extends Model
{
    use HasFactory;
 protected $table = 'statistiques_joueurs';
    protected $fillable = [
        'joueur_id', 'match_id', 'buts',
        'passes_decisives', 'cartons_jaunes', 'cartons_rouges',
    ];

    public function joueur()
    {
        return $this->belongsTo(Joueur::class);
    }

    public function match()
    {
        return $this->belongsTo(MatchGame::class, 'match_id');
    }
}