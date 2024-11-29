<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailHelper
{
    public static function sendEmail($user)
    {
        $apiToken = env('MAIL_PASSWORD');
        $fromEmail = env('MAIL_FROM_ADDRESS');
        $fromName = env('MAIL_FROM_NAME');

        $response = Http::withToken($apiToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.mailersend.com/v1/email', [
                'from' => [
                    'email' => $fromEmail,
                    'name' => $fromName,
                ],
                'to' => [
                    [
                        'email' => $user->email,
                        'name' => $user->names,
                    ],
                ],
                'subject' => 'Registro Exitoso',
                'text' => 'Te has registrado exitosamente en Suerte Paisa.',
                'html' => '<h1>Hola, ' . $user->names . '!</h1><p>Te has registrado exitosamente en Suerte Paisa.</p>',
            ]);

        // Maneja errores
        if (!$response->successful()) {
            Log::error('Error al enviar correo:', $response->json());
        }
    }
}
