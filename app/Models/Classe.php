<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $table = 'classe';

    protected $fillable = [
        'code',
        'nom',
        'filiere_id',
        'niveau_id',
        'salle_id',
        'responsable_enseignant_id',
        'annee_id',
    ];

    /**
     * Relation avec la filière
     */
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    /**
     * Relation avec le niveau
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Relation avec la salle
     */
    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    /**
     * Relation avec l'enseignant responsable
     */
    public function responsableEnseignant()
    {
        return $this->belongsTo(Enseignant::class, 'responsable_enseignant_id');
    }

    /**
     * Relation avec l'année académique
     */
    public function anneeAcad()
    {
        return $this->belongsTo(AnneeAcad::class, 'annee_id');
    }

    /**
     * Relation avec les groupes
     */
    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }

    /**
     * Relation avec les inscriptions
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
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
     * Relation avec les publications d'emploi du temps
     */
    public function edtPublications()
    {
        return $this->hasMany(EdtPublication::class);
    }
}
