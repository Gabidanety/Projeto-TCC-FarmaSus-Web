<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\favoritosModel;
use Illuminate\Routing\Controller;


class favoritosController extends Controller
{
    public function updateapi(Request $request, $id)
    {
        favoritosModel::where('idFavoritos', $id)->update([	
            'idFarmacia' => $request->idFarmacia,	
            'idMedicamentoSalvo' => $request->idMedicamentoSalvo,	
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }

    public function storeapi(Request $request)
    {
        $favoritos = new favoritosModel();

        $favoritos->idFavoritos = $request->idFavoritos;
        $favoritos->idFarmacia = $request->idFarmacia;
        $favoritos->idMedicamentoSalvo = $request->idMedicamentoSalvo;

        $favoritos->save();
        return response()->json(['message' => 'Favoritos criado com sucesso!'], 201);

    }
}
