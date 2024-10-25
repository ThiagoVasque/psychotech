<?php

namespace App\Http\Controllers;

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
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::in(['doutor', 'paciente'])],
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cep' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'telefone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pacientes,email|unique:doutores,email',
            'password' => 'required|string|min:8|confirmed',
            'crm' => 'nullable|string|unique:doutores,crm',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Lógica para registro
        try {
            if ($request->role === 'doutor') {
                // Verifica se o CRM foi enviado antes de criar o doutor
                if (empty($request->crm)) {
                    return redirect()->back()->withErrors(['crm' => 'O campo CRM é obrigatório para doutores.'])->withInput();
                }

                Doutor::create([
                    'crm' => $request->crm,
                    'nome' => $request->nome,
                    'data_nascimento' => $request->data_nascimento,
                    'cep' => $request->cep,
                    'cpf' => $request->cpf,
                    'bairro' => $request->bairro,
                    'logradouro' => $request->logradouro,
                    'numero' => $request->numero,
                    'complemento' => $request->complemento,
                    'telefone' => $request->telefone,
                    'email' => $request->email,
                    'senha' => Hash::make($request->password),
                ]);
            } else {
                Paciente::create([
                    'nome' => $request->nome,
                    'data_nascimento' => $request->data_nascimento,
                    'cep' => $request->cep,
                    'cpf' => $request->cpf,
                    'bairro' => $request->bairro,
                    'logradouro' => $request->logradouro,
                    'numero' => $request->numero,
                    'complemento' => $request->complemento,
                    'telefone' => $request->telefone,
                    'email' => $request->email,
                    'senha' => Hash::make($request->password),
                ]);
            }

            return redirect()->route('home')->with('success', 'Registro realizado com sucesso! Faça login.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao realizar o registro. Tente novamente.'])->withInput();
        }
    }
}
