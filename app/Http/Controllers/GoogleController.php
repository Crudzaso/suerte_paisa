<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\EmailHelperGlobal;
use App\Service\DiscordWebhookService;
use App\Events\UserLogin;
use App\Events\UserCreated;
use App\Events\ErrorOccurred;
use Spatie\Permission\Models\Role;

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
            
            $user = User::withTrashed()->where('email', $user_google->email)->first();

            if ($user) {
                if ($user->trashed()) {
                    $user->restore();
                }

                Auth::login($user);
                event(new UserLogin($user));
                $this->emailHelper::sendLoginNotification($user);
            } else {
                DB::transaction(function () use ($user_google, &$user) {
                    $user = User::create([
                        'names' => $user_google->name,
                        'email' => $user_google->email,
                    ]);

                    GoogleUser::create([
                        'email' => $user_google->email,
                        'name' => $user_google->name,
                        'user_id' => $user->id,
                    ]);

                    $roleId = Role::where('name', 'user')->first()->id;
                    $user->roles()->attach($roleId);
                });

                Auth::login($user);
                $this->emailHelper::sendWelcomeEmail($user);
                event(new UserCreated($user));
            }

            return redirect()->route('home')->with('success', 'Has iniciado sesión correctamente.');
        } catch (\Exception $e) {
            
            event(new ErrorOccurred('Error al iniciar sesión con Google', $e->getMessage()));
            return redirect()->route('auth.google')->with('error', 'Error al iniciar sesión con Google.');
        }
    }
}
