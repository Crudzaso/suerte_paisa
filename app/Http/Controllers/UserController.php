<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateFormRequest;
use App\Http\Requests\UserUpdateFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Helpers\DiscordHelper;
use App\Helpers\EmailHelper;

class UserController extends Controller
{
    protected $discordHelper;
    protected $emailHelper;

    public function __construct()
    {
        $this->discordHelper = new DiscordHelper();
        $this->emailHelper = new EmailHelper();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::paginate(10);
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar los usuarios.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateFormRequest $request)
    {
        $user = User::create([
            'names' => $request->names,
            'lastnames' => $request->lastnames,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
        ]);

        // Envía el correo electrónico al nuevo usuario
        $this->emailHelper->sendEmail($user);

        $dateTime = now()->format('Y-m-d h:i A');
        $creator = Auth::user();

        $this->discordHelper->sendMessage("Usuario creado con el email: {$user->email} por {$creator->names} {$creator->lastnames} en {$dateTime}");

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar el usuario.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateFormRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->names = $request->input('names');
            $user->lastnames = $request->input('lastnames');
            if ($request->input('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->address = $request->input('address');
            $user->save();

            $dateTime = now()->format('Y-m-d h:i A');
            $updater = Auth::user();

            $this->discordHelper->sendMessage("Usuario actualizado con el email: {$user->email} por {$updater->names} {$updater->lastnames} en {$dateTime}");

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el usuario.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $currentUser = Auth::user(); 

            $user->delete();

            $this->discordHelper->sendMessage("Usuario eliminado con el email: {$user->email} por {$currentUser->names} {$currentUser->lastnames}");

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Error al eliminar el usuario.');
        }
    }

    public function trashed()
    {
        try {
            $users = User::onlyTrashed()->paginate(10);
            return view('users.trashed', compact('users'));
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar los usuarios eliminados.');
        }
    }

    public function restore(string $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $currentUser = Auth::user(); 
            $user->restore();

            $this->discordHelper->sendMessage("Usuario restaurado con el email: {$user->email} por {$currentUser->names} {$currentUser->lastnames}");

            return redirect()->route('usuarios.index')->with('success', 'Usuario restaurado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Error al restaurar el usuario.');
        }
    }
}
