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

    /**
     * Reverse cascade: when a Personne profile is deleted, also delete the linked User.
     */
    protected static function booted()
    {
        static::deleting(function (Personne $personne) {
            if ($personne->user) {
                \App\Models\User::withoutEvents(function () use ($personne) {
                    $personne->user->delete();
                });
            }
        });
    }
}
