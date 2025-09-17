<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdtPublication extends Model
{
    use HasFactory;

    protected $table = 'edt_publication';

    protected $fillable = [
        'classe_id',
        'annee_id',
        'version',
        'statut',
        'published_at',
        'publie_par',
        'export_pdf',
        'export_ics',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeAcad()
    {
        return $this->belongsTo(AnneeAcad::class, 'annee_id');
    }

    public function auteur()
    {
        return $this->belongsTo(User::class, 'publie_par');
    }
}
