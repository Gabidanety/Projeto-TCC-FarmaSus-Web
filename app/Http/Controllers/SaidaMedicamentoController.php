<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelSaidaMedicamento;
use App\Models\ModelFuncionarioFarmaciaUBS;
use App\Models\ModelMedicamentoFarmaciaUBS;
use App\Models\ModelTipoMovimentacao;

class SaidaMedicamentoController extends Controller
{
    public function index(Request $request)
    {
        // Filtra saídas apenas ativas
        $query = ModelSaidaMedicamento::where('situacao', 1);

        if ($request->filled('dataSaida')) {
            $query->where('dataSaida', $request->dataSaida);
        }

        if ($request->filled('motivoSaida')) {
            $query->where('motivoSaida', 'like', '%' . $request->motivoSaida . '%');
        }

        $saidas = $query->get();

        return view('farmacia.Medicamento.saidaMedMotivoLista', compact('saidas'));
    }

    public function create()
    {

        $medicamentos = ModelMedicamentoFarmaciaUBS::all(); // Altere conforme seu modelo
        $funcionarios = ModelFuncionarioFarmaciaUBS::all(); // Altere conforme seu modelo

        return view(('farmacia.Medicamento.saidaMedMotivoCadastro'), compact('medicamentos', 'funcionarios'));
    }

    public function showview()
    {
        $saidas = ModelSaidaMedicamento::with(['funcionario', 'medicamento'])
            ->orderBy('dataSaida', 'desc')
            ->get();


        return view('farmacia.Medicamento.saidaMedMotivoLista', compact('saidas'));
    }

    public function estoque(Request $request)
    {
        // Busca o medicamento usando o ID selecionado
        $medicamento = ModelMedicamentoFarmaciaUBS::find($request->idMedicamento);
        if (!$medicamento) {
            return redirect()->back()->with('error', 'O medicamento não está cadastrado.');
        }
    
        // Busca o funcionário pelo ID
        $funcionario = ModelFuncionarioFarmaciaUBS::find($request->idFuncionario);
        if (!$funcionario) {
            return redirect()->back()->with('error', 'Funcionário não encontrado.');
        }
    
        // Criação da saída de medicamento
        $saida = new ModelSaidaMedicamento();
        $saida->dataSaida = now();
        $saida->quantidade = $request->quantidade;
        $saida->lote = $medicamento->loteMedicamento;  
        $saida->validade = $medicamento->validadeMedicamento;
        $saida->idFuncionario = $funcionario->idFuncionario;
        $saida->idMedicamento = $medicamento->idMedicamento;
        $saida->motivoSaida = $request->motivoSaida;
        $saida->situacao = 1;
    
        try {
            $saida->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar a saída de medicamento: ' . $e->getMessage());
        }
    
        // Verifica o ID de movimentação para 'Saída'
        $tipoMovimentacao = ModelTipoMovimentacao::where('movimentacao', 'Saida')->first();
        if (!$tipoMovimentacao) {
            return redirect()->back()->with('error', 'Tipo de movimentação "Saída" não encontrado.');
        }
    
        // Prepara dados para salvar no estoque
        $saidaRequest = new Request([
            'quantEstoque' => -$saida->quantidade, // Quantidade negativa para saída
            'dataMovimentacao' => now(),
            'idFuncionario' => $saida->idFuncionario,
            'idMedicamento' => $saida->idMedicamento,
            'idTipoMovimentacao' => $tipoMovimentacao->idTipoMovimentacao,
            'situacaoEstoque' => "A" // Situação ativa
        ]);
    
        try {
            // Chama o método de estoque para salvar a movimentação
            app(EstoqueFarmaciaUBSController::class)->saida($saidaRequest);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o estoque: ' . $e->getMessage());
        }
    
        return redirect('/estoqueHome')->with('success', 'Saída de medicamento e motivo cadastrados com sucesso!');
    }
    public function store(Request $request)
    {
        // Busca o medicamento usando o ID selecionado
        $medicamento = ModelMedicamentoFarmaciaUBS::find($request->idMedicamento);
        if (!$medicamento) {
            return redirect()->back()->with('error', 'O medicamento não está cadastrado.');
        }
    
        // Busca o funcionário pelo ID
        $funcionario = ModelFuncionarioFarmaciaUBS::find($request->idFuncionario);
        if (!$funcionario) {
            return redirect()->back()->with('error', 'Funcionário não encontrado.');
        }
    
        // Criação da saída de medicamento
        $saida = new ModelSaidaMedicamento();
        $saida->dataSaida = $request->dataSaida;
        $saida->quantidade = $request->quantidade;
        $saida->lote = $request->lote;
        $saida->validade = $request->validade;
        $saida->idFuncionario = $funcionario->idFuncionario;
        $saida->idMedicamento = $medicamento->idMedicamento;
        $saida->motivoSaida = $request->motivoSaida;
        $saida->situacao = 1;
    
        try {
            $saida->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar a saída de medicamento: ' . $e->getMessage());
        }
    
        // Verifica o ID de movimentação para 'Saída'
        $tipoMovimentacao = ModelTipoMovimentacao::where('movimentacao', 'Saida')->first();
        if (!$tipoMovimentacao) {
            return redirect()->back()->with('error', 'Tipo de movimentação "Saída" não encontrado.');
        }
    
        // Prepara dados para salvar no estoque
        $saidaRequest = new Request([
            'quantEstoque' => -$saida->quantidade, // Quantidade negativa para saída
            'dataMovimentacao' => now(),
            'idFuncionario' => $saida->idFuncionario,
            'idMedicamento' => $saida->idMedicamento,
            'idTipoMovimentacao' => $tipoMovimentacao->idTipoMovimentacao,
            'situacaoEstoque' => "A" // Situação ativa
        ]);
    
        try {
            // Chama o método de estoque para salvar a movimentação
            app(EstoqueFarmaciaUBSController::class)->saida($saidaRequest);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o estoque: ' . $e->getMessage());
        }
    
        return redirect('/saidaLista')->with('success', 'Saída de medicamento e motivo cadastrados com sucesso!');
    }
    
    public function edit($id)
    {
        // Busca a saída pelo ID e passa para a view de edição
        $saida = ModelSaidaMedicamento::findOrFail($id);
        return view('farmacia.Medicamento.saidaMedMotivoEdit', compact('saida'));
    }

    public function update(Request $request, $id)
    {
        // Busca a saída pelo ID
        $saida = ModelSaidaMedicamento::findOrFail($id);

        // Atualiza os campos
        $saida->update($request->only([
            'dataSaida',
            'quantidade',
            'motivoSaida',
            'situacao',
            'idFuncionario',
            'idMedicamento',
            'lote',
            'validade',
            'observacao',
        ]));

        // Redireciona com uma mensagem de sucesso
        return redirect('/saidaLista')->with('success', 'Saída de medicamento atualizada com sucesso!');
    }


    public function excluir($id)
    {
        // Busca a saída de medicamento pelo ID fornecido
        $saida = ModelSaidaMedicamento::findOrFail($id);

        // Define a situação como 0 para desativar a saída de medicamento
        $saida->situacao = 0;
        $saida->save();


        return redirect('/saidaLista')->with('success', 'Saída de medicamento excluída com sucesso!');
    }

    public function getDetails($id)
    {
        $medicamento = ModelSaidaMedicamento::find($id);

        if ($medicamento) {
            return response()->json([
                'lote' => $medicamento->lote,
                'validade' => $medicamento->validade
            ]);
        }

        return response()->json(null);  // Retorna nulo se não encontrar o medicamento
    }


    // public function edit($id)
    // {
    //     $saida = ModelSaidaMedicamento::findOrFail($id);
    //     return view('saidaMedMotivoEdit', compact('saida'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'dataSaida' => 'required|date',
    //         'quantidade' => 'required|integer|min:1',
    //         'motivoSaida' => 'nullable|string|max:255',
    //     ]);

    //     $saida = ModelSaidaMedicamento::findOrFail($id);
    //     $saida->update($request->only(['dataSaida', 'quantidade', 'motivoSaida']));

    //     return redirect()->route('saidaMedMotivo.index')->with('success', 'Saída de medicamento atualizada com sucesso!');
    // }

    // public function excluir(Request $request, $id)
    // {
    //     $saida = ModelSaidaMedicamento::find($id);

    //     if (!$saida) {
    //         return redirect()->back()->with('error', 'Saída de medicamento não encontrada.');
    //     }

    //     $saida->situacao = 0;
    //     $saida->save();

    //     return redirect()->route('saidaMedMotivo.index')->with('success', 'Saída de medicamento excluída com sucesso!');
    // }
}