@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card lottery-card">
                <div class="card-body">
                    <h4 class="card-title">Detalles de la Lotería</h4>
                    <ol>
                        <li><strong>Nombre:</strong> {{ $lottery->name }}</li>
                        <li><strong>Descripción:</strong> {{ $lottery->description }}</li>
                        <li><strong>Fecha de Juego:</strong> {{ $lottery->date_play }}</li>
                        <li><strong>Resultado:</strong> {{ $lottery->result }}</li>
                        <li><strong>Premio:</strong> {{ $lottery->prize }}</li>
                        <li><strong>Precio:</strong> ${{ $lottery->price }}</li>
                    </ol>
                    <a href="{{ route('lotteries.index') }}" class="btn btn-secondary">Ir al Index</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
