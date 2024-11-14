<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Doutor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Proner\Cpf;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Exibe o formulário de registro.
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // Certifique-se de que a view 'auth.register' existe
    }

    /**
     * Realiza o registro de um novo usuário.
     */
    public function register(Request $request)
    {
        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::in(['doutor', 'paciente'])],
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date_format:d/m/Y',
            'cep' => 'required|string|max:255',
            'cpf' => [
                'required',
                'string',
                'max:255',
                'unique:pacientes,cpf',
                'unique:doutores,cpf',
                function ($attribute, $value, $fail) {
                    // Valida o CPF com a biblioteca Proner
                    if (!Cpf::validate($value)) {
                        $fail('O CPF informado é inválido.');
                    }
                }
            ],
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

        // Se a validação falhar, retornamos com erros
        if ($validator->fails()) {
            \Log::error('Validação falhou: ', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Convertendo data de nascimento para o formato do banco
        $dataNascimento = Carbon::createFromFormat('d/m/Y', $request->data_nascimento)->format('Y-m-d');

        // Coletando dados do request para salvar no banco
        $data = $request->only([
            'nome',
            'cep',
            'bairro',
            'logradouro',
            'numero',
            'complemento',
            'cidade',
            'estado',
            'telefone',
            'email'
        ]);

        // Remove os caracteres de formatação do CPF
        $cpf = preg_replace('/[^\d]/', '', $request->cpf);

        // Adicionando CPF, data de nascimento e senha ao array de dados
        $data['cpf'] = $cpf;
        $data['data_nascimento'] = $dataNascimento;
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->role; // Adicionando o campo role

        // Verifica a role do usuário e cria o registro nas tabelas corretas
        try {
            if ($request->role === 'doutor') {
                $data['crm'] = $request->crm; // Adiciona o CRM apenas para doutores
                Doutor::create($data); // Salva na tabela doutores
            } else {
                Paciente::create($data); // Salva na tabela pacientes
            }

            // Redireciona para a página inicial com sucesso
            return redirect()->route('login')->with('success', 'Registro realizado com sucesso! Faça login.');
        } catch (\Exception $e) {
            \Log::error('Erro ao realizar o registro: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Erro ao realizar o registro. Tente novamente.'])->withInput();
        }
    }
}
