<x-layout-home>
    <h3 class="main-title-user-view">Bienvenido a tu informacion USERNAME</h3>
    <section class="form-container">
        <form action="">
            <label for="name">Nombre</label>
            <input type="text" id="name" placeholder="Ingresa tu nombre" required>

            <label for="name">Contraseña actual</label>
            <div class="password-container">
                <input type="password" id="current-password" placeholder="Ingresa tu contraseña" required>
                <button type="button" class="toggle-password" onclick="togglePassword('current-password')"><i class="bi bi-eye-fill"></i></button>
            </div>

            <label for="email">Correo electronico</label>
            <input type="email" id="email" placeholder="Ingresa tu correo" required>

            <label for="new-password">Nueva contraseña</label>
            <div class="password-container">
              <input type="password" id="new-password" placeholder="Nueva contraseña" required>
              <button type="button" class="toggle-password" onclick="togglePassword('new-password')"><i class="bi bi-eye-fill"></i></button>
            </div>
      
            <label for="confirm-password">Confirma la contraseña</label>
            <div class="password-container">
              <input type="password" id="confirm-password" placeholder="Confirmar contraseña" required>
              <button type="button" class="toggle-password" onclick="togglePassword('confirm-password')"><i class="bi bi-eye-fill"></i></button>
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
              <tr>
                <th scope="row ">Por jugar</th>
                <td>16000 millones</td>
                <td>2020-09-10</td>
                <td>La mejor rifa de riwi</td>
              </tr>
              <tr>
                <th scope="row">2234-311</th>
                <td>carro kia picanto</td>
                <td>2020-09-10</td>
                <td>La mejor rifa de riwi</td>
              </tr>
            </tbody>
          </table>
    </section>

    <script src="{{ asset('js/formHomeUserInput.js') }}"></script>
</x-layout-home>