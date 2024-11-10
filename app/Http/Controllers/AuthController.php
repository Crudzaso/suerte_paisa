<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Helpers\EmailHelperGlobal;
use App\Service\DiscordWebhookService;
use App\Events\UserLogin;
use App\Events\UserCreated;

class AuthController extends Controller
{
    /**
     * Handle the login request.
     */

    public function registro(Request $request)
    {
        $validatedData = $request->validate([
            'names' => 'required|string|max:255',
            'lastnames' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', 
            'address' => 'required|string|max:255',
        ]);

        $user = User::create([
            'names' => $validatedData['names'],
            'lastnames' => $validatedData['lastnames'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'address' => $validatedData['address'],
        ]);
        
        Auth::login($user);

        event(new UserCreated($user));

        return redirect()->route('home')->with('success', 'Registro exitoso!');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            event(new UserLogin($user));
            return redirect()->route('home');  
        } else {
            
        }
        return redirect()->route('login')->with('error', 'Correo electrónico o contraseña incorrectos.');
    }
}
