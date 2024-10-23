<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Doutor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Make sure to import Validator

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cep' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'telefone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pacientes,email', // Ensure the table name is correct
            'password' => 'required|string|min:8|confirmed', // Ensure the password confirmation is validated
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Check the role to determine if it's a doctor or patient
        if ($request->role === 'doctor') {
            // Validate additional fields for doctors
            $request->validate([
                'crm' => 'required|string|unique:doutores,crm',
            ]);
    
            // Create a new doctor
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
                'senha' => Hash::make($request->password), // Hash the password
            ]);
        } else {
            // Create a new patient
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
                'senha' => Hash::make($request->password), // Hash the password
            ]);
        }
    
        \Log::info('Registro realizado com sucesso!');
        return redirect()->route('home')->with('success', 'Registro realizado com sucesso!');
    }
}
