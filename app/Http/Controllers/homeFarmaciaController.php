<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelEstoqueFarmaciaUBS;
use App\Models\ModelMedicamentoFarmaciaUBS;
use App\Models\ModelEntradaMedicamento;
use App\Models\ModelSaidaMedicamento;
use App\Models\TipoMedicamentoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeFarmaciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        // Número total de medicamentos em estoque
        $totalMedicamentos = ModelEstoqueFarmaciaUBS::sum('quantEstoque');
    //     $totalMedicamentos = ModelEstoqueFarmaciaUBS::select('idMedicamento', DB::raw('SUM(quantEstoque) as totalEstoque'))
    // ->groupBy('idMedicamento')
    // ->get();


        // Total de saídas por semana
        $totalSaidas = ModelSaidaMedicamento::where('dataSaida', '>=', now()->subWeek())
            ->sum('quantidade');

        // Medicamentos em baixa (estoque menor que 10)
        $medicamentosEmBaixa = ModelEstoqueFarmaciaUBS::where('quantEstoque', '<', 10)
            ->count();

        // Última movimentação (entrada ou saída mais recente)
        $ultimaMovimentacao = ModelEntradaMedicamento::latest('dataEntrada')->first();
        if (!$ultimaMovimentacao) {
            $ultimaMovimentacao = ModelSaidaMedicamento::latest('dataSaida')->first();
        }

        // Garantir que estamos lidando com objetos Carbon
        $ultimaMovimentacaoData = null;
        $ultimaMovimentacaoTipo = null;
        if ($ultimaMovimentacao) {
            if ($ultimaMovimentacao instanceof ModelEntradaMedicamento) {
                $ultimaMovimentacaoData = Carbon::parse($ultimaMovimentacao->dataEntrada);  // Converte para Carbon
                $ultimaMovimentacaoTipo = 'Entrada';
            } else {
                $ultimaMovimentacaoData = Carbon::parse($ultimaMovimentacao->dataSaida);  // Converte para Carbon
                $ultimaMovimentacaoTipo = 'Saída';
            }
        }

        // Consultar estoque agrupado por medicamento
        $estoque = ModelEstoqueFarmaciaUBS::with('medicamento')
            ->select('idMedicamento', DB::raw('SUM(quantEstoque) as totalEstoque'))
            ->groupBy('idMedicamento')
            ->get();

        // Consultar entradas e saídas agrupadas por data
        $entradas = ModelEntradaMedicamento::with('medicamento', 'funcionario')  // Relacionando com medicamento e funcionário
            ->select('dataEntrada as data', 'quantidade', 'idMedicamento', 'idFuncionario')
            ->orderBy('dataEntrada', 'desc')
            ->take(4) // Últimas 4 entradas
            ->get()
            ->map(function ($entrada) {
                return [
                    'data' => Carbon::parse($entrada->data)->format('d/m/Y'),
                    'descricao' => "Entrada de " . $entrada->medicamento->nomeMedicamento . " - Responsável: " . $entrada->funcionario->nomeFuncionario
                ];
            });

        $saidas = ModelSaidaMedicamento::with('medicamento', 'funcionario')  // Relacionando com medicamento e funcionário
            ->select('dataSaida as data', 'quantidade', 'idMedicamento', 'idFuncionario')
            ->orderBy('dataSaida', 'desc')
            ->take(4) // Últimas 4 saídas
            ->get()
            ->map(function ($saida) {
                return [
                    'data' => Carbon::parse($saida->data)->format('d/m/Y'),
                    'descricao' => "Saída de " . $saida->medicamento->nomeMedicamento . " - Responsável: " . $saida->funcionario->nomeFuncionario
                ];
            });

        $atividadesRecentes = $entradas->merge($saidas)->sortByDesc('data')->take(4); // Pegar as 4 mais recentes e ordenar

        // Organizar os dados para o gráfico
        $datas = $entradas->merge($saidas)->pluck('data')->unique()->sort()->values(); // Unir as datas e remover duplicatas

        $quantidadeEntradas = [];
        $quantidadeSaidas = [];

        foreach ($datas as $data) {
            // Calcula a quantidade total de entradas para a data
            $quantidadeEntradas[] = ModelEntradaMedicamento::whereDate('dataEntrada', $data)->sum('quantidade') ?? 0; // Soma as quantidades de entradas para o dia

            // Calcula a quantidade total de saídas para a data
            $quantidadeSaidas[] = ModelSaidaMedicamento::whereDate('dataSaida', $data)->sum('quantidade') ?? 0; // Soma as quantidades de saídas para o dia
        }
        // Contagem de medicamentos ativos e inativos
        $ativos = ModelMedicamentoFarmaciaUBS::where('situacaoMedicamento', 'A')->count();
        $inativos = ModelMedicamentoFarmaciaUBS::where('situacaoMedicamento', 'D')->count();

        // Passar os dados para a view
        return view('farmacia.homeFarmacia', [
            'nomes' => $estoque->map(fn($item) => $item->medicamento->nomeMedicamento),
            'quantidades' => $estoque->map(fn($item) => $item->totalEstoque),
            'estoquetabela' => ModelEstoqueFarmaciaUBS::all(),
            'medicamento' => ModelMedicamentoFarmaciaUBS::orderBy('dataCadastroMedicamento', 'desc')->take(5)->get(),
            'datas' => $datas,
            'quantidadeEntradas' => $quantidadeEntradas,
            'quantidadeSaidas' => $quantidadeSaidas,
            'datas' => $datas,
            'totalMedicamentos' => $totalMedicamentos,
            'totalSaidas' => $totalSaidas,
            'medicamentosEmBaixa' => $medicamentosEmBaixa,
            'ultimaMovimentacaoData' => $ultimaMovimentacaoData,
            'ultimaMovimentacaoTipo' => $ultimaMovimentacaoTipo,
            'atividadesRecentes' => $atividadesRecentes,
            'ativos' => $ativos,
            'inativos' => $inativos,
        ]);
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
