<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;

    protected $table = 'ligne_commande';

    protected $fillable = [
        'commande_id',
        'materiel_id',
        'quantite',
        'prix_unitaire',
    ];

    protected function casts(): array
    {
        return [
            'prix_unitaire' => 'decimal:2',
        ];
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function materiel()
    {
        return $this->belongsTo(Materiel::class);
    }
}
