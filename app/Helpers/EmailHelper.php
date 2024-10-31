<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailHelper
{
    protected $apiToken;
    protected $fromEmail;
    protected $name;

    public function __construct()
    {
        $this->apiToken = env('MAIL_PASSWORD'); 
        $this->fromEmail = env('MAIL_FROM_ADDRESS');
        $this->name = env('MAIL_FROM_NAME');
    }

    public function sendEmail($user)
    {
        $response = Http::withToken($this->apiToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.mailersend.com/v1/email', [
                'from' => [
                    'email' => $this->fromEmail,
                    'name' => $this->name,
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

        // Maneja la respuesta
        if (!$response->successful()) {
            Log::error('Error al enviar correo:', $response->json());
        }
    }
}
