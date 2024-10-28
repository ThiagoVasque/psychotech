<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Doutor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Certifique-se de que esta view existe
    }

    public function register(Request $request)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::in(['doutor', 'paciente'])],
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cep' => 'required|string|max:255',
            'cpf' => 'required|string|max:255|unique:pacientes,cpf|unique:doutores,cpf',
            'bairro' => 'required|string|max:255',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'telefone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pacientes,email|unique:doutores,email',
            'password' => 'required|string|min:8|confirmed',
            'crm' => [
                'nullable',
                Rule::unique('doutores', 'crm')->where(function ($query) use ($request) {
                    return $request->role === 'doutor';
                }),
            ],
        ]);

        if ($validator->fails()) {
            \Log::error('Validação falhou: ', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Remove os caracteres de formatação do CPF
        $cpf = preg_replace('/[^\d]/', '', $request->cpf);

        try {
            // Coletando os dados para serem salvos
            $data = $request->only([
                'nome', 'data_nascimento', 'cep', 'bairro',
                'logradouro', 'numero', 'complemento', 'cidade',
                'estado', 'telefone', 'email'
            ]);

            // Adicionando CPF e senha ao array de dados
            $data['cpf'] = $cpf;
            $data['password'] = Hash::make($request->password);
            $data['role'] = $request->role; // Adicionando o campo role

            // Criando o usuário na tabela correta
            if ($request->role === 'doutor') {
                $data['crm'] = $request->crm; // Adiciona o CRM apenas para doutores
                Doutor::create($data); // Salva na tabela doutores
            } else {
                Paciente::create($data); // Salva na tabela pacientes
            }

            return redirect()->route('home')->with('success', 'Registro realizado com sucesso! Faça login.');
        } catch (\Exception $e) {
            \Log::error('Erro ao realizar o registro: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Erro ao realizar o registro. Tente novamente.'])->withInput();
        }
    }
}
