<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PasswordResetEmail;
use App\Mail\RegistroExitoso;

class EmailHelperGlobal
{
    // Configuración predeterminada desde .env
    protected static function getEmailConfig()
    {
        return [
            'fromEmail' => env('MAIL_FROM_ADDRESS'),
            'fromName' => env('MAIL_FROM_NAME'),
        ];
    }

    protected static function sendEmailRequest($toEmail, $toName, $subject, $htmlContent)
    {
        try {
            // Configuramos los datos del correo
            $data = [
                'subject' => $subject,
                'htmlContent' => $htmlContent,
                'toEmail' => $toEmail,
                'toName' => $toName,
            ];

            // Enviar el correo utilizando el Mail de Laravel
            Mail::send([], [], function ($message) use ($data) {
                $message->to($data['toEmail'], $data['toName'])
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                        ->subject($data['subject'])
                        ->html($data['htmlContent']); // Usamos el método html() aquí
            });

        } catch (\Exception $e) {
            // Si ocurre un error, lo registramos en los logs
            Log::error('Error al enviar el correo:', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
        }
    }

    // Generación del contenido del mensaje HTML
    public static function generateMessage($userName, $messageContent, $footer = null)
    {
        return "
            <div style='background-color: #f9fafc; padding: 20px; font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-top: 6px solid #FFD700; border-bottom: 6px solid #FFD700;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                        <img src='https://res.cloudinary.com/dm6hc1mqx/image/upload/v1732842790/pjlnjvpnfp8gr2tgxtdc.png' alt='Suerte Paisa Logo' style='max-width: 150px; border-radius: 8px;'>
                    </div>
                    <h2 style='color: #0057B7; text-align: center; margin-bottom: 20px;'>¡Hola, {$userName}!</h2>
                    <p style='color: #333333; font-size: 16px; line-height: 1.6;'>
                        {$messageContent}
                    </p>
                    " . ($footer ? "<p style='color: #555555; font-size: 14px; line-height: 1.4; margin-top: 20px;'>$footer</p>" : "") . "
                    <p style='color: #333333; font-size: 16px; margin-top: 30px; text-align: center;'>
                        Saludos,<br><strong style='color: #0057B7;'>Suerte Paisa</strong>
                    </p>
                </div>
            </div>
        ";
    }

    // Enviar correo de bienvenida
    public static function sendWelcomeEmail($user)
    {
        $subject = '¡Bienvenido a Suerte Paisa!';

        $messageContent = 'Gracias por registrarte en <strong>Suerte Paisa</strong>. Estamos emocionados de tenerte con nosotros y esperamos que disfrutes de todos nuestros servicios.';

        $footer = 'Este es un mensaje automático, por favor no respondas.';

        $htmlContent = self::generateMessage($user->names, $messageContent, $footer);

        self::sendEmailRequest($user->email, $user->names, $subject, $htmlContent);
    }

    // Enviar notificación de inicio de sesión
    public static function sendLoginNotification($user)
    {
        $subject = 'Notificación de Inicio de Sesión - Suerte Paisa';

        $messageContent = "Has ingresado en nuestra página, <strong>¡Bienvenido!</strong>. Si no fuiste tú, considera cambiar tu contraseña inmediatamente.";

        $footer = 'Si no reconoces este inicio de sesión, por favor revisa tu actividad reciente.';

        $htmlContent = self::generateMessage($user->names, $messageContent, $footer);

        self::sendEmailRequest($user->email, $user->names, $subject, $htmlContent);
    }

    // Enviar correo de restablecimiento de contraseña
    public static function sendPasswordResetEmail($user, $resetLink)
    {
        $subject = 'Restablecimiento de Contraseña - Suerte Paisa';

        $messageContent = 'Has recibido este mensaje porque se solicitó un restablecimiento de contraseña para tu cuenta en Suerte Paisa.';

        // Botón para restablecer la contraseña
        $buttonHtml = "<div style='margin-top: 20px; text-align: center;'>
            <a href='{$resetLink}' style='display: inline-block; padding: 12px 24px; background-color: #FFD700; color: #FFFFFF; border-radius: 4px; text-decoration: none; font-size: 16px;'>Restablecer contraseña</a>
        </div>";

        $footer = 'Este enlace de restablecimiento de contraseña expirará en 60 minutos. Si no has solicitado esta acción, simplemente pasa por alto este mensaje.';

        $htmlContent = self::generateMessage($user->names, $messageContent . $buttonHtml, $footer);

        self::sendEmailRequest($user->email, $user->names, $subject, $htmlContent);
    }

}
