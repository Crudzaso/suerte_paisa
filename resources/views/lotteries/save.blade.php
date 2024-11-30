<x-layout-home>
    <div class="container mt-4 mb-4">
        <h1 class="mb-4">{{ isset($lottery) ? 'Editar Lotería' : 'Agregar Lotería' }}</h1>

        <!-- Mensajes de error y éxito -->
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

        <!-- Formulario para crear o editar lotería -->
        <form action="{{ isset($lottery) ? route('lotteries.update', $lottery->id) : route('lotteries.store') }}" method="POST" class="p-4 border rounded shadow-sm">
            @csrf
            @if(isset($lottery))
                @method('PUT')
            @endif

            <!-- Nombre de la Lotería -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la Lotería</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $lottery->name ?? '') }}" placeholder="Ingresa el nombre de la lotería">
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" placeholder="Ingresa una descripción para la lotería">{{ old('description', $lottery->description ?? '') }}</textarea>
            </div>

            <!-- URL del Banner -->
            <div class="mb-3">
                <label for="banner_url" class="form-label">URL del Banner</label>
                <input type="text" class="form-control" id="banner_url" name="banner_url" value="{{ old('banner_url', $lottery->banner_url ?? '') }}" placeholder="URL del banner">
            </div>

            <!-- URL del Logo -->
            <div class="mb-3">
                <label for="logo_url" class="form-label">URL del Logo</label>
                <input type="text" class="form-control" id="logo_url" name="logo_url" value="{{ old('logo_url', $lottery->logo_url ?? '') }}" placeholder="URL del logo">
            </div>

            <!-- Fecha del Sorteo -->
            @role('admin')
            <div class="mb-3">
                <label for="date_play" class="form-label">Fecha del Sorteo</label>
                <input type="date" class="form-control" id="date_play" name="date_play" value="{{ old('date_play', $lottery->date_play ?? '') }}" placeholder="Fecha del sorteo">
            </div>

            <div class="mb-3">
                <label for="prize" class="form-label">Premio</label>
                <input type="text" class="form-control" id="prize" name="prize" value="{{ old('prize', $lottery->prize ?? '') }}" placeholder="Premio de la lotería">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $lottery->price ?? '') }}" placeholder="Precio de la lotería">
            </div>
            @else
            <div class="mb-3">
                <label for="date_play" class="form-label">Fecha del Sorteo</label>
                <input type="text" class="form-control" id="date_play" value="{{ old('date_play', $lottery->date_play ?? '') }}" disabled>
            </div>

            <div class="mb-3">
                <label for="prize" class="form-label">Premio</label>
                <input type="text" class="form-control" id="prize" value="{{ old('prize', $lottery->prize ?? '') }}" disabled>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="text" class="form-control" id="price" value="{{ old('price', $lottery->price ?? '') }}" disabled>
            </div>
            @endrole

            <!-- Botones de acción -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ isset($lottery) ? 'Actualizar Lotería' : 'Crear Lotería' }}
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-times-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</x-layout-home>
