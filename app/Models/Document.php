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
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
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
