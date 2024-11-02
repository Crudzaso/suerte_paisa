<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailHelperGlobal
{
    protected static function getEmailConfig()
    {
        return [
            'fromEmail' => env('MAIL_FROM_ADDRESS'),
            'fromName' => env('MAIL_FROM_NAME'),
            'apiToken' => env('MAIL_PASSWORD'),
        ];
    }

    
    protected static function sendEmailRequest($toEmail, $toName, $subject, $textContent, $htmlContent)
    {
        $config = self::getEmailConfig();

        $response = Http::withToken($config['apiToken'])
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://api.mailersend.com/v1/email', [
                'from' => [
                    'email' => $config['fromEmail'],
                    'name' => $config['fromName'],
                ],
                'to' => [[
                    'email' => $toEmail,
                    'name' => $toName,
                ]],
                'subject' => $subject,
                'text' => $textContent,
                'html' => $htmlContent,
            ]);

        if (!$response->successful()) {
            Log::error('Error al enviar correo:', [
                'response' => $response->json(),
                'status' => $response->status(),
                'request_data' => [
                    'to' => $toEmail,
                    'subject' => $subject,
                ],
            ]);
        }
    }

    
    public static function sendWelcomeEmail($user)
    {
        $subject = '¡Bienvenido a Suerte Paisa!';
        $textContent = 'Gracias por registrarte en Suerte Paisa. Estamos emocionados de tenerte con nosotros.';
        
        $htmlContent = "
        <div style='font-family: Arial, sans-serif; color: #333; padding: 20px;'>
            <h1 style='color: #007bff;'>¡Bienvenido a Suerte Paisa, {$user->names}!</h1>
            <p>Gracias por registrarte en <strong>Suerte Paisa</strong>. Estamos emocionados de tenerte con nosotros.</p>
            <p>Esperamos que disfrutes de todos los beneficios y servicios que ofrecemos.</p>
            <p>¡Buena suerte!</p>
            <footer style='margin-top: 20px; color: #888; font-size: 0.9em;'>
                Este es un mensaje automático, por favor no respondas.
            </footer>
        </div>
        ";

        self::sendEmailRequest($user->email, $user->names, $subject, $textContent, $htmlContent);
    }

    
    public static function sendLoginNotification($user)
    {
        $subject = 'Notificación de Inicio de Sesión - Suerte Paisa';
        $textContent = 'Se ha iniciado sesión en tu cuenta de Suerte Paisa.';

        $htmlContent = "
        <div style='font-family: Arial, sans-serif; color: #333; padding: 20px;'>
            <h1 style='color: #007bff;'>Hola, {$user->names}!</h1>
            <p>Se ha iniciado sesión en tu cuenta de <strong>Suerte Paisa</strong>. Si no reconoces esta actividad, por favor comunícate con nuestro equipo de soporte.</p>
            <footer style='margin-top: 20px; color: #888; font-size: 0.9em;'>
                Este es un mensaje automático, por favor no respondas.
            </footer>
        </div>
        ";

        self::sendEmailRequest($user->email, $user->names, $subject, $textContent, $htmlContent);
    }

    
    public static function sendPasswordResetEmail($user, $resetLink)
    {
        $subject = 'Restablecimiento de Contraseña - Suerte Paisa';

        $htmlContent = "
        <div style='background-color: #f9fafc; padding: 20px; text-align: center;'>
            <div style='background-color: #ffffff; padding: 30px; border-radius: 8px; display: inline-block; text-align: left;'>
                <h2 style='color: #333333;'>¡Hola, {$user->names}!</h2>
                <p style='color: #555555;'>
                    Has recibido este mensaje porque se solicitó un restablecimiento de contraseña para tu cuenta en Suerte Paisa.
                </p>
                <a href='{$resetLink}' style='display: inline-block; margin: 20px 0; padding: 12px 24px; background-color: #2d3748; color: #ffffff; border-radius: 4px; text-decoration: none;'>
                    Restablecer contraseña
                </a>
                <p style='color: #555555;'>
                    Este enlace de restablecimiento de contraseña expirará en 60 minutos.
                </p>
                <p style='color: #555555;'>
                    Si no has solicitado el restablecimiento de contraseña, simplemente ignora este mensaje.
                </p>
                <p style='color: #555555; margin-top: 20px;'>Saludos,<br><strong>Suerte Paisa</strong></p>
            </div>
            <p style='color: #999999; font-size: 12px; margin-top: 20px;'>
                Si estás teniendo problemas al hacer clic en el botón Restablecer contraseña, copia y pega la URL de abajo en tu navegador:<br>
                <a href='{$resetLink}' style='color: #2d3748;'>{$resetLink}</a>
            </p>
        </div>
        ";

        $textContent = "Hola, {$user->names}!\n\nHas recibido este mensaje porque se solicitó un restablecimiento de contraseña para tu cuenta en Suerte Paisa.\n\nPor favor, visita el siguiente enlace para restablecer tu contraseña:\n\n{$resetLink}\n\nEste enlace expirará en 60 minutos.\n\nSi no has solicitado el restablecimiento de contraseña, ignora este mensaje.\n\nSaludos,\nSuerte Paisa";

        self::sendEmailRequest($user->email, $user->names, $subject, $textContent, $htmlContent);
    }

}
