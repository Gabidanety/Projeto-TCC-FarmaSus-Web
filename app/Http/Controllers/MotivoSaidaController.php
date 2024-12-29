<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelMotivoSaida;

class MotivoSaidaController extends Controller
{
    // Método para exibir o formulário de cadastro
    public function create()
    {
        return view('motivoSaidaMed'); // Nome da view do formulário
    }

    // Método para armazenar o cadastro no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'motivosaida' => 'required|string|max:255',
        ]);

        ModelMotivoSaida::create([
            'motivosaida' => $request->motivosaida,
        ]);

        return redirect()->back()->with('success', 'Motivo de saída cadastrado com sucesso!');
    }
}
