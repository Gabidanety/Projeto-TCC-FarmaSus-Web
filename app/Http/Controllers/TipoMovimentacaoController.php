<?php

namespace App\Http\Controllers;

use App\Models\ModelTipoMovimentacao;
use Illuminate\Http\Request;

class TipoMovimentacaoController extends Controller
{
    public function index()
    {
        $movimentacoes = ModelTipoMovimentacao::all(); // Pega todos os registros
        return view('farmacia.TipoMovimentacao.TipoMovimentacao', compact('movimentacoes'));
    }
  
    public function store(Request $request)
    {
        // Validação dos dados
            $tipoMovimentacao = new ModelTipoMovimentacao();
            $tipoMovimentacao->movimentacao = $request->movimentacao;
            $tipoMovimentacao->situacaoTipoMovimentacao = '1';
            $tipoMovimentacao->dataCadastroTipoMovimentacao = now();
            $tipoMovimentacao->idPrescricao = $request->idPrescricao;
    
            // Salvando o registro
            $tipoMovimentacao->save();
    
            return response()->json(['message' => 'Região UBS criada com sucesso!'], 201);
        
    }


    public function edit($id)
    {
        // Encontra a movimentação pelo ID
        $movimentacao = ModelTipoMovimentacao::findOrFail($id);
    
        // Retorna a view de edição passando os dados da movimentação
        return view('farmacia.TipoMovimentacao.editarTipoMovimentacao', compact('movimentacao'));
    }

    public function atualizar(Request $request, $id)
{
    // Validar os dados recebidos do formulário
    $validatedData = $request->validate([
        'movimentacao' => 'required|string|max:255',
        'situacaoTipoMovimentacao' => 'required|integer',
        'dataCadastroTipoMovimentacao' => 'required|date',
        'idPrescricao' => 'required|integer',
    ]);

    try {
        // Procurar a movimentação a ser atualizada no banco de dados
        $movimentacao = ModelTipoMovimentacao::findOrFail($id);

        // Atualizar os campos
        $movimentacao->movimentacao = $request->movimentacao;
        $movimentacao->situacaoTipoMovimentacao = $request->situacaoTipoMovimentacao;
        $movimentacao->dataCadastroTipoMovimentacao = $request->dataCadastroTipoMovimentacao;
        $movimentacao->idPrescricao = $request->idPrescricao;

        // Salvar as alterações
        $movimentacao->save();

        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('entrada_medicamento')->with('success', 'Movimentação atualizada com sucesso!');
    } catch (\Exception $e) {
        // Caso ocorra algum erro, exibir uma mensagem de erro
        return back()->withErrors(['msg' => 'Erro ao atualizar movimentação: ' . $e->getMessage()]);
    }
}

    
    

        public function destroy($id)
        {
            // Encontrar a movimentação pelo ID
            $movimentacao = ModelTipoMovimentacao::findOrFail($id);
            
            // Atualizar a situação para 0
            $movimentacao->situacaoTipoMovimentacao = 0; // ou o valor que você deseja para inativo
            $movimentacao->save(); // Salva a atualização no banco de dados
        
            // Redireciona com uma mensagem de sucesso
            return redirect()->route('entrada_medicamento')->with('success', 'Movimentação Desativada com sucesso para inativo!');
        }
}
