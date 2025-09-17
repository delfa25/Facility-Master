<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;

    protected $table = 'cycle';

    protected $fillable = [
        'code',
        'nom',
    ];

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
