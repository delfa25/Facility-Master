<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;

    protected $table = 'semestre';

    protected $fillable = [
        'code',
        'date_debut',
        'date_fin',
        'annee_id',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    /**
     * Relation avec l'année académique
     */
    public function anneeAcad()
    {
        return $this->belongsTo(AnneeAcad::class, 'annee_id');
    }

    /**
     * Relation avec les UE
     */
    public function ues()
    {
        return $this->hasMany(Ue::class);
    }

    /**
     * Scope pour le semestre courant
     */
    public function scopeCourant($query)
    {
        $now = now()->toDateString();
        return $query->where('date_debut', '<=', $now)
                    ->where('date_fin', '>=', $now);
    }
}
