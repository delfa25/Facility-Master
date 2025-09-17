<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devoir extends Model
{
    use HasFactory;

    protected $table = 'devoir';

    protected $fillable = [
        'cours_id',
        'classe_id',
        'groupe_id',
        'enseignant_id',
        'titre',
        'description',
        'date_publication',
        'date_limite',
        'points_max',
        'piece_jointe',
    ];

    protected function casts(): array
    {
        return [
            'date_publication' => 'datetime',
            'date_limite' => 'datetime',
        ];
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function soumissions()
    {
        return $this->hasMany(Soumission::class);
    }
}
