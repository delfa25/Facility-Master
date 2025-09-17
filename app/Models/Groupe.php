<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $table = 'groupe';

    protected $fillable = [
        'code',
        'type',
        'classe_id',
    ];

    /**
     * Relation avec la classe
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Relation avec les étudiants (many-to-many)
     */
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'etudiant_groupe')
            ->using(EtudiantGroupe::class)
            ->withTimestamps();
    }

    /**
     * Relation avec les enseignements
     */
    public function enseignements()
    {
        return $this->hasMany(Enseignement::class);
    }

    /**
     * Relation avec les devoirs
     */
    public function devoirs()
    {
        return $this->hasMany(Devoir::class);
    }

    /**
     * Scope pour filtrer par type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
