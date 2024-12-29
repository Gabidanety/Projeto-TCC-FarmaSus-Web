<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contatoModel;
use Illuminate\Routing\Controller;

class contatoControllerA extends Controller
{
    public function updateapi(Request $request, $id)
    {
        contatoModel::where('idContato', $id)->update([
            'idFarmacia' => $request->idFarmacia,	
            'idTelefone' => $request->idTelefone,
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }

    public function store(Request $request)
    {
        $contato = new contatoModel();

        $contato->idcontato = $request->idContato;
        $contato->idfarmacia = $request->idFarmacia;
        $contato->idtelefone = $request->idTelefone;

        $contato->save();
        return response()->json(['message' => 'Contato criado com sucesso!'], 201);

    }

    public function storeapi(Request $request)
    {
        $contato = new contatoModel();

        $contato->idcontato = $request->idContato;
        $contato->idfarmacia = $request->idFarmacia;
        $contato->idtelefone = $request->idTelefone;

        $contato->save();
        return response()->json(['message' => 'Contato criado com sucesso!'], 201);

    }
}
