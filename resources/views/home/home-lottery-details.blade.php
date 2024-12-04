<x-layout-home>
    <!-- Mensajes de éxito y error -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33',
                confirmButtonText: 'Intentalo después'
            });
        </script>
    @endif

    <!-- Sección superior con el logo y la fecha de la rifa -->
    <section class="content-top">
        <img src="{{ $lottery->logo_url }}" alt="Logo de la Lotería" class="lottery-logo">
        <p>Juega el: {{ \Carbon\Carbon::parse($lottery->date_play)->format('d/m/Y') }}</p>
    </section>

    <!-- Sección de la Hero con el nombre y el banner de la lotería -->
    <section class="hero">
        <h2>{{ $lottery->name }}</h2>
        <img class="hero-image-details" src="{{ $lottery->banner_url }}" alt="Banner de la Lotería">
    </section>

    <!-- Sección de detalles de la lotería -->
    <section class="details-section-lott">
        <article>
            <h2>No seria increible ganar un premio como un {{ $lottery->prize }}</h2>
            <h3>¡Gana <strong class='text-red-600'>{{ $lottery->prize }}</strong> en un solo juego!</h3>
            <p>{{ $lottery->description }}</p>
        </article>
    </section>

    <!-- Sección para comprar un número -->
    <section class="button-section">
        @auth
            <!-- Formulario para asignar un número a la lotería -->
            <form action="{{ route('assign.number') }}" method="POST">
                @csrf
                <input type="hidden" name="lottery_id" value="{{ $lottery->id }}">
                <button type="submit" class="btn btn-primary">Comprar Número</button>
            </form>
        @endauth

        @guest
            <!-- Enlace para que el usuario inicie sesión -->
            <a href="/login" class="btn btn-secondary">Comprar</a>
        @endguest
    </section>
</x-layout-home>
