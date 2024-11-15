<x-layout-home>
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
            confirmButtonText: 'Intentalo despues'
        });
    </script>
@endif
    <section class="content-top">
        <img src="{{$lottery->logo_url}}" alt="">
        <p>Juega el: {{$lottery->date_play}}</p>
    </section>

    <section class="hero">
        <h2>
           {{$lottery->name}}
        </h2>
            <img class="hero-image-details" src="{{$lottery->banner_url}}" alt="">
    </section>

    <section class="details-section-lott">
        <article>
            <h3>Gana {{ $lottery->prize }} en un solo juego!</h3>
        <p>
            {{$lottery->description}}
        </p>
        </article>
    </section>
    
    <section class="button-section">
        @auth()
        <form action="{{ route('assign.number') }}" method="POST">
            @csrf
            <input type="hidden" name="lottery_id" value="{{ $lottery->id }}">
        
            <button type="submit" class="btn btn-primary">Comprar Número</button>
        </form>
        @endauth

        @guest()
        <a href="/login">Comprar</a>
        @endguest
    </section>
</x-layout-home>