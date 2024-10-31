<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\DiscordHelper;
use App\Helpers\EmailHelper;

class GoogleController extends Controller
{
    protected $discordHelper;
    protected $emailHelper;

    public function __construct()
    {
        $this->discordHelper = new DiscordHelper();
        $this->emailHelper = new EmailHelper();
    }

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
                $this->discordHelper->sendMessage("Usuario ha iniciado sesión: {$user->email} en {$dateTime}");
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
                $this->emailHelper->sendEmail($user);

                $this->discordHelper->sendMessage("Nuevo registro a través de Google: {$user->email} en {$dateTime}");
            }

            return redirect()->route('usuarios.index')->with('success', 'Has iniciado sesión correctamente');
        } catch (\Exception $e) {
            Log::error('Google login error:', ['message' => $e->getMessage()]);
            return redirect()->route('auth.google')->with('error', 'Error al iniciar sesión con Google.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
