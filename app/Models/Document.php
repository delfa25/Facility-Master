<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'document';

    protected $fillable = [
        'type',
        'personne_id',
        'etudiant_id',
        'numero',
        'date_emission',
        'chemin_fichier',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'date_emission' => 'date',
            'meta' => 'array',
        ];
    }

    public function personne()
    {
        return $this->belongsTo(Personne::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
