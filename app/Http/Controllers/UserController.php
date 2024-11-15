<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserCreateFormRequest;
use App\Http\Requests\UserUpdateFormRequest;
use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Events\UserDeleted;
use App\Events\ErrorOccurred;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::paginate(10);
            return view('layouts.dashboard-users', compact('users'));
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error en el método index', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar los usuarios.');
        }
    }

    public function create()
    {
        return view('users.save');
    }

    public function store(UserCreateFormRequest $request)
    {
        try {
            $user = User::create($request->validated());
            event(new UserCreated($user));
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error al crear el usuario', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Error al crear el usuario.');
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error en el método show', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado.');
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.save', compact('user'));
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error en el método edit', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar el usuario.');
        }
    }

    public function update(UserUpdateFormRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            event(new UserUpdated($user));
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error al actualizar el usuario', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el usuario.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            event(new UserDeleted($user));
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error al eliminar el usuario', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Error al eliminar el usuario.');
        }
    }
}
