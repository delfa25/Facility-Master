<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    use HasFactory;

    protected $table = 'materiel';

    protected $fillable = [
        'designation',
        'categorie',
        'quantite',
        'etat',
    ];

    public function lignesCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
