
<x-layout-home>
       
<section class="first-baner">
    <h2>Suerte Paisa</h2>
    <p>Tu oportunidad de ganar al estilo paisa</p>
</section>
<section class="hero-image">
</section>
<section class="active-loteries">
    <h3>Sorteos activos</h3>
    <article  class="container-active-loteries">
    @foreach ($lotteries as $lottery)
    
    @if ($lottery->result == null)
    <div class="card-lotery">
        <div class="color-card">
        </div>
        <div class="content-card">
            <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
        <h4>{{$lottery->name}}</h4>
        <p>{{$lottery->date_play}}</p>
        <a class="btn-card" href="/detalles/{{$lottery->id}}">Jugar!</a>
        </div>
    </div>
    @endif
    @endforeach

    </article>
</section>

{{-- ---------------------------------------------- --}}

<section class="information-container">
    <article class="left-information-container">

    </article>
    <article class="right-information-container">
        
    </article>
</section>

<section class="active-loteries">
    <h3>Sorteos finalizados</h3>
    <article id="container-active-loteries" class="container-active-loteries">
        {{-- CONTENT FROM JS --}}

        {{-- CONTENT FROM CONTROLLER --}}
        @foreach ($lotteries as $lottery)
            @if ($lottery->result ==! null)
            <div class="card-lotery">
                <div class="color-card">
                </div>
                <div class="content-card">
                    <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
                <h4>{{$lottery->name}}</h4>
                <p>{{$lottery->date_play}}</p>
                <p>Resultado: {{$lottery->result}}</p>
                </div>
            </div>
            @endif
        @endforeach
            </div>
        </div>
        
    </article>
</section>

<section class="transparency-container">
    <article class="company-transapency">
        <img src="{{ asset('images/rules1.jpg') }}" alt="">
        <img src="{{ asset('images/rules2.jpg') }}" alt="">
        <img src="{{ asset('images/rules3.jpg') }}" alt="">
        <img src="{{ asset('images/rules4.jpg') }}" alt="">
        <img src="{{ asset('images/rules5.jpg') }}" alt="">

    </article>
</section>

<section class="transparency-container">
    <article class="company-laws">
        <img src="{{ asset('images/laws1.webp') }}" alt="">
        <img src="{{ asset('images/laws2.webp') }}" alt="">
        <img src="{{ asset('images/laws3.webp') }}" alt="">
        <img src="{{ asset('images/laws4.webp') }}" alt="">
        <img src="{{ asset('images/laws5.webp') }}" alt="">
        <img src="{{ asset('images/laws6.webp') }}" alt="">

        <img src="{{ asset('images/laws7.webp') }}" alt="">

    </article>
</section>

<script src="{{ asset('js/avalibleLoteries.js') }}"></script>
</x-layout-home>