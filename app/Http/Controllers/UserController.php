<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserCreateFormRequest;
use App\Http\Requests\UserUpdateFormRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;
use App\Service\DiscordWebhookService;
use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Events\UserDeleted;
use App\Events\UserRestore;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            return redirect()->route('dashboard.users')->with('error', 'Error al cargar los usuarios.');
        }
    }

    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles
        return view('users.save', compact('roles'));
    }

    public function store(UserCreateFormRequest $request)
    {
        try{
            $user = User::create([
                'names' => $request->names,
                'lastnames' => $request->lastnames,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'address' => $request->address,
                'role' => $request->role ?? 'user',
            ]);
    
            if ($request->role) {
                $user->roles()->attach($request->role);
            }
    
            event(new UserCreated($user));
    
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');

        } catch (\Exception $e){
            $this->discordWebhookService->sendErrorToDiscord("Error en el método store: " . $e->getMessage());
            return redirect()->route('dashboard.users')->with('error', 'Error al crear el usuario.');
        }
    }

    public function show(string $id)
    {
        try {
            \Log::info('Buscando usuario con ID: ' . $id);
            
            $user = User::withTrashed()->findOrFail($id);
            
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            \Log::error('Error al buscar usuario con ID: ' . $id);
            $this->discordWebhookService->sendErrorToDiscord("Error en el método show: " . $e->getMessage());
            return redirect()->route('dashboard.users')->with('error', 'Usuario no encontrado.');
        }
    }


    public function edit(string $id)
    {
        try {
            $roles = Role::all();
            $user = User::findOrFail($id);

            return view('users.save', compact('user', 'roles'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método edit: " . $e->getMessage());
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
             $user->email = $request->input('email');
     
             if ($request->input('password')) {
                 $user->password = bcrypt($request->input('password'));
             }

             $user->address = $request->input('address');

             if ($request->input('role')) {
                $user->roles()->sync([$request->input('role')]);
            }
     
             $user->save();
     
             event(new UserUpdated($user));
     
             return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
         } catch (\Exception $e) {
             return redirect()->route('dashboard.users')->with('error', 'Error al actualizar el usuario.');
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
            return redirect()->route('dashboard.users')->with('error', 'Error al eliminar el usuario.');
        }
    }

    public function trashed()
    {
        try {
            // Obtener usuarios eliminados (soft deleted)
            $users = User::onlyTrashed()->paginate(10);
            
            // Si no hay usuarios eliminados, se puede redirigir con un mensaje
            if ($users->isEmpty()) {
                return redirect()->route('usuarios.index')->with('info', 'No hay usuarios eliminados.');
            }

            // Devolver la vista con los usuarios eliminados
            return view('users.trashed', compact('users'));
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->route('dashboard.users')->with('error', 'Error al cargar los usuarios eliminados.');
        }
    }

    public function restore(string $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);

            if ($user->trashed()) {
                $user->restore();
                return redirect()->route('usuarios.trashed')->with('success', 'Usuario restaurado exitosamente.');
            } else {
                return redirect()->route('usuarios.trashed')->with('info', 'El usuario ya está restaurado.');
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard.users')->with('error', 'Error al restaurar el usuario.');
        }
    }


}
