<x-layout-home> 
    <div class="p-3 bg-gray-100">
        <div class="m-6">
            <h1 class="flex font-bold text-gray-800 justify-center">Dashboard</h1>
        </div>

        <div>
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-4">
                    <span class="font-semibold">¡Éxito! </span>{{ session('success') }}
                </div>
            @endif
        </div>
    </div>


    <section>
        <h2>Loterias</h2>
        
        <div class="container mx-auto mt-10">
            <h1 class="text-4xl font-semibold text-gray-800 mb-6">Loterías Disponibles</h1>
    
            <div class="mb-4">
                <a href="{{ route('lotteries.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    Crear Nueva Lotería
                </a>
            </div>
    
            <div class="overflow-x-auto shadow-lg rounded-lg">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Fecha de Sorteo</th>
                            <th class="px-4 py-2 text-left">Precio</th>
                            <th class="px-4 py-2 text-left">Premio</th>
                            <th class="px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lotteries as $lottery)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $lottery->name }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($lottery->date_play)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">${{ number_format($lottery->price, 2) }}</td>
                                <td class="px-4 py-2">{{ $lottery->prize }}</td>
                                <td class="px-4 py-2 text-center">
                                    
                                    <form action="{{ route('lotteries.destroy', $lottery->id) }}" method="POST" class="inline ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('lotteries.show', $lottery->id) }}" class="btn btn-sm btn-info">Ver detalles</a>
                                        <a href="{{ route('lotteries.edit', $lottery->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
            <div class="mt-4">
                {{ $lotteries->links() }}
            </div>
        </div>
    </section>

    @role('admin')
    <section>
        <h2>Usuarios</h2>
        
        <div class="container mx-auto mt-10">
            <h1 class="text-4xl font-semibold text-gray-800 mb-6">Lista de Usuarios</h1>

            @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <a href="{{ route('usuarios.trashed') }}" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">
                    Ver usuarios eliminados
                </a>
                <a href="{{ route('usuarios.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    Agregar Usuario
                </a>
            </div>

            <!-- Tabla de usuarios -->
            <div class="overflow-x-auto shadow-lg rounded-lg">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">NOMBRES</th>
                            <th class="px-4 py-2 text-left">APELLIDOS</th>
                            <th class="px-4 py-2 text-left">CORREO</th>
                            <th class="px-4 py-2 text-left">DIRECCION</th>
                            <th class="px-4 py-2 text-left">ROLES</th>
                            <th class="px-4 py-2 text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $user->id }}</td>
                                <td class="px-4 py-2">{{ $user->names }}</td>
                                <td class="px-4 py-2">{{ $user->lastnames }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">{{ $user->address }}</td>
                                <td class="px-4 py-2">
                                    {{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No asignado' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('usuarios.show', $user->id) }}" class="btn btn-sm btn-info">ver detalles</a>
                                        <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </section>
    @endrole

</x-layout-home>
