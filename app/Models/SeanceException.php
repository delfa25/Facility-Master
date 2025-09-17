<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeanceException extends Model
{
    use HasFactory;

    protected $table = 'seance_exception';

    protected $fillable = [
        'seance_id',
        'date_originale',
        'action',
        'date_report',
        'salle_id',
        'plage_id',
        'motif',
    ];

    protected function casts(): array
    {
        return [
            'date_originale' => 'date',
            'date_report' => 'date',
        ];
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function plage()
    {
        return $this->belongsTo(PlageHoraire::class, 'plage_id');
    }
}
