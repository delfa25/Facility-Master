<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'chemin',
        'categorie',
        'document_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
