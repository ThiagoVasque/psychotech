<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Consulta</title>
</head>
<body>
    <h1>Cadastrar Consulta</h1>

    <form action="{{ route('consultas.store') }}" method="POST">
        @csrf
        <label for="paciente_id">Nome do Paciente:</label>
        <select name="paciente_id" id="paciente_id">
            @foreach ($pacientes as $paciente)
                <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
            @endforeach
        </select><br><br>

        <label for="anotacao">Anotação:</label>
        <textarea id="anotacao" name="anotacao" placeholder="Anotações sobre o paciente"></textarea><br><br>

        <label for="data_hora">Data e Hora:</label>
        <input type="datetime-local" id="data_hora" name="data_hora" required><br><br>

        <button type="submit">Cadastrar Consulta</button>
    </form>
</body>
</html>
