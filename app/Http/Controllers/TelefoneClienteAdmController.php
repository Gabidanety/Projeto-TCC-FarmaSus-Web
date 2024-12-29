<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelefoneClienteAdmModel; // Importa o model correto

class TelefoneClienteAdmController extends Controller
{
    // Método para armazenar um novo telefone
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'numeroTelefoneCliente' => 'required|string|max:11', // Max: 11 caracteres
            'situacaoTelefoneCliente' => 'nullable|string|max:2', // Max: 2 caracteres
            'dataCadastroTelefoneCliente' => 'required|date', // Verifica se é uma data
        ]);
    
        // Criação do novo telefone
        $telefone = new TelefoneClienteAdmModel();
        $telefone->numeroTelefoneCliente = $request->numeroTelefoneCliente;
        $telefone->situacaoTelefoneCliente = $request->situacaoTelefoneCliente ?? '0'; // Valor padrão se não fornecido
        $telefone->dataCadastroTelefoneCliente = $request->dataCadastroTelefoneCliente; // Data fornecida no request
        $telefone->save(); // Salva no banco de dados
    
        return response()->json(['success' => true]);
    }
    
    // Método para listar todos os telefones
    public function index()
    {
        $telefones = TelefoneClienteAdmModel::all(); // Obtém todos os telefones
        return view('clienteFarmacia.telefone_index', compact('telefones')); // Retorna a view com os telefones
    }

    // Método para editar um telefone
    public function edit($id)
    {
        $telefone = TelefoneClienteAdmModel::findOrFail($id); // Busca o telefone pelo ID
        return view('clienteFarmacia.telefone_edit', compact('telefone')); // Retorna a view para editar
    }

    // Método para atualizar um telefone
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'numeroTelefoneCliente' => 'required|string|max:11', // Max: 11 caracteres
            'situacaoTelefoneCliente' => 'nullable|string|max:2', // Max: 2 caracteres
        ]);

        // Atualiza o telefone
        $telefone = TelefoneClienteAdmModel::findOrFail($id); // Busca o telefone pelo ID
        $telefone->numeroTelefoneCliente = $request->numeroTelefoneCliente;
        $telefone->situacaoTelefoneCliente = $request->situacaoTelefoneCliente ?? '0'; // Valor padrão se não fornecido
        $telefone->save(); // Salva as alterações

        return redirect()->back()->with('success', 'Telefone atualizado com sucesso!'); // Retorna com mensagem de sucesso
    }

    // Método para excluir um telefone
    public function destroy($id)
    {
        // Tenta encontrar o telefone pelo ID
        $telefone = TelefoneClienteAdmModel::find($id);
        
        // Verifica se o telefone existe
        if ($telefone) {
            // Atualiza a situação do telefone para '1' (inativo ou desativado)
            $telefone->situacaoTelefoneCliente = 1; // Supondo que exista um campo 'situacaoTelefone' no banco de dados
            $telefone->save(); // Salva a mudança no banco de dados
    
            return redirect()->back()->with('success', 'Telefone desativado com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Telefone não encontrado.');
        }
    }
    
}
