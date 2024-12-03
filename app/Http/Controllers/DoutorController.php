<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Consulta;

class DoutorController extends Controller
{
    public function __construct()
    {
        // Garantir que apenas doutores possam acessar essas rotas
        $this->middleware('auth:doutor');  // Protege as rotas para doutores
    }

    public function home()
    {
        // O usuário será automaticamente um doutor após o login
        $doutor = Auth::user();
        return view('doutor.home', compact('doutor'));
    }

    public function consultas()
    {
        // Obtém o doutor logado
        $doutor = Auth::user();

        // Recupere as consultas agendadas para o doutor logado
        $consultas = Consulta::where('doutor_cpf', $doutor->cpf)->get();

        // Retorne a view com as consultas do doutor
        return view('doutor.consultas', compact('consultas'));
    }

    public function servicos()
    {
        // Obtém o doutor logado
        $doutor = Auth::user();

        // Retorna a view com os dados do doutor
        return view('doutor.servicos', compact('doutor'));
    }

    public function relatorios()
    {
        // Obtém o doutor logado
        $doutor = Auth::user();

        // Retorna a view de relatórios do doutor
        return view('doutor.relatorios', compact('doutor'));
    }

    // Método para gerenciar e exibir o perfil do doutor
    public function gerencia()
    {
        // Obtém o doutor logado
        $doutor = Auth::user();

        // Passa os dados do doutor para a view
        return view('doutor.gerencia_perfil', compact('doutor'));
    }

    // Método para atualizar o perfil do doutor
    public function atualizarPerfil(Request $request)
    {
        // Validar os dados do formulário
        $request->validate([
            'nome' => 'string|max:255',
            'telefone' => 'string|max:20',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tamanho máximo da imagem
        ]);

        // Obtém o doutor logado
        $doutor = Auth::user();

        // Atualiza os dados do doutor
        $doutor->nome = $request->input('nome');
        $doutor->telefone = $request->input('telefone');

        // Verifica se foi carregada uma nova foto de perfil
        if ($request->hasFile('foto_perfil')) {
            // Excluir a foto antiga, se houver
            if ($doutor->foto_perfil && Storage::exists('public/fotos_perfil/' . $doutor->foto_perfil)) {
                Storage::delete('public/fotos_perfil/' . $doutor->foto_perfil);
            }

            // Salvar a nova foto no diretório correto dentro de public/storage
            $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');

            // Salvar apenas o nome do arquivo, sem o diretório completo
            $doutor->foto_perfil = basename($path);
        }

        // Salva as alterações
        $doutor->save();

        return redirect()->route('doutor.gerencia_perfil')->with('success', 'Perfil atualizado com sucesso!');
    }
}
