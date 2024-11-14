<x-layout-home>
    <h3 class="main-title-user-view">Bienvenido a tu informacion {{$user->names}}</h3>
    <section class="form-container">
        <form action="">
            <label for="name">Nombre</label>
            <input type="text" id="name" placeholder="Ingresa tu nombre" required value="{{$user->names}}">

            <label for="name">Contraseña actual</label>
            <div class="password-container">
                <input type="password" id="current-password" placeholder="Ingresa tu contraseña" required ">
                <button type="button" class="toggle-password" onclick="togglePassword('current-password')"><i class="bi bi-eye-fill i"></i></button>
            </div>

            <label for="email">Correo electronico</label>
            <input type="email" id="email" placeholder="Ingresa tu correo" required value="{{$user->email}}">

            <label for="new-password">Nueva contraseña</label>
            <div class="password-container">
              <input type="password" id="new-password" placeholder="Nueva contraseña" required>
              <button type="button" class="toggle-password" onclick="togglePassword('new-password')"><i class="bi bi-eye-fill i"></i></button>
            </div>
      
            <label for="confirm-password">Confirma la contraseña</label>
            <div class="password-container">
              <input type="password" id="confirm-password" placeholder="Confirmar contraseña" required>
              <button type="button" class="toggle-password" onclick="togglePassword('confirm-password')"><i class="bi bi-eye-fill i"></i></button>
            </div>

            <button type="submit" class="submit-btn">Actualizar perfil</button>
        </form>
    </section>

    <section class="table-purchased-container">
        <h3 class="main-title-user-view">Tus compras</h3>
        <table class="table table-striped table-lotteries-purchased">
            <thead>
              <tr class="table-primary">
                <th scope="col">Resultado</th>
                <th scope="col">Premio</th>
                <th scope="col">Fecha de juego</th>
                <th scope="col">Nombre</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($lotteries as $lottery )
                <tr>
                    @if ($lottery->result == null)
                    <th scope="row ">Por jugar</th>
                    @else
                    <th scope="row ">{{$lottery->result}}</th>
                    @endif
                    <td>{{$lottery->prize}}</td>
                    <td>{{$lottery->date_play}}</td>
                    <td>{{$lottery->name}}</td>
                  </tr>
                @endforeach
            </tbody>
          </table>
    </section>

    <script src="{{ asset('js/formHomeUserInput.js') }}"></script>
</x-layout-home>