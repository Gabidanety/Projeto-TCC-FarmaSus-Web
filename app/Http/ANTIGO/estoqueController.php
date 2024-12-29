<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstoqueFarmaciaModel;
use Illuminate\Routing\Controller;

class estoqueConttroller extends Controller
{
    public function updateapi(Request $request, $id)
    {
        EstoqueFarmaciaModel::where('idEstoque', $id)->update([
            'quantEstoque' => $request->quantEstoque,
            'idMedicamento' => $request->idMedicamento,	
           
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }

    public function store(Request $request)
    {
        $estoque = new EstoqueFarmaciaModel();

       // $estoque->idEstoque = $request->idEstoque;
        $estoque->quantEstoque = $request->quantEstoque;
        $estoque->dataMovimentacao = $request->dataMovimentacao;
        $estoque->idFuncionario = $request->idFuncionario;
        $estoque->idMedicamento = $request->idMedicamento;
        $estoque->idTipoMovimentacao = $request->idTipoMovimentacao;
        $estoque->situacaoEstoque = $request->situacaoEstoque;
        $estoque->dataCadastroEstoque = $request->dataCadastroEstoque;
        
      

        $estoque->save();
        return response()->json(['message' => 'Estoque criado com sucesso!'], 201);

    }
    public function storeapi(Request $request)
    {
        $estoque = new EstoqueFarmaciaModel();

        $estoque->idEstoque = $request->idEstoque;
        $estoque->quantEstoque = $request->quantEstoque;
        $estoque->idMedicamento = $request->idMedicamento;
        $estoque->idFarmacia = $request->idFarmacia;

        $estoque->save();
        return response()->json(['message' => 'Estoque criado com sucesso!'], 201);

    }
}
