<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EtudiantGroupe extends Pivot
{
    protected $table = 'etudiant_groupe';

    protected $fillable = [
        'etudiant_id',
        'groupe_id',
    ];
}
