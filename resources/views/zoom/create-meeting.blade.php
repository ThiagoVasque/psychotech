<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reunião Zoom</title>
</head>
<body>
    @if(isset($meeting))
        <h1>Reunião Criada com Sucesso!</h1>
        <p>Tópico: {{ $meeting['topic'] }}</p>
        <p>ID da Reunião: {{ $meeting['id'] }}</p>
        <p>Link da Reunião: <a href="{{ $meeting['join_url'] }}">{{ $meeting['join_url'] }}</a></p>
        <p>Iniciar Reunião (Host): <a href="{{ $meeting['start_url'] }}">Iniciar Reunião</a></p>
    @else
        <h1>Erro ao Criar Reunião</h1>
        <p>{{ $error }}</p>
    @endif
</body>
</html>
