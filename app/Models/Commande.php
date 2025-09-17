<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commande';

    protected $fillable = [
        'date_commande',
        'utilisateur_id',
    ];

    protected function casts(): array
    {
        return [
            'date_commande' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
