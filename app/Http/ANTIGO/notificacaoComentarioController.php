<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notificacaoComentarioModel;
use App\Models\notificacaoEstoqueModel;
use Illuminate\Routing\Controller;

class notificacaoComentarioController extends Controller
{
    public function updateapi(Request $request, $id)
    {
        notificacaoComentarioModel::where('idNotificacaoComentario', $id)->update([
            'idComentarios' => $request->idComentarios,		
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }

    public function storeapi(Request $request)
    {
        $notificacaoComentario = new notificacaoComentarioModel();

        $notificacaoComentario->idNotificacaoComentario = $request->idNotificacaoComentario;
        $notificacaoComentario->idComentarios = $request->idComentarios;

        $notificacaoComentario->save();
        return response()->json(['message' => 'Notificação Comentario criado com sucesso!'], 201);

    }

    public function store(Request $request)
    {
        $notificacaoComentario = new notificacaoComentarioModel();

        $notificacaoComentario->idNotificacaoComentario = $request->idNotificacaoComentario;
        $notificacaoComentario->idComentarios = $request->idComentarios;

        $notificacaoComentario->save();
        return response()->json(['message' => 'Notificacao Comentario criado com sucesso!'], 201);

    }
}
