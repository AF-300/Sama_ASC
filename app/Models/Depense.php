<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'montant', 'categorie', 'date_depense'];

    protected $casts = [
        'date_depense' => 'date',
        'montant' => 'decimal:2',
    ];
}