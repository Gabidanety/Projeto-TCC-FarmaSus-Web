<?php

namespace App\Http\Controllers;

use App\Models\ModelEstoqueFarmaciaUBS;
use App\Models\ModelMedicamentoFarmaciaUBS;
use App\Models\ModelFuncionario;
use App\Models\ModelTipoMovimentacao;
use App\Models\ModelEntradaMedicamento;
use App\Models\ModelSaidaMedicamento;
use App\Models\ModelMotivoEntrada;
use App\Models\ModelFuncionarioFarmaciaUBS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstoqueFarmaciaUBSController extends Controller

{
    
    public function index()
    {
        // Últimas 3 entradas
        $ultimasEntradas = DB::connection('mysql2')->table('tbEntradaMedicamento')
            ->join('tbMedicamentoFarmaciaUBS', 'tbEntradaMedicamento.idMedicamento', '=', 'tbMedicamentoFarmaciaUBS.idMedicamento')
            ->select('tbMedicamentoFarmaciaUBS.nomeMedicamento', 'tbEntradaMedicamento.quantidade', 'tbEntradaMedicamento.dataEntrada')
            ->orderBy('tbEntradaMedicamento.dataEntrada', 'desc') // Ordena por data de entrada (descendente)
            ->take(3)
            ->get();
    
        // Adicionando a propriedade 'tipo' nas entradas
        foreach ($ultimasEntradas as $entrada) {
            $entrada->tipo = 'entrada'; // Adiciona o tipo para as entradas
            $entrada->dataMovimentacao = $entrada->dataEntrada; // Define um campo comum para facilitar a ordenação
        }
    
        // Últimas 3 saídas
        $ultimasSaidas = DB::connection('mysql2')->table('tbSaidaMedicamento')
            ->join('tbMedicamentoFarmaciaUBS', 'tbSaidaMedicamento.idMedicamento', '=', 'tbMedicamentoFarmaciaUBS.idMedicamento')
            ->select('tbMedicamentoFarmaciaUBS.nomeMedicamento', 'tbSaidaMedicamento.quantidade', 'tbSaidaMedicamento.dataSaida')
            ->orderBy('tbSaidaMedicamento.dataSaida', 'desc') // Ordena por data de saída (descendente)
            ->take(3)
            ->get();
    
        // Adicionando a propriedade 'tipo' nas saídas
        foreach ($ultimasSaidas as $saida) {
            $saida->tipo = 'saida'; // Adiciona o tipo para as saídas
            $saida->dataMovimentacao = $saida->dataSaida; // Define um campo comum para facilitar a ordenação
        }
    
        // Unir entradas e saídas em uma lista única
        $movimentacoes = $ultimasEntradas->merge($ultimasSaidas);
    
        // Ordenar todas as movimentações pela dataMovimentacao (descendente)
        $movimentacoes = $movimentacoes->sortByDesc('dataMovimentacao');
    
        // Outros dados da tela de estoque
        $medicamento = ModelMedicamentoFarmaciaUBS::orderBy('dataCadastroMedicamento', 'desc')->take(5)->get();
        $funcionario = ModelFuncionario::all();
        $tipoMovimentacao = ModelTipoMovimentacao::all();
        $estoque = ModelEstoqueFarmaciaUBS::with(['medicamento', 'funcionario', 'tipoMovimentacao'])->get();
        
        return view('farmacia.Estoque.estoque', compact('movimentacoes', 'medicamento', 'funcionario', 'tipoMovimentacao', 'estoque'));
    }
    


    public function store(Request $estoqueRequest)
    {

        // Busca ou cria o registro de estoque pelo ID do medicamento
        $estoque = ModelEstoqueFarmaciaUBS::firstOrNew([
            'idMedicamento' => $estoqueRequest->idMedicamento
        ]);

        // Ajusta a quantidade com base no tipo de movimentação
        // Verificação mais precisa do tipo de movimentação
        $estoque->quantEstoque = ($estoque->quantEstoque ?? 0) + $estoqueRequest->quantEstoque;


        // Dados adicionais para movimentação
        $estoque->dataMovimentacao = $estoqueRequest->dataMovimentacao;
        $estoque->idFuncionario = $estoqueRequest->idFuncionario;
        $estoque->idTipoMovimentacao = $estoqueRequest->idTipoMovimentacao;
        $estoque->situacaoEstoque = "A";
        $estoque->dataCadastroEstoque = $estoque->dataCadastroEstoque ?? now();
        // Salva o estoque com a nova quantidade
        $estoque->save();
    }

    public function saida(Request $request)
    {
        // Busca o estoque atual do medicamento selecionado
        $estoque = ModelEstoqueFarmaciaUBS::where('idMedicamento', $request->idMedicamento)->first();

        if (!$estoque) {
            return redirect()->back()->with('error', 'Medicamento não encontrado no estoque.');
        }

        // Atualiza a quantidade em estoque, subtraindo a quantidade da saída
        $estoque->quantEstoque = ($estoque->quantEstoque ?? 0) + $request->quantEstoque;

        // Verifica se o estoque está com quantidade negativa após a atualização
        if ($estoque->quantEstoque < 0) {
            return redirect()->back()->with('error', 'Quantidade insuficiente no estoque para realizar a saída.');
        }

        try {
            // Salva a nova quantidade no estoque
            $estoque->save();

            // Cria um novo registro de movimentação de estoque para a saída
            $novaMovimentacao = new ModelEstoqueFarmaciaUBS();
            $novaMovimentacao->quantEstoque = $estoque->quantEstoque; // Quantidade atualizada
            $novaMovimentacao->dataMovimentacao = $request->dataMovimentacao;
            $novaMovimentacao->idFuncionario = $request->idFuncionario;
            $novaMovimentacao->idMedicamento = $request->idMedicamento;
            $novaMovimentacao->idTipoMovimentacao = $request->idTipoMovimentacao;
            $novaMovimentacao->situacaoEstoque = $request->situacaoEstoque;

            // Salva o registro da movimentação de saída
            $novaMovimentacao->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o estoque: ' . $e->getMessage());
        }
    }

    
    public function show($id)
    {
        $estoque = ModelEstoqueFarmaciaUBS::find($id);
        if (!$estoque) {
            return response()->json(['message' => 'Estoque não encontrado'], 404);
        }
        return response()->json($estoque);
    }

    public function update(Request $request, $id)
    {
        $estoque = ModelEstoqueFarmaciaUBS::findOrFail($id);

        $estoque->quantEstoque = $request->quantEstoque;
        $estoque->dataMovimentacao = $request->dataMovimentacao;
        $estoque->idFuncionario = $request->idFuncionario;
        $estoque->idMedicamento = $request->idMedicamento;
        $estoque->idTipoMovimentacao = $request->idTipoMovimentacao;

        $estoque->save();

        return redirect('/estoqueHome')->with('success', 'Estoque atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $estoque = ModelEstoqueFarmaciaUBS::findOrFail($id);

        $estoque->situacaoEstoque = "D";

        $estoque->save();

        return redirect('/estoqueHome')->with('success', 'Estoque Desativado com sucesso!');
    }
    public function ativar($id)
    {
        $estoque = ModelEstoqueFarmaciaUBS::findOrFail($id);

        $estoque->situacaoEstoque = "A";

        $estoque->save();

        return redirect('/estoqueHome')->with('success', 'Estoque ativado com sucesso!');
    }
}
