<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $table = 'enseignant';

    protected $fillable = [
        'user_id',
        'grade',
        'specialite',
        'statut',
    ];

    /** Relation vers l'utilisateur lié */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les classes dont il est responsable
     */
    public function classesResponsable()
    {
        return $this->hasMany(Classe::class, 'responsable_enseignant_id');
    }

    /**
     * Relation avec les enseignements
     */
    public function enseignements()
    {
        return $this->hasMany(Enseignement::class);
    }

    /**
     * Relation avec les disponibilités
     */
    public function disponibilites()
    {
        return $this->hasMany(DisponibiliteEnseignant::class);
    }

    /**
     * Relation avec les devoirs publiés
     */
    // No personal casts here; personal fields live on users
    public function devoirs()
    {
        return $this->hasMany(Devoir::class);
    }

    /**
     * Relation avec les corrections de soumissions
     */
    public function corrections()
    {
        return $this->hasMany(Soumission::class, 'corrige_par');
    }

    /**
     * Relation avec les ressources de cours
     */
    public function ressourcesCours()
    {
        return $this->hasMany(RessourceCours::class);
    }

    /**
     * Accessor pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return trim(($this->nom ?? '') . ' ' . ($this->prenom ?? '')) ?: null;
    }

    // L'email est stocké sur le modèle User (relation user)
}
