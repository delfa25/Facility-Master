<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisponibiliteEnseignant extends Model
{
    use HasFactory;

    protected $table = 'disponibilite_enseignant';

    protected $fillable = [
        'enseignant_id',
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

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
