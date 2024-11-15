<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Lista de Loterías</title>
</head>
<body>
<div class="container">
    <h2 class="mt-4">Lista de Loterías</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            <strong>Bien hecho!</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <!-- Botón de Logout -->
    <form action="{{ route('logout') }}" method="POST" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
    </form>

    <div class="mb-3">
        <a href="{{ route('lotteries.create') }}" class="btn btn-success">Agregar Lotería</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>DESCRIPCIÓN</th>
                <th>FECHA DE JUEGO</th>
                <th>RESULTADO</th>
                <th>PREMIO</th>
                <th>ACCIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lotteries as $lottery)
               <tr>
                   <td>{{ $lottery->id }}</td>
                   <td>{{ $lottery->name }}</td>
                   <td>{{ $lottery->description }}</td>
                   <td>{{ $lottery->date_play }}</td>
                   <td>{{ $lottery->result }}</td>
                   <td>{{ $lottery->prize }}</td>
                   <td>
                       <form action="{{ route('lotteries.destroy', $lottery->id) }}" method="post">
                           @method('DELETE')
                           @csrf
                           <a href="{{ route('lotteries.show', $lottery->id) }}" class="btn btn-sm btn-info">Detalles</a>
                           <a href="{{ route('lotteries.edit', $lottery->id) }}" class="btn btn-sm btn-warning">Editar</a>
                           <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                       </form>
                   </td>
               </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $lotteries->links() }}
</div>
</body>
</html>
