@extends('layouts.app')

@section('title', 'Loterías Archivadas')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Loterías Archivadas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha de Juego</th>
                <th>Resultado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lotteries as $lottery)
                <tr>
                    <td>{{ $lottery->id }}</td>
                    <td>{{ $lottery->name }}</td>
                    <td>{{ $lottery->description }}</td>
                    <td>{{ $lottery->date_play }}</td>
                    <td>{{ $lottery->result }}</td>
                    <td>
                        <form action="{{ route('lotteries.restore', $lottery->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Restaurar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay loterías archivadas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
