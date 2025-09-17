<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'cours';

    protected $fillable = [
        'code',
        'libelle',
        'ue_id',
    ];

    /**
     * Relation avec l'UE
     */
    public function ue()
    {
        return $this->belongsTo(Ue::class);
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
     * Relation avec les ressources de cours
     */
    public function ressources()
    {
        return $this->hasMany(RessourceCours::class);
    }
}
