<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = ['joueur_id', 'date_entrainement', 'present'];

    protected $casts = [
        'date_entrainement' => 'date',
        'present' => 'boolean',
    ];

    public function joueur()
    {
        return $this->belongsTo(Joueur::class);
    }
}