<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\EmailHelperGlobal;
use App\Service\DiscordWebhookService;
use App\Events\UserLogin;
use App\Events\UserCreated;

class GoogleController extends Controller
{
    protected $emailHelper;
    protected $discordWebhookService;

    public function __construct(EmailHelperGlobal $emailHelper, DiscordWebhookService $discordWebhookService)
    {
        $this->emailHelper = $emailHelper;
        $this->discordWebhookService = $discordWebhookService;
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

            if ($user) {
                Auth::login($user);
                event(new UserLogin($user));

                $this->emailHelper::sendLoginNotification($user);
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
                $this->emailHelper::sendWelcomeEmail($user);
                event(new UserCreated($user));
            }

            return redirect()->route('home')->with('success', 'Has iniciado sesión correctamente.');
        } catch (\Exception $e) {
            \Log::error('Google login error:', ['message' => $e->getMessage()]);
            $this->discordWebhookService->sendErrorToDiscord("Error al iniciar sesión con Google: " . $e->getMessage());
            return redirect()->route('auth.google')->with('error', 'Error al iniciar sesión con Google.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('home')->with('success', 'Has cerrado sesión correctamente.');
    }
}

