<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notificacaoEstoqueModel;
use Illuminate\Routing\Controller;

class notificacaoEstoqueController extends Controller
{
    public function updateapi(Request $request, $id)
    {
        notificacaoEstoqueModel::where('idNotificacaoEstoque', $id)->update([
            'idEstoque' => $request->idEstoque,		
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }

    public function storeapi(Request $request)
    {
        $notificacaoEstoque = new notificacaoEstoqueModel();

        $notificacaoEstoque->idNotificacaoEstoque = $request->idNotificacaoEstoque;
        $notificacaoEstoque->idEstoque = $request->idEstoque;

        $notificacaoEstoque->save();
        return response()->json(['message' => 'Notificação Estoque criado com sucesso!'], 201);

    }

    public function store(Request $request)
    {
        $notificacaoEstoque = new notificacaoEstoqueModel();

        $notificacaoEstoque->idNotificacaoEstoque = $request->idNotificacaoEstoque;
        $notificacaoEstoque->idEstoque = $request->idEstoque;

        $notificacaoEstoque->save();
        return response()->json(['message' => 'Notificação Estoque criado com sucesso!'], 201);

    }
}
