<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlageHoraire extends Model
{
    use HasFactory;

    protected $table = 'plage_horaire';

    protected $fillable = [
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

    /**
     * Relation avec les séances
     */
    public function seances()
    {
        return $this->hasMany(Seance::class, 'plage_id');
    }

    /**
     * Relation avec les exceptions de séances (pour les reports)
     */
    public function seanceExceptions()
    {
        return $this->hasMany(SeanceException::class, 'plage_id');
    }

    /**
     * Scope pour filtrer par jour de la semaine
     */
    public function scopeJour($query, $jour)
    {
        return $query->where('jour_semaine', $jour);
    }

    /**
     * Accessor pour le nom du jour
     */
    public function getNomJourAttribute()
    {
        $jours = [
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
            7 => 'Dimanche'
        ];

        return $jours[$this->jour_semaine] ?? '';
    }
}
