<!-- resources/views/errors/403.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 403 - Acceso Prohibido</title>
    <!-- Vinculando Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="text-center p-4 border rounded-3 shadow-lg bg-white">
        <h1 class="display-1 text-danger">403</h1>
        <p class="lead text-muted">Acceso Denegado</p>
        <p class="mb-4">Lo sentimos, no tienes permiso para acceder a esta página.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Volver a la página principal</a>
    </div>
</div>

<!-- Bootstrap JS (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0nX5iFCxVdfA1jvTgAKdO1bDl5LviV8s+kXYpaXWJXzB6mj9" crossorigin="anonymous"></script>
</body>
</html>
