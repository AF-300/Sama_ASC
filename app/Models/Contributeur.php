<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contributeur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'quartier'];

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class);
    }
}