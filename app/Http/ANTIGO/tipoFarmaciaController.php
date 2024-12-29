<?php

namespace App\Http\Controllers;

use App\Models\tipoFarmaciaModel;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class tipoFarmaciaController extends Controller
{
    public function updateapi(Request $request, $id)
    {
        tipoFarmaciaModel::where('idTipoFarmacia', $id)->update([
            'tipoFarmacia' => $request->tipoFarmacia,	
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }

    public function storeapi(Request $request)
    {
        $tipoFarmacia = new tipoFarmaciaModel();

        //$clienteModel->idCliente = $request->id;
        
       // $tipoFarmacia->idTipoFarmacia = $request-> id;
        $tipoFarmacia->tipoFarmacia = $request->tipoFarmacia;

       
        $tipoFarmacia->save();  
        return response()->json(['message' => 'Tipo Farmacia criado com sucesso!'], 201);


    }
}
