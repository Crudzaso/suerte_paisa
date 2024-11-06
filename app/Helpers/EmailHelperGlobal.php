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

    protected static function sendEmailRequest($toEmail, $toName, $subject, $htmlContent)
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

    public static function generateMessage($userName, $messageContent, $footer = null)
    {
        return "
            <div style='background-color: #f9fafc; padding: 20px; text-align: center;'>
                <div style='background-color: #ffffff; padding: 30px; border-radius: 8px; display: inline-block; text-align: left;'>
                    <h2 style='color: #333333;'>¡Hola, {$userName}!</h2>
                    <p style='color: #555555;'>
                        {$messageContent}
                    </p>
                    " . ($footer ? "<p style='color: #555555;'>$footer</p>" : "") . "
                    <p style='color: #555555; margin-top: 20px;'>Saludos,<br><strong>Suerte Paisa</strong></p>
                </div>
            </div>
        ";
    }

    // Mensaje de registro
    public static function sendWelcomeEmail($user)
    {
        $subject = '¡Bienvenido a Suerte Paisa!';

        $messageContent = 'Gracias por registrarte en <strong>Suerte Paisa</strong>. Estamos emocionados de tenerte con nosotros y esperamos que disfrutes de todos nuestros servicios.';

        $footer = 'Este es un mensaje automático, por favor no respondas.';

        $htmlContent = self::generateMessage($user->names, $messageContent, $footer);

        self::sendEmailRequest($user->email, $user->names, $subject, $htmlContent);
    }

    // Mensaje de login
    public static function sendLoginNotification($user)
    {
        $subject = 'Notificación de Inicio de Sesión - Suerte Paisa';

        $messageContent = "Has ingresado en nuestra página, <strong>Bienvenido</strong>. Si no fuiste tú, por favor cambia tu contraseña inmediatamente.";

        $footer = 'Si no reconoces este inicio de sesión, considera revisar tu actividad reciente.';

        $htmlContent = self::generateMessage($user->names, $messageContent, $footer);

        self::sendEmailRequest($user->email, $user->names, $subject, $htmlContent);
    }

    // Mensaje de cambio de contraseña
    public static function sendPasswordResetEmail($user, $resetLink)
    {
        $subject = 'Restablecimiento de Contraseña - Suerte Paisa';
        
        $messageContent = 'Has recibido este mensaje porque se solicitó un restablecimiento de contraseña para tu cuenta en Suerte Paisa.';

        $buttonHtml = "<div style='margin-top: 20px;'><a href='{$resetLink}' style='display: inline-block; padding: 12px 24px; background-color: #2d3748; color: #ffffff; border-radius: 4px; text-decoration: none;'>Restablecer contraseña</a></div>";

        $footer = 'Este enlace de restablecimiento de contraseña expirará en 60 minutos. Si no has solicitado esta acción, simplemente ignora este mensaje.';

        $htmlContent = self::generateMessage($user->names, $messageContent . $buttonHtml, $footer);

        self::sendEmailRequest($user->email, $user->names, $subject, $htmlContent);
    }
}
