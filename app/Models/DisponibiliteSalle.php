<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisponibiliteSalle extends Model
{
    use HasFactory;

    protected $table = 'disponibilite_salle';

    protected $fillable = [
        'salle_id',
        'jour_semaine',
        'heure_debut',
        'heure_fin',
    ];

    protected function casts(): array
    {
        return [
            'heure_debut' => 'datetime:H:i:s',
            'heure_fin' => 'datetime:H:i:s',
        ];
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
}
