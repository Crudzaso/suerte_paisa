<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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
                $this->sendMessageToDiscord("Nuevo registro a través de Google: {$user->email} en {$dateTime}");
            }

            return redirect()->route('usuarios.layouts')->with('success', 'Has iniciado sesión correctamente');
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

    public function logout(Request $request)
    {
        // Cierra la sesión del usuario actual
        Auth::guard('web')->logout();

        // Redirige a la página de login
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }

}
