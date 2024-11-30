<x-layout-home>
    <div class="container mt-4 mb-4">
        <h1 class="mb-4">{{ isset($user) ? 'Editar Usuario' : 'Agregar Usuario' }}</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-triangle"></i> Se encontraron algunos problemas:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($user) ? route('usuarios.update', $user->id) : route('usuarios.store') }}" method="POST" class="p-4 border rounded shadow-sm">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="names" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="names" name="names" value="{{ old('names', $user->names ?? '') }}" placeholder="Ingresa los nombres del usuario">
            </div>

            <div class="mb-3">
                <label for="lastnames" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="lastnames" name="lastnames" value="{{ old('lastnames', $user->lastnames ?? '') }}" placeholder="Ingresa los apellidos del usuario">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="ejemplo@correo.com">
            </div>

            @if(!isset($user))
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa una contraseña">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirma tu contraseña">
                </div>
            @endif

            <div class="mb-3">
                <label for="address" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address ?? '') }}" placeholder="Dirección del usuario">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-control" id="role" name="role">
                    <option value="">Selecciona un rol</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role', isset($user) && $user->roles->isNotEmpty() ? $user->roles->first()->id : '') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ isset($user) ? 'Actualizar Usuario' : 'Crear Usuario' }}
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-times-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</x-layout-home>
