<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'password',
        'personne_id',
        'last_login',
        'actif',
        'must_change_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
            'actif' => 'boolean',
            'must_change_password' => 'boolean',
        ];
    }

    /**
     * Relation avec la table personne
     */
    public function personne()
    {
        return $this->belongsTo(Personne::class);
    }

    /**
     * Accessor pour récupérer l'email depuis la table personne
     */
    public function getEmailAttribute()
    {
        return $this->personne->email ?? null;
    }

    /**
     * Accessor pour récupérer le nom depuis la table personne
     */
    public function getNameAttribute()
    {
        return $this->personne ? $this->personne->nom . ' ' . $this->personne->prenom : null;
    }

    /**
     * Accessor pour récupérer le rôle depuis la table personne
     */
    public function getRoleAttribute()
    {
        // Primary source: personne.role
        if ($this->relationLoaded('personne') && $this->personne) {
            return $this->personne->role;
        }

        // Lazy-load personne if not loaded
        if ($this->personne) {
            return $this->personne->role;
        }

        // Fallback for legacy schema where users.role still exists (pre-migration)
        $attributes = $this->getAttributes();
        return $attributes['role'] ?? null;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    // NOTE: Do not override getAuthIdentifierName / getAuthIdentifier to use email.
    // Keeping Laravel defaults ensures the session guard uses the primary key ("id")
    // and does NOT run queries like `select * from users where email = ?` on the users table.

    /**
     * Find user by email for authentication
     *
     * @param string $email
     * @return \App\Models\User|null
     */
    public static function findByEmail($email)
    {
        return static::whereHas('personne', function($query) use ($email) {
            $query->where('email', $email);
        })->first();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Override findForPassport method for Laravel Passport (if needed)
     *
     * @param string $username
     * @return \App\Models\User|null
     */
    public function findForPassport($username)
    {
        return $this->findByEmail($username);
    }

    /**
     * Commandes effectuées par l'utilisateur
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'utilisateur_id');
    }

    /**
     * Publications d'emploi du temps réalisées par l'utilisateur
     */
    public function edtPublications()
    {
        return $this->hasMany(EdtPublication::class, 'publie_par');
    }
}