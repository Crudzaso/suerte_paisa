<!DOCTYPE html>
<html>
<head>
    <title>Enviar Correo</title>
</head>
<body>
    <form action="/enviar-correo" method="POST">
        @csrf
        <label for="email">Correo del destinatario:</label>
        <input type="email" name="email" id="email" required>
        <br><br>
        <label for="contenido">Mensaje:</label>
        <textarea name="contenido" id="contenido" rows="5" required></textarea>
        <br><br>
        <button type="submit">Enviar Correo</button>
    </form>
</body>
</html>
