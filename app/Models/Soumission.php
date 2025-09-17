<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soumission extends Model
{
    use HasFactory;

    protected $table = 'soumission';

    protected $fillable = [
        'devoir_id',
        'etudiant_id',
        'date_soumission',
        'fichier',
        'commentaire',
        'statut',
        'note',
        'remarque_correction',
        'corrige_par',
        'date_correction',
    ];

    protected function casts(): array
    {
        return [
            'date_soumission' => 'datetime',
            'date_correction' => 'datetime',
            'note' => 'decimal:2',
        ];
    }

    public function devoir()
    {
        return $this->belongsTo(Devoir::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function correcteur()
    {
        return $this->belongsTo(Enseignant::class, 'corrige_par');
    }
}
