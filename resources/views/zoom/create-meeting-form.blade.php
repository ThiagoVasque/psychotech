<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Criar Reunião Zoom</title>
</head>

<body>
    <h1>Criar Reunião no Zoom</h1>

    @if (isset($meeting))
        <h2>Reunião criada com sucesso!</h2>
        <p><strong>Tópico:</strong> {{ $meeting['topic'] }}</p>
        <p><strong>Data e Hora:</strong> {{ \Carbon\Carbon::parse($meeting['start_time'])->format('d/m/Y H:i') }}</p>
        <p><strong>Duração:</strong> {{ $meeting['duration'] }} minutos</p>
        <p><strong>Link para a Reunião:</strong> <a href="{{ $meeting['join_url'] }}"
                target="_blank">{{ $meeting['join_url'] }}</a></p>
    @elseif (isset($error))
        <p style="color: red;">{{ $error }}</p>
    @endif

    <form action="/zoom/create-meeting" method="POST">
        @csrf
        <label for="topic">Tópico da Reunião:</label>
        <input type="text" id="topic" name="topic" placeholder="Tópico da Reunião"><br><br>

        <label for="start_time">Data e Hora:</label>
        <input type="datetime-local" id="start_time" name="start_time"><br><br>

        <label for="duration">Duração (minutos):</label>
        <input type="number" id="duration" name="duration" placeholder="Duração em minutos"><br><br>

        <button type="submit">Criar Reunião</button>
    </form>
</body>

</html>