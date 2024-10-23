<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário Virtual</title>
</head>
<body>
    <h1>Diário Virtual</h1>

    <form action="{{ route('diarios.store') }}" method="POST">
        @csrf
        <label for="entrada">Entrada:</label><br>
        <textarea id="entrada" name="entrada" rows="4" placeholder="Escreva sua entrada aqui..." required></textarea><br><br>

        <button type="submit">Salvar Entrada</button>
    </form>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
</body>
</html>
