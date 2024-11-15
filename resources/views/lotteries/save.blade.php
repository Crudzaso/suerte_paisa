@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($lottery) ? 'Editar Lotería' : 'Agregar Lotería' }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Se encontraron algunos problemas:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($lottery) ? route('lotteries.update', $lottery->id) : route('lotteries.store') }}" method="POST">
        @csrf
        @if(isset($lottery))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $lottery->name ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $lottery->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="date_play" class="form-label">Fecha de Juego</label>
            <input type="date" class="form-control" id="date_play" name="date_play" value="{{ old('date_play', $lottery->date_play ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="result" class="form-label">Resultado</label>
            <input type="text" class="form-control" id="result" name="result" value="{{ old('result', $lottery->result ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="prize" class="form-label">Premio</label>
            <input type="text" class="form-control" id="prize" name="prize" value="{{ old('prize', $lottery->prize ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $lottery->price ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($lottery) ? 'Actualizar Lotería' : 'Crear Lotería' }}</button>
        <a href="{{ route('lotteries.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
