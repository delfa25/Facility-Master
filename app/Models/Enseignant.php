<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $table = 'enseignant';

    protected $fillable = [
        'personne_id',
        'grade',
        'specialite',
        'statut',
    ];

    /**
     * Relation avec Personne
     */
    public function personne()
    {
        return $this->belongsTo(Personne::class);
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
     * Accessor pour le nom complet via la personne
     */
    public function getNomCompletAttribute()
    {
        return $this->personne ? $this->personne->nom_complet : null;
    }

    /**
     * Accessor pour l'email via la personne
     */
    public function getEmailAttribute()
    {
        return $this->personne ? $this->personne->email : null;
    }
}
