<?php

namespace App\Support;

use App\Models\Etudiant;

class IdGenerator
{
    /**
     * Génère un INE unique au format: YY + 11 chiffres aléatoires = 13 caractères.
     */
    public static function generateINE(): string
    {
        $yearTwo = now()->format('y');
        do {
            $random = str_pad(strval(random_int(0, 99999999999)), 11, '0', STR_PAD_LEFT);
            $ine = $yearTwo . $random;
        } while (Etudiant::where('INE', $ine)->exists());

        return $ine;
    }
}