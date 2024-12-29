<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Models\ModelEntradaMedicamento;
use App\Models\ModelFuncionarioFarmaciaUBS;
use App\Models\ModelMedicamentoFarmaciaUBS;
use App\Models\ModelMotivoEntrada;
use App\Models\ModelTipoMovimentacao;
use App\Models\ModelEstoqueFarmaciaUBS;
use App\Models\ModelSaidaMedicamento;
use Illuminate\Http\Request;

class EntradaMedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = ModelEntradaMedicamento::where('situacaoEntrada', 0)
            ->join('tbMedicamentoFarmaciaUBS', 'tbEntradaMedicamento.idMedicamento', '=', 'tbMedicamentoFarmaciaUBS.idMedicamento')
            ->join('tbMotivoEntrada', 'tbEntradaMedicamento.idMotivoEntrada', '=', 'tbMotivoEntrada.idMotivoEntrada')
            ->join('tbFuncionarioFarmaciaUBS', 'tbEntradaMedicamento.idFuncionario', '=', 'tbFuncionarioFarmaciaUBS.idFuncionario')
            ->select(
                'tbEntradaMedicamento.idEntradaMedicamento',
                'tbMedicamentoFarmaciaUBS.nomeMedicamento',
                'tbEntradaMedicamento.dataEntrada',
                'tbEntradaMedicamento.quantidade',
                'tbEntradaMedicamento.lote',
                'tbEntradaMedicamento.validade',
                'tbMotivoEntrada.motivoEntrada',
                'tbFuncionarioFarmaciaUBS.nomeFuncionario'
            )
            ->get();

        return view('farmacia.medicamento.MedicamentoEntrada', compact('medicamentos'));
    }

    public function create()
    {
        $medicamentos = ModelMedicamentoFarmaciaUBS::all(); // Altere conforme seu modelo
        $motivosEntrada = ModelMotivoEntrada::all(); // Altere conforme seu modelo
        $funcionarios = ModelFuncionarioFarmaciaUBS::all(); // Altere conforme seu modelo

        return view('farmacia.Medicamento.EntradaMedInsert', compact('medicamentos', 'motivosEntrada', 'funcionarios'));
    }

    // public function store(Request $request)
    // {
    //     // Busca o medicamento usando o ID selecionado
    //     $medicamento = ModelMedicamentoFarmaciaUBS::find($request->idMedicamento);

    //     // Verifica se o medicamento foi encontrado
    //     if (!$medicamento) {
    //         return redirect()->back()->with('error', 'O medicamento não está cadastrado.');
    //     }

    //     // Cria ou busca o motivo de entrada
    //     $motivo = ModelMotivoEntrada::firstOrCreate(
    //         ['motivoEntrada' => $request->motivoEntrada]
    //     );

    //     // Busca o funcionário pelo ID
    //     $funcionario = ModelFuncionarioFarmaciaUBS::find($request->idFuncionario);

    //     if (!$funcionario) {
    //         return redirect()->back()->with('error', 'Funcionário não encontrado.');
    //     }

    //     // Criação da entrada de medicamento
    //     $entrada = new ModelEntradaMedicamento();
    //     $entrada->dataEntrada = $request->dataEntrada;
    //     $entrada->quantidade = $request->quantidade;
    //     $entrada->lote = $request->lote;
    //     $entrada->validade = $request->validade;
    //     $entrada->idFuncionario = $funcionario->idFuncionario; // Usa o ID do funcionário
    //     $entrada->idMedicamento = $medicamento->idMedicamento; // Usa o ID do medicamento encontrado
    //     $entrada->idMotivoEntrada = $motivo->idMotivoEntrada; // Usa o ID do motivo criado ou buscado

    //     // Salva a entrada de medicamento
    //     $entrada->save();

    //     // Redireciona para a página onde você insere entradas de medicamentos
    //     return redirect()->route('medicamentos.index')->with('success', 'Entrada de medicamento cadastrada com sucesso!');
    // }

    public function store(Request $request)
    {
        // Busca o medicamento usando o ID selecionado
        $medicamento = ModelMedicamentoFarmaciaUBS::find($request->idMedicamento);

        if (!$medicamento) {
            return redirect()->back()->withErrors(['codigoBarras' => 'Medicamento não encontrado. Verifique o código de barras.']);
        }


        // Cria ou busca o motivo de entrada
        $motivo = ModelMotivoEntrada::firstOrCreate(
            ['motivoEntrada' => $request->motivoEntrada]
        );

        // Busca o funcionário pelo ID
        $funcionario = ModelFuncionarioFarmaciaUBS::find($request->idFuncionario);

        if (!$funcionario) {
            return response()->json(['message' => 'Funcionario não encontrado'], 404);
        }

        // Criação da entrada de medicamento
        $entrada = new ModelEntradaMedicamento();
        $entrada->dataEntrada = now();
        $entrada->quantidade = $request->quantidade;
        $entrada->lote = $medicamento->loteMedicamento;
        $entrada->validade = $medicamento->validadeMedicamento;
        $entrada->idFuncionario = $funcionario->idFuncionario;
        $entrada->idMedicamento = $medicamento->idMedicamento;
        $entrada->idMotivoEntrada = $motivo->idMotivoEntrada;
        $entrada->save();

        // Verifica o ID de movimentação para 'Entrada'
        $tipoMovimentacao = ModelTipoMovimentacao::where('movimentacao', 'Entrada')->first();

        if (!$tipoMovimentacao) {
            return response()->json(['message' => 'Medicamento não encontrado'], 404);
        }

        // Prepara dados para salvar no estoque
        $estoqueRequest = new Request([
            'quantEstoque' => $entrada->quantidade,
            'dataMovimentacao' => now(),
            'idFuncionario' => $entrada->idFuncionario,
            'idMedicamento' => $entrada->idMedicamento,
            'idTipoMovimentacao' => $tipoMovimentacao->idTipoMovimentacao, // ID encontrado para 'Entrada'
            'situacaoEstoque' => "A"
        ]);

        // Chama o método de estoque para salvar a movimentação
        app(EstoqueFarmaciaUBSController::class)->store($estoqueRequest);

        return redirect('/estoqueHome')->with('success', 'Estoque registrado com sucesso!');
    }

    public function estoque(Request $request)
    {
        // Busca o medicamento usando o ID selecionado
        $medicamento = ModelMedicamentoFarmaciaUBS::find($request->idMedicamento);

        if (!$medicamento) {
            return redirect()->back()->with('error', 'O medicamento não está cadastrado.');
        }

        // Cria ou busca o motivo de entrada
        $motivo = ModelMotivoEntrada::firstOrCreate(
            ['motivoEntrada' => $request->motivoEntrada]
        );

        // Busca o funcionário pelo ID
        $funcionario = ModelFuncionarioFarmaciaUBS::find($request->idFuncionario);

        if (!$funcionario) {
            return redirect()->back()->with('error', 'Funcionário não encontrado.');
        }

        // Criação da entrada de medicamento
        $entrada = new ModelEntradaMedicamento();
        $entrada->dataEntrada = now();
        $entrada->quantidade = $request->quantidade;
        $entrada->lote = $medicamento->loteMedicamento;
        $entrada->validade = $medicamento->validadeMedicamento;
        $entrada->idFuncionario = $funcionario->idFuncionario;
        $entrada->idMedicamento = $medicamento->idMedicamento;
        $entrada->idMotivoEntrada = $motivo->idMotivoEntrada;
        $entrada->save();

        // Verifica o ID de movimentação para 'Entrada'
        $tipoMovimentacao = ModelTipoMovimentacao::where('movimentacao', 'Entrada')->first();

        if (!$tipoMovimentacao) {
            return redirect()->back()->with('error', 'Tipo de movimentação "Entrada" não encontrado.');
        }

        // Prepara dados para salvar no estoque
        $estoqueRequest = new Request([
            'quantEstoque' => $entrada->quantidade,
            'dataMovimentacao' => now(),
            'idFuncionario' => $entrada->idFuncionario,
            'idMedicamento' => $entrada->idMedicamento,
            'idTipoMovimentacao' => $tipoMovimentacao->idTipoMovimentacao, // ID encontrado para 'Entrada'
            'situacaoEstoque' => "A"
        ]);

        // Chama o método de estoque para salvar a movimentação
        app(EstoqueFarmaciaUBSController::class)->store($estoqueRequest);

        return redirect('/estoqueHome')->with('success', 'Estoque registrado com sucesso!');
    }


    // public function buscarMedicamento(Request $request)
    // {
    //     $nomeMedicamento = $request->query('nomeMedicamento');

    //     $medicamento = ModelMedicamentoFarmaciaUBS::where('nomeMedicamento', $nomeMedicamento)->first();

    //     // Retorna também lote e validade
    //     return response()->json([
    //         'idMedicamento' => $medicamento ? $medicamento->idMedicamento : null,
    //         'lote' => $medicamento ? $medicamento->loteMedicamento : null, // Substitua 'loteMedicamento' pelo campo correto no seu modelo
    //         'validade' => $medicamento ? $medicamento->validadeMedicamento : null // Substitua 'validadeMedicamento' pelo campo correto no seu modelo
    //     ]);
    // }

    // Dentro de EntradaMedicamentoController    
    public function showForm()
    {
        $funcionarios = ModelFuncionarioFarmaciaUBS::all(); // Ajuste o nome do modelo conforme necessário
        return view('farmacia.medicamento.EntradaMedicamentoCodigoBarras', compact('funcionarios'));
    }



    public function buscarPorCodigoBarras(Request $request)
    {
        $codigoBarras = trim($request->query('codigoBarras'));
    
        // Busca o medicamento usando o modelo
        $medicamento = ModelMedicamentoFarmaciaUBS::where('codigoDeBarrasMedicamento', $codigoBarras)->first();
    
        if ($medicamento) {
            return response()->json([
                'idMedicamento' => $medicamento->idMedicamento,
                'nomeMedicamento' => $medicamento->nomeMedicamento,
                'lote' => $medicamento->loteMedicamento,
                'validade' => $medicamento->validadeMedicamento,
            ]);
        } else {
            return response()->json(['error' => 'Medicamento não encontrado'], 404);
        }
    }
    




    public function show($id)
    {
        $entrada = ModelEntradaMedicamento::find($id);
        if (!$entrada) {
            return response()->json(['message' => 'Entrada não encontrada'], 404);
        }
        return response()->json($entrada);
    }

    // Método para atualizar o registro no banco de dados
    public function update(Request $request, $id)
    {
        $entrada = ModelEntradaMedicamento::findOrFail($id);

        $entrada->idMedicamento = $request->input('idMedicamento');
        $entrada->dataEntrada = $request->input('dataEntrada');
        $entrada->quantidade = $request->input('quantidade');
        $entrada->lote = $request->input('lote');
        $entrada->validade = $request->input('validade');
        $entrada->idFuncionario = $request->input('idFuncionario');

        // Verifica se o motivo digitado já existe ou se é um novo motivo
        $motivo = ModelMotivoEntrada::firstOrCreate(
            ['motivoEntrada' => $request->input('motivoEntrada')],
            ['situacaoMotivo' => 0]
        );

        // Define o idMotivoEntrada atualizado no registro de entrada
        $entrada->idMotivoEntrada = $motivo->idMotivoEntrada;

        // Salva as atualizações
        $entrada->save();

        return redirect()->route('medicamentos.index')->with('success', 'Entrada de medicamento atualizada com sucesso.');
    }


    // Método para exibir o formulário de edição
    public function edit($id)
    {
        // Tenta buscar a entrada de medicamento com o ID fornecido e com a situação válida
        $entrada = ModelEntradaMedicamento::where('idEntradaMedicamento', $id)
            ->where('situacaoEntrada', 'A')
            ->first();

        // Verifica se a entrada foi encontrada
        if (!$entrada) {
            return redirect()->route('entradaMedIndex')->with('error', 'Entrada de medicamento não encontrada ou já está desativada.');
        }

        // Busca o medicamento associado usando o idMedicamento da entrada
        $medicamento = ModelMedicamentoFarmaciaUBS::find($entrada->idMedicamento);

        // Verifica se o medicamento foi encontrado
        if (!$medicamento) {
            return redirect()->route('entradaMedIndex')->with('error', 'Medicamento associado não encontrado.');
        }

        // Obtem a lista de medicamentos e funcionários para preencher os selects na view
        $medicamentos = ModelMedicamentoFarmaciaUBS::all(); // Para preencher o select de medicamentos
        $funcionarios = ModelFuncionarioFarmaciaUBS::all(); // Para preencher o select de funcionários

        // Pega apenas o texto do motivo da entrada
        $motivoEntrada = ModelMotivoEntrada::find($entrada->idMotivoEntrada)->motivoEntrada;

        // Retorna a view de edição com os dados necessários
        return view('farmacia.medicamento.EntradaMedEdit', compact('entrada', 'medicamento', 'medicamentos', 'funcionarios', 'motivoEntrada'));
    }


    public function destroy($id)
    {
        $medicamento = ModelEntradaMedicamento::findOrFail($id);
        $medicamento->situacaoEntrada = 1; // Marca como inativo
        $medicamento->save();

        return redirect()->route('medicamentos.index')->with('success', 'Entrada de medicamento ocultada com sucesso.');
    }
}
