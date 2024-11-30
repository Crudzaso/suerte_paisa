<x-layout-home>
    <div class="container mt-4 mb-4">
        <h1 class="mb-4">Detalles del Usuario</h1>

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

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">Información del Usuario</h4>
                <ul class="list-unstyled">
                    <li><strong>Nombres:</strong> {{ $user->names }}</li>
                    <li><strong>Apellidos:</strong> {{ $user->lastnames }}</li>
                    <li><strong>Correo:</strong> {{ $user->email }}</li>
                    <li><strong>Dirección:</strong> {{ $user->address }}</li>
                    <li><strong>Rol:</strong> {{ $user->roles->first()->name }}</li>
                </ul>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Ir al index
                    </a>

                    @if($user->trashed())
                        <form action="{{ route('usuarios.restore', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sync"></i> Restaurar Usuario
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout-home>
