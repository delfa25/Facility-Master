<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeSeance extends Model
{
    use HasFactory;

    protected $table = 'type_seance';

    protected $fillable = [
        'code',
        'libelle',
    ];

    /**
     * Relation avec les séances
     */
    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
