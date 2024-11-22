<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\EmailHelperGlobal;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    protected $emailHelper;

    public function __construct(EmailHelperGlobal $emailHelper)
    {
        $this->emailHelper = $emailHelper;
    }

    /**
     * Enviar correo de bienvenida tras registro exitoso
     */
    public function sendWelcomeEmail(User $user)
    {
        try {
            // Enviar el correo de bienvenida
            $this->emailHelper::sendWelcomeEmail($user);
            Log::info("Correo de bienvenida enviado a: " . $user->email);
        } catch (\Exception $e) {
            Log::error("Error al enviar correo de bienvenida: " . $e->getMessage(), [
                'user' => $user->email
            ]);
        }
    }

    /**
     * Enviar correo de notificación de login
     */
    public function sendLoginNotification(User $user)
    {
        try {
            // Enviar correo de notificación de login
            $this->emailHelper::sendLoginNotification($user);
            Log::info("Notificación de login enviada a: " . $user->email);
        } catch (\Exception $e) {
            Log::error("Error al enviar notificación de login: " . $e->getMessage(), [
                'user' => $user->email
            ]);
        }
    }

    /**
     * Enviar correo para restablecer la contraseña
     */
    public function sendPasswordResetEmail(User $user, $resetLink)
    {
        try {
            // Enviar el correo de restablecimiento de contraseña
            $this->emailHelper::sendPasswordResetEmail($user, $resetLink);
            Log::info("Correo de restablecimiento de contraseña enviado a: " . $user->email);
        } catch (\Exception $e) {
            Log::error("Error al enviar correo de restablecimiento de contraseña: " . $e->getMessage(), [
                'user' => $user->email,
                'resetLink' => $resetLink
            ]);
        }
    }
}
