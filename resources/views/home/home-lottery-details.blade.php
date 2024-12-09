<x-layout-home>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#4CAF50',
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
            confirmButtonColor: '#E53935',
            confirmButtonText: 'Intentar nuevamente'
        });
    </script>
    @endif

    <section class="content-top py-4 text-center bg-gray-50 shadow-sm rounded-md">
        <div class="container">
            <img src="{{ $lottery->logo_url }}" alt="Logo de la Lotería" class="lottery-logo mx-auto rounded-md shadow-md">
            <p class="text-lg text-gray-700 mt-2">
                <i class="bi bi-calendar-check"></i> Juega el: 
                <span class="font-bold">{{ \Carbon\Carbon::parse($lottery->date_play)->format('d/m/Y') }}</span>
            </p>
        </div>
    </section>

    <section class="hero py-6 bg-blue-100 text-center">
        <h2 class="text-3xl font-bold text-blue-800">{{ $lottery->name }}</h2>
        <img src="{{ $lottery->banner_url }}" alt="Banner de la Lotería" class="hero-image-details mt-4 mx-auto rounded-lg shadow-lg w-full md:w-3/4">
    </section>

    <section class="details-section-lott py-8 bg-white">
        <div class="container text-center">
            <article class="max-w-2xl mx-auto">
                <h2 class="text-2xl font-semibold text-gray-800">
                    ¿No sería increíble ganar un premio como un <span class="text-blue-600">{{ $lottery->prize }}</span>?
                </h2>
                <h3 class="mt-4 text-xl text-gray-700">
                    ¡Gana <strong class="text-red-600">{{ $lottery->prize }}</strong> en un solo juego!
                </h3>
                <p class="mt-6 text-gray-600">{{ $lottery->description }}</p>
            </article>
        </div>
    </section>

    <section class="selection-section py-8 bg-gray-50">
        <div class="container">
            <h3 class="text-2xl font-semibold text-center mb-4">Selecciona los números para tu lotería</h3>

            <form action="{{ route('assign.number') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="lottery_id" value="{{ $lottery->id }}">

                <div class="flex flex-wrap justify-center gap-4 mb-6">
                    @for ($i = 1; $i <= $lottery->max_number; $i++)
                        <div class="relative">
                            <input 
                                class="form-check-input absolute opacity-0 cursor-pointer peer"
                                type="checkbox"
                                value="{{ $i }}"
                                id="number-{{ $i }}"
                                name="numbers[]"
                                @if(in_array($i, $purchasedNumbers)) disabled
                                @endif
                            >
                            <label for="number-{{ $i }}" 
                                class="flex items-center justify-center w-12 h-12 border-2
                                    @if(in_array($i, $purchasedNumbers)) bg-red-500 text-white cursor-not-allowed rounded-full
                                    @else bg-blue-100 text-blue-500 font-semibold text-lg rounded-full cursor-pointer
                                    hover:bg-blue-300 peer-checked:bg-green-500 peer-checked:text-white
                                    @endif
                                    transition number-label"
                                data-number="{{ $i }}">
                                {{ $i }}
                            </label>
                        </div>
                    @endfor
                </div>

                <div class="text-center mt-20">
                    <button type="submit" class="btn btn-primary px-6 py-3 rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Comprar Números
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script src="{{ asset('js/choseNumber.js') }}"></script>
</x-layout-home>
