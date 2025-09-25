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
        'user_id',
        'date_inscription',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_inscription' => 'date',
        ];
    }

    /** Relation vers l'utilisateur lié */
    public function user()
    {
        return $this->belongsTo(User::class);
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
     * Accessor pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return trim(($this->nom ?? '') . ' ' . ($this->prenom ?? '')) ?: null;
    }

    /**
     * Scope pour les étudiants actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', 'ACTIF');
    }

    /**
     * Scope pour les étudiants suspendus
     */
    public function scopeSuspendus($query)
    {
        return $query->where('statut', 'SUSPENDU');
    }

    /**
     * Scope pour les étudiants diplômés
     */
    public function scopeDiplomes($query)
    {
        return $query->where('statut', 'DIPLOME');
    }

    /**
     * When an Etudiant profile is deleted, also delete the linked User
     * to keep data consistent (reverse cascade).
     */
    protected static function booted()
    {
        static::deleting(function (Etudiant $etudiant) {
            // If this is a force delete scenario and relation exists
            if ($etudiant->user) {
                // Delete linked user without firing its events to avoid recursion
                \App\Models\User::withoutEvents(function () use ($etudiant) {
                    $etudiant->user->delete();
                });
            }
        });
    }
}
