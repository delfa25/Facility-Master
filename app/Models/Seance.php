<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $table = 'seance';

    protected $fillable = [
        'enseignement_id',
        'salle_id',
        'plage_id',
        'type_seance_id',
        'date_exception',
        'debut_periode',
        'fin_periode',
        'recurrence',
    ];

    protected function casts(): array
    {
        return [
            'date_exception' => 'date',
            'debut_periode' => 'date',
            'fin_periode' => 'date',
        ];
    }

    public function enseignement()
    {
        return $this->belongsTo(Enseignement::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function plage()
    {
        return $this->belongsTo(PlageHoraire::class, 'plage_id');
    }

    public function typeSeance()
    {
        return $this->belongsTo(TypeSeance::class);
    }

    public function exceptions()
    {
        return $this->hasMany(SeanceException::class);
    }
}
