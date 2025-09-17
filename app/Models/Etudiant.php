<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiant';

    protected $fillable = [
        'INE',
        'personne_id',
        'date_inscription',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_inscription' => 'date',
        ];
    }

    /**
     * Relation avec Personne
     */
    public function personne()
    {
        return $this->belongsTo(Personne::class);
    }

    /**
     * Relation avec les groupes (many-to-many)
     */
    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'etudiant_groupe')
            ->using(EtudiantGroupe::class)
            ->withTimestamps();
    }

    /**
     * Relation avec les inscriptions
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Relation avec les demandes
     */
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    /**
     * Relation avec les documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Relation avec les soumissions de devoirs
     */
    public function soumissions()
    {
        return $this->hasMany(Soumission::class);
    }

    /**
     * Accessor pour le nom complet via la personne
     */
    public function getNomCompletAttribute()
    {
        return $this->personne ? $this->personne->nom_complet : null;
    }

    /**
     * Scope pour les étudiants actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', 'Actif');
    }

    /**
     * Scope pour les étudiants suspendus
     */
    public function scopeSuspendus($query)
    {
        return $query->where('statut', 'Suspendu');
    }

    /**
     * Scope pour les étudiants diplômés
     */
    public function scopeDiplomes($query)
    {
        return $query->where('statut', 'Diplome');
    }
}
