<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\telefoneModel;
use Illuminate\Routing\Controller;

class TelefoneController extends Controller
{
    public function updateapi(Request $request, $id)
    {
        telefoneModel::where('idTelefone', $id)->update([
            'numeroTelefone' => $request->numeroTelefone,	
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }


    public function storeapi(Request $request)
    {
        $telefone = new telefoneModel();

 
        $telefone->numeroTelefone = $request->telefone;

        $telefone->save();
        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }
}
