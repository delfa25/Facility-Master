<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;

    protected $table = 'salle';

    protected $fillable = [
        'code',
        'capacite',
        'localisation',
    ];

    /**
     * Relation avec les classes
     */
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    /**
     * Relation avec les séances
     */
    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    /**
     * Relation avec les disponibilités
     */
    public function disponibilites()
    {
        return $this->hasMany(DisponibiliteSalle::class);
    }

    /**
     * Relation avec les exceptions de séances (pour les reports)
     */
    public function seanceExceptions()
    {
        return $this->hasMany(SeanceException::class);
    }

    /**
     * Scope pour les salles avec une capacité minimale
     */
    public function scopeCapaciteMin($query, $capacite)
    {
        return $query->where('capacite', '>=', $capacite);
    }
}
