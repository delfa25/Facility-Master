<?php

namespace App\Observers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    public function updated(User $user): void
    {
        // If the 'actif' flag was toggled to true, send the welcome email
        if ($user->wasChanged('actif') && $user->actif) {
            try {
                $to = optional($user->personne)->email;
                if ($to) {
                    Mail::to($to)->send(new WelcomeMail($user));
                } else {
                    Log::warning('User activated but personne email missing', [
                        'user_id' => $user->id,
                    ]);
                }
            } catch (\Throwable $e) {
                Log::warning('Activation mail send failed (observer)', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
