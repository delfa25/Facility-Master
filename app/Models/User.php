<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'phone',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'password',
        'must_change_password',
        'role',
        'last_login',
        'actif',
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

    /** Relation vers un profil étudiant (s'il existe) */
    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }

    /** Relation vers un profil enseignant (s'il existe) */
    public function enseignant()
    {
        return $this->hasOne(Enseignant::class);
    }

    /** Relation vers un profil personne (admin) */
    public function personne()
    {
        return $this->hasOne(Personne::class);
    }

    // Email est stocké directement sur la table users

    /**
     * Accessor pour récupérer le nom complet depuis etudiant/enseignant
     */
    public function getNameAttribute()
    {
        return $this->username;
    }

    /** Nom d'affichage priorisant les profils, puis fallback sur users.nom/prenom */
    public function getUsernameAttribute(): ?string
    {
        if ($this->relationLoaded('etudiant') && $this->etudiant) {
            return trim(($this->etudiant->nom ?? '') . ' ' . ($this->etudiant->prenom ?? '')) ?: null;
        }
        if ($this->relationLoaded('enseignant') && $this->enseignant) {
            return trim(($this->enseignant->nom ?? '') . ' ' . ($this->enseignant->prenom ?? '')) ?: null;
        }
        if ($this->relationLoaded('personne') && $this->personne) {
            return trim(($this->nom ?? '') . ' ' . ($this->prenom ?? '')) ?: null;
        }
        // Lazy fallback
        if ($this->etudiant) {
            return trim(($this->etudiant->nom ?? '') . ' ' . ($this->etudiant->prenom ?? '')) ?: null;
        }
        if ($this->enseignant) {
            return trim(($this->enseignant->nom ?? '') . ' ' . ($this->enseignant->prenom ?? '')) ?: null;
        }
        return trim(($this->nom ?? '') . ' ' . ($this->prenom ?? '')) ?: null;
    }

    // role attribute is stored on users table directly

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
        return static::where('email', $email)->first();
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
        return static::where('email', $username)->first();
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