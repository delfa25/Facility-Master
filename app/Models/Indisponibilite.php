<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indisponibilite extends Model
{
    use HasFactory;

    protected $table = 'indisponibilite';

    protected $fillable = [
        'ressource_type',
        'ressource_id',
        'debut',
        'fin',
        'motif',
    ];

    protected function casts(): array
    {
        return [
            'debut' => 'datetime',
            'fin'   => 'datetime',
        ];
    }

    // Relations conditionnelles (non-morph car type est ENUM spécifique)
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'ressource_id')
            ->where($this->getTable().'.ressource_type', 'ENSEIGNANT');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'ressource_id')
            ->where($this->getTable().'.ressource_type', 'SALLE');
    }
}
