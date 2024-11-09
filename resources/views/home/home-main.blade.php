
<x-layout-home>
       
<section class="first-baner">
    <h2>Suerte Paisa</h2>
    <p>Tu oportunidad de ganar al estilo paisa</p>
</section>
<section class="hero-image">
</section>
<section class="active-loteries">
    <h3>Sorteos activos</h3>

    {{-- -----------------------COMPONETIZAR-------------------------- --}}
    <article class="container-active-loteries">
        <div class="card-lotery">
            <div class="color-card">

            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>TITULO DE LA RIFA</h4>
            <p>Juega: fecha de juego</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>

        <div class="card-lotery">
            <div class="color-card">
            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>TITULO DE LA RIFA</h4>
            <p>Juega: fecha de juego</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>

        <div class="card-lotery">
            <div class="color-card">
            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>TITULO DE LA RIFA</h4>
            <p>Juega: fecha de juego</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>

        <div class="card-lotery">
            <div class="color-card">
            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>TITULO DE LA RIFA</h4>
            <p>Juega: fecha de juego</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>

        <div class="card-lotery">
            <div class="color-card">
            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>TITULO DE LA RIFA</h4>
            <p>Juega: fecha de juego</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>

        <div class="card-lotery">
            <div class="color-card">

            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>TITULO DE LA RIFA</h4>
            <p>Juega: fecha de juego</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>

        <div class="card-lotery">
            <div class="color-card">

            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>TITULO DE LA RIFA</h4>
            <p>Juega: fecha de juego</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>

        <div class="card-lotery">
            <div class="color-card">

            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>TITULO DE LA RIFA</h4>
            <p>Juega: fecha de juego</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>
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
        <img src="{{ asset('images/laws7webp') }}" alt="">
    </article>
</section>

<script src="{{ asset('js/avalibleLoteries.js') }}"></script>
</x-layout-home>