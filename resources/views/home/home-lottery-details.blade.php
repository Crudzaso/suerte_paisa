<x-layout-home>
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif
    <section class="content-top">
        <img src="{{$lottery->logo_url}}" alt="">
        <p>Juega el: {{$lottery->date_play}}</p>
    </section>

    <section class="hero">
        <h2>
           {{$lottery->name}} aaaaaaaaaaaaaaaaaaaaa
        </h2>
            <img class="hero-image-details" src="{{$lottery->banner_url}}" alt="">
    </section>

    <section class="details-section-lott">
        <article>
            <h3>Gana {{ $lottery->prize }} en un solo juego!</h3>
        <p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident debitis culpa officia inventore, cumque quidem iste reiciendis laudantium dolores veniam accusantium doloribus animi quos natus illo nisi, hic eveniet modi.
            {{$lottery->description}}
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem consectetur recusandae facilis pariatur ducimus! Alias porro aspernatur placeat nulla! Quae omnis facere dolorum sapiente minima facilis ut illum, ad accusantium.
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