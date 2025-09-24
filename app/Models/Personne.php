<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    protected $table = 'personne';

    protected $fillable = [
        'user_id',
        'bureau',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
