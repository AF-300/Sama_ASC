<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Composition extends Model
{
    use HasFactory;

    protected $fillable = ['match_id', 'joueur_id', 'titulaire'];

    protected $casts = [
        'titulaire' => 'boolean',
    ];

    public function match()
    {
        return $this->belongsTo(MatchGame::class, 'match_id');
    }

    public function joueur()
    {
        return $this->belongsTo(Joueur::class);
    }
}