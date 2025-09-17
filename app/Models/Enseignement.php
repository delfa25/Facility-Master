<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignement extends Model
{
    use HasFactory;

    protected $table = 'enseignement';

    protected $fillable = [
        'enseignant_id',
        'cours_id',
        'classe_id',
        'groupe_id',
        'volume_horaire',
    ];

    /**
     * Relation avec l'enseignant
     */
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    /**
     * Relation avec le cours
     */
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    /**
     * Relation avec la classe
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Relation avec le groupe (optionnel)
     */
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    /**
     * Relation avec les séances
     */
    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
