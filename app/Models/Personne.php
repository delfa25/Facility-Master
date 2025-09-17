<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personne extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personne'; // Nom de la table

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'email',
        'phone',
        'role',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
        ];
    }

    /**
     * Relation inverse avec User
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Relation avec Etudiant
     */
    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }

    /**
     * Relation avec Enseignant
     */
    public function enseignant()
    {
        return $this->hasOne(Enseignant::class);
    }

    /**
     * Documents associés (attestations/diplômes)
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Demandes liées via l'étudiant (helper)
     */
    public function demandes()
    {
        return $this->hasManyThrough(Demande::class, Etudiant::class, 'personne_id', 'etudiant_id');
    }

    /**
     * Accessor pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}