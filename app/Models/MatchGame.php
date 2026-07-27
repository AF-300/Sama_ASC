<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchGame extends Model
{
    use HasFactory;

    // Le nom de classe est "MatchGame" mais on force Laravel a utiliser la table "matchs"
    protected $table = 'matchs';

    protected $fillable = [
        'adversaire', 'date_match', 'heure', 'lieu',
        'score_asc', 'score_adversaire', 'statut',
    ];

    protected $casts = [
        'date_match' => 'date',
    ];

    public function compositions()
    {
        return $this->hasMany(Composition::class, 'match_id');
    }

    public function statistiques()
    {
        return $this->hasMany(StatistiqueJoueur::class, 'match_id');
    }

    public function joueurs()
    {
        return $this->belongsToMany(Joueur::class, 'compositions', 'match_id', 'joueur_id');
    }
}