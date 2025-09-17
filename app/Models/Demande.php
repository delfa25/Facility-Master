<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $table = 'demande';

    protected $fillable = [
        'etudiant_id',
        'type_demande',
        'statut',
        'cycle_id',
        'date_demande',
        'date_traitement',
        'commentaire',
        'document_id',
    ];

    protected function casts(): array
    {
        return [
            'date_demande' => 'date',
            'date_traitement' => 'datetime',
        ];
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
