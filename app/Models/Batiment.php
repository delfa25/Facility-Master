<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batiment extends Model
{
    use HasFactory;

    protected $table = 'batiment';

    protected $fillable = [
        'code',
        'nom',
    ];

    public function salles()
    {
        return $this->hasMany(Salle::class);
    }
}
