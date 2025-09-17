<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessourceCours extends Model
{
    use HasFactory;

    protected $table = 'ressource_cours';

    protected $fillable = [
        'cours_id',
        'enseignant_id',
        'titre',
        'description',
        'fichier',
        'date_publication',
    ];

    protected function casts(): array
    {
        return [
            'date_publication' => 'datetime',
        ];
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
