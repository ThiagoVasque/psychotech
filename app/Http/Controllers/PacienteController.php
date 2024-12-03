<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Doutor;
use App\Models\DoutorServico;
use App\Models\Consulta;

class PacienteController extends Controller
{
    // Método para exibir a página inicial do paciente
    public function home()
    {
        return view('paciente.home');
    }

    // Método para gerenciar o perfil do paciente
    public function gerencia()
    {
        // Obtém o paciente logado
        $paciente = Auth::user();

        // Passa o paciente para a view
        return view('paciente.gerencia_perfil', compact('paciente'));
    }

    // Método para exibir as consultas agendadas
    public function consultas()
    {
        $paciente = Auth::user();

        $consultas = Consulta::where('paciente_cpf', $paciente->cpf)->get();

        return view('paciente.consultas', compact('paciente', 'consultas'));
    }

    // Método para exibir os serviços dos doutores
    public function doutores()
    {
        $doutores = Doutor::with('servicos')->get();

        return view('paciente.servicos', compact('doutores'));
    }

    // Método para exibir e criar anotações
    public function anotacoes()
    {
        $paciente = Auth::user();
        return view('paciente.anotacoes', compact('paciente'));
    }

    // Método para exibir o histórico de sessões
    public function historico()
    {
        $paciente = Auth::user();
        return view('paciente.historico', compact('paciente'));
    }

    // Método para atualizar os dados do perfil do paciente
    public function atualizarPerfil(Request $request)
    {
        // Validar os dados do formulário
        $request->validate([
            'nome' => 'string|max:255',
            'telefone' => 'string|max:20',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tamanho máximo da imagem
            'cep' => 'nullable|string|max:9',
            'bairro' => 'nullable|string|max:255',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
        ]);

        $paciente = Auth::user(); // Obter o paciente autenticado

        // Atualizar os dados básicos do paciente
        $paciente->nome = $request->input('nome');
        $paciente->telefone = $request->input('telefone');

        // Atualizar os dados do endereço
        $paciente->cep = $request->input('cep');
        $paciente->bairro = $request->input('bairro');
        $paciente->logradouro = $request->input('logradouro');
        $paciente->numero = $request->input('numero');
        $paciente->complemento = $request->input('complemento');
        $paciente->cidade = $request->input('cidade');
        $paciente->estado = $request->input('estado');

        // Verificar se foi carregada uma nova foto de perfil
        if ($request->hasFile('foto_perfil')) {
            // Excluir a foto antiga, se houver
            if ($paciente->foto_perfil && Storage::exists('public/fotos_perfil/' . $paciente->foto_perfil)) {
                Storage::delete('public/fotos_perfil/' . $paciente->foto_perfil);
            }

            // Salvar a nova foto no diretório correto dentro de public/storage
            $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');

            // Salvar apenas o nome do arquivo, sem o diretório completo
            $paciente->foto_perfil = basename($path);
        }

        // Salvar as alterações no banco de dados
        $paciente->save();

        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('paciente.gerencia_perfil')->with('success', 'Perfil atualizado com sucesso!');
    }



}
