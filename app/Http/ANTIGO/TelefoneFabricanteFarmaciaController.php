<?php

namespace App\Http\Controllers;

use App\Models\TelefoneFabricanteFarmaciaModel;
use Illuminate\Http\Request;

class TelefoneFabricanteFarmaciaController extends Controller
{
    // Método para listar todos os telefones (opcional)
    public function index()
    {
        $telefones = TelefoneFabricanteFarmaciaModel::all();
        return view('telefonesFabricante.index', compact('telefones'));
    }

    // Método para armazenar um novo telefone
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'numeroTelefoneFabricante' => 'required|max:11',
            'situacaoTelefoneFabricante' => 'nullable|max:2',
        ]);

        // Cria uma nova instância do modelo TelefoneFabricante
        $telefone = new TelefoneFabricanteFarmaciaModel();
        $telefone->numeroTelefoneFabricante = $request->numeroTelefoneFabricante;
        $telefone->situacaoTelefoneFabricante = $request->situacaoTelefoneFabricante ?? 'AT'; // Padrão
        $telefone->dataCadastroTelefoneFabricante = now();

        // Salva o telefone no banco de dados
        $telefone->save();

        // Redireciona com uma mensagem de sucesso
        return redirect()->route('telefonesFabricante.index')->with('success', 'Telefone cadastrado com sucesso!');
    }

    // Adicione outros métodos conforme necessário (exibir, editar, atualizar, excluir)
}
