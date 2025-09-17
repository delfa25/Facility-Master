<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailTestController extends Controller
{
    public function sendTest(Request $request)
    {
        $to = $request->query('to', config('mail.from.address'));

        try {
            Mail::raw('Ceci est un e-mail de test depuis FacilityMaster.', function ($message) use ($to) {
                $message->to($to)
                        ->subject('Test SMTP FacilityMaster');
            });

            return response()->json([
                'ok' => true,
                'message' => 'E-mail de test envoyé',
                'to' => $to,
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.'.config('mail.default').'.host'),
                'port' => config('mail.mailers.'.config('mail.default').'.port'),
                'encryption' => config('mail.mailers.'.config('mail.default').'.encryption'),
                'from' => config('mail.from.address'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'error' => $e->getMessage(),
                'trace' => collect($e->getTrace())->take(5),
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.'.config('mail.default').'.host'),
                'port' => config('mail.mailers.'.config('mail.default').'.port'),
                'encryption' => config('mail.mailers.'.config('mail.default').'.encryption'),
                'from' => config('mail.from.address'),
            ], 500);
        }
    }
}
