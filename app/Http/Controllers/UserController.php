<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserCreateFormRequest;
use App\Http\Requests\UserUpdateFormRequest;
use Illuminate\Http\Request;
use App\Service\DiscordWebhookService;
use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Events\UserDeleted;
use App\Events\UserRestore;

class UserController extends Controller
{
    protected $discordWebhookService;

    public function __construct(DiscordWebhookService $discordWebhookService)
    {
        $this->discordWebhookService = $discordWebhookService;
    }

    public function index()
    {
        try {
            $users = User::paginate(10);
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método index: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar los usuarios.');
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserCreateFormRequest $request)
    {
        try {
            $user = User::create([
                'names' => $request->names,
                'lastnames' => $request->lastnames,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'address' => $request->address,
            ]);

            event(new UserCreated($user));

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método store: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Error al crear el usuario.');
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método show: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado.');
        }
    }

    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método edit: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar el usuario.');
        }
    }

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

            event(new UserUpdated($user));

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método update: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el usuario.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            event(new UserDeleted($user));

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método destroy: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Error al eliminar el usuario.');
        }
    }

    public function trashed()
    {
        try {
            $users = User::onlyTrashed()->paginate(10);
            return view('users.trashed', compact('users'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método trashed: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar los usuarios eliminados.');
        }
    }

    public function restore(string $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();

            event(new UserRestore($user));

            return redirect()->route('usuarios.index')->with('success', 'Usuario restaurado exitosamente.');
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método restore: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Error al restaurar el usuario.');
        }
    }
}
