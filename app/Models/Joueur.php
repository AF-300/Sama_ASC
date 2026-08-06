<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id', 'nom', 'prenom', 'age', 'poste',
    'numero_maillot', 'photo', 'quartier', 'categorie',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function compositions()
    {
        return $this->hasMany(Composition::class);
    }

    public function statistiques()
    {
        return $this->hasMany(StatistiqueJoueur::class);
    }

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class);
    }

    public function matchsJoues()
    {
        return $this->belongsToMany(MatchGame::class, 'compositions', 'joueur_id', 'match_id');
    }
}