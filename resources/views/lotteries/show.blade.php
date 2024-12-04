<x-layout-home>
    <div class="container mt-4 mb-4">
        <h1 class="mb-4">Detalles de la Lotería: {{ $lottery->name }}</h1>

        <!-- Mensajes de éxito o error -->
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

        <div class="mb-4">
            <div class="row">
                <!-- Nombre de la Lotería -->
                <div class="col-md-6">
                    <h4><strong>Nombre:</strong> {{ $lottery->name }}</h4>
                </div>

                <!-- Descripción de la Lotería -->
                <div class="col-md-6">
                    <h4><strong>Descripción:</strong> {{ $lottery->description ?? 'No disponible' }}</h4>
                </div>
            </div>

            <div class="row">
                <!-- Fecha del Sorteo -->
                <div class="col-md-6">
                    <h4><strong>Fecha de Sorteo:</strong> {{ \Carbon\Carbon::parse($lottery->date_play)->format('d/m/Y') }}</h4>
                </div>

                <!-- Premio -->
                <div class="col-md-6">
                    <h4><strong>Premio:</strong> {{ $lottery->prize ?? 'No especificado' }}</h4>
                </div>
            </div>

            <div class="row">
                <!-- Precio -->
                <div class="col-md-6">
                    <h4><strong>Precio:</strong> ${{ number_format($lottery->price, 2) }}</h4>
                </div>

                <!-- URL del Banner -->
                <div class="col-md-6">
                    <h4><strong>URL del Banner:</strong> <a href="{{ $lottery->banner_url }}" target="_blank">{{ $lottery->banner_url }}</a></h4>
                </div>
            </div>

            <div class="row">
                <!-- URL del Logo -->
                <div class="col-md-6">
                    <h4><strong>URL del Logo:</strong> <a href="{{ $lottery->logo_url }}" target="_blank">{{ $lottery->logo_url }}</a></h4>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('lotteries.edit', $lottery->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form action="{{ route('lotteries.destroy', $lottery->id) }}" method="POST" class="inline ml-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('lotteries.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>
</x-layout-home>
