<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $table = 'filiere';

    protected $fillable = [
        'code',
        'nom',
    ];

    /**
     * Relation avec les classes
     */
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    /**
     * Relation avec les UE
     */
    public function ues()
    {
        return $this->hasMany(Ue::class);
    }
}
