<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    /**
     * Muestra el formulario para solicitar un enlace de restablecimiento de contraseña.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password'); // Asegúrate de que este nombre de vista sea correcto
    }

    /**
     * Envía el enlace de restablecimiento de contraseña al usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        try {
            $status = Password::sendResetLink($request->only('email'));

            return $status === Password::RESET_LINK_SENT
                ? back()->with('status', trans($status))
                : back()->withErrors(['email' => trans($status)]);
        } catch (\Exception $e) {
            Log::error('Error sending reset link: ' . $e->getMessage(), [
                'email' => $request->input('email'),
                'stack' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['email' => 'Ocurrió un error al intentar enviar el enlace de restablecimiento.']);
        }
    }
}
