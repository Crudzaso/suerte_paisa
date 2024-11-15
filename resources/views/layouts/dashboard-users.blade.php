@extends('layouts.layout-prueba')

@section('content')
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="display-4 text-primary">Lista de Usuarios</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success text-center">
                <strong>Bien hecho!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        <div class="d-flex justify-content-center mb-4">
            <form action="{{ route('logout') }}" method="POST" class="me-2">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
            </form>
            <a href="{{ route('usuarios.trashed') }}" class="btn btn-warning me-2">Ver usuarios eliminados</a>
            <a href="{{ route('usuarios.create') }}" class="btn btn-success">Agregar Usuario</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>NOMBRES</th>
                        <th>APELLIDOS</th>
                        <th>CORREO</th>
                        <th>DIRECCION</th>
                        <th>ROLES</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->names }}</td>
                        <td>{{ $user->lastnames }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No asignado' }}</td>
                        <td>
                            <form action="{{ route('usuarios.destroy', $user->id) }}" method="post" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('usuarios.show', $user->id) }}" class="btn btn-sm btn-info me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles">
                                    Detalles
                                </a>
                                <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-warning me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar usuario">
                                    Editar
                                </a>
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar usuario">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection
