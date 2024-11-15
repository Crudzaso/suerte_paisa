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
            <a href="{{ route('lotteries.trashed') }}" class="btn btn-warning me-2">Ver loterías eliminadas</a>
            <a href="{{ route('lotteries.create') }}" class="btn btn-success">Agregar Lotería</a>
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
                @forelse($lotteries as $lottery)
                    <tr>
                        <td>{{ $lottery->id }}</td>
                        <td>{{ $lottery->name }}</td>
                        <td>{{ $lottery->description ?? 'No disponible' }}</td>
                        <td>{{ $lottery->date_play->format('d-m-Y') }}</td>
                        <td>{{ $lottery->price }} $</td>
                        <td>{{ $lottery->result ?? 'No disponible' }}</td>
                        <td>
                            <form action="{{ route('lotteries.destroy', $lottery->id) }}" method="post" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('lotteries.show', $lottery->id) }}" class="btn btn-sm btn-info me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles">
                                    Detalles
                                </a>
                                <a href="{{ route('lotteries.edit', $lottery->id) }}" class="btn btn-sm btn-warning me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar lotería">
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
            {{ $lotteries->links() }}
        </div>
    </div>
@endsection
