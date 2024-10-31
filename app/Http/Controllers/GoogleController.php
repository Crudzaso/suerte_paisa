<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistroExitoso;

class GoogleController extends Controller
{

    public function login()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $user_google = Socialite::driver('google')->user();
            $user = User::where('email', $user_google->email)->first();

            $dateTime = now()->format('Y-m-d h:i A');

            if ($user) {
                Auth::login($user);
                $this->sendMessageToDiscord("Usuario ha iniciado sesión: {$user->email} en {$dateTime}");
            } else {
                $user = User::create([
                    'names' => $user_google->name,
                    'email' => $user_google->email,
                ]);

                GoogleUser::create([
                    'email' => $user_google->email,
                    'name' => $user_google->name,
                    'user_id' => $user->id,
                ]);

                Auth::login($user);

                $this->sendEmail($user);

                $this->sendMessageToDiscord("Nuevo registro a través de Google: {$user->email} en {$dateTime}");
            }

            return redirect()->route('usuarios.index')->with('success', 'Has iniciado sesión correctamente');
        } catch (\Exception $e) {
            \Log::error('Google login error:', ['message' => $e->getMessage()]);
            return redirect()->route('auth.google')->with('error', 'Error al iniciar sesión con Google.');
        }
    }

    protected function sendMessageToDiscord($message)
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');

        Http::post($webhookUrl, [
            'content' => $message,
        ]);
    }

    protected function sendEmail($user)
    {
        $response = Http::withToken('mlsn.ab48efdceb816e21a4b58e0ee8e94049b03a94056362bf460ee268631932750e')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.mailersend.com/v1/email', [
                'from' => [
                    'email' => 'test@trial-x2p03476q2kgzdrn.mlsender.net',
                    'name' => 'Suerte Paisa',
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
            \Log::error('Error al enviar correo:', $response->json());
        }
    }

    public function logout(Request $request)
    {
        // Cierra la sesión del usuario actual
        Auth::guard('web')->logout();

        // Redirige a la página de login
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }

}
