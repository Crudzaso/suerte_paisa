@extends('layouts.layout-prueba')

@section('content')
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="display-4 text-primary">Lista de Loterías</h1>
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
            <a href="{{ route('loterias.trashed') }}" class="btn btn-warning me-2">Ver loterías eliminadas</a>
            <a href="{{ route('loterias.create') }}" class="btn btn-success">Agregar Lotería</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>DESCRIPCIÓN</th>
                        <th>FECHA DE JUEGO</th>
                        <th>PRECIO</th>
                        <th>RESULTADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($loterias as $loteria)

                    <tr>
                        <td>{{ $loteria->id }}</td>
                        <td>{{ $loteria->name }}</td>
                        <td>{{ $loteria->description ?? 'No disponible' }}</td>
                        <td>{{ $loteria->date_play->format('d-m-Y') }}</td>
                        <td>{{ $loteria->price }} $</td>
                        <td>{{ $loteria->result ?? 'No disponible' }}</td>
                        <td>
                            <form action="{{ route('loterias.destroy', $loteria->id) }}" method="post" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('loterias.show', $loteria->id) }}" class="btn btn-sm btn-info me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles">
                                    Detalles
                                </a>
                                <a href="{{ route('loterias.edit', $loteria->id) }}" class="btn btn-sm btn-warning me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar lotería">
                                    Editar
                                </a>
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar lotería">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay loterías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $loterias->links() }}
        </div>
    </div>
@endsection
