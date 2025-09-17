<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeAcad extends Model
{
    use HasFactory;

    protected $table = 'annee_acad';

    protected $fillable = [
        'code',
        'date_debut',
        'date_fin',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    /**
     * Relation avec les semestres
     */
    public function semestres()
    {
        return $this->hasMany(Semestre::class, 'annee_id');
    }

    /**
     * Relation avec les classes
     */
    public function classes()
    {
        return $this->hasMany(Classe::class, 'annee_id');
    }

    /**
     * Relation avec les inscriptions
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'annee_id');
    }

    /**
     * Relation avec les publications d'emploi du temps
     */
    public function edtPublications()
    {
        return $this->hasMany(EdtPublication::class, 'annee_id');
    }

    /**
     * Scope pour l'année académique courante
     */
    public function scopeCourante($query)
    {
        $now = now()->toDateString();
        return $query->where('date_debut', '<=', $now)
                    ->where('date_fin', '>=', $now);
    }
}
