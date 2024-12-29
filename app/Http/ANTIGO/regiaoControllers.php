<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\regiaoModel;


class regiaoControllers extends Controller
{
    public function updateapi(Request $request, $id)
    {
        regiaoModel::where('idRegiao', $id)->update([
            'nomeRegiao' => $request->nomeRegiao,		
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }

    public function store(Request $request)
    {
        $regiao = new regiaoModel();

    
        //$regiao->idRegiao = $request-> id;
        $regiao->nomeRegiao = $request->nomeRegiao;

       
        $regiao->save();  
        return response()->json(['message' => 'Regiao criado com sucesso!'], 201);


    }

    public function storeapi(Request $request)
    {
        $regiao = new regiaoModel();

    
        //$regiao->idRegiao = $request-> id;
        $regiao->nomeRegiao = $request->regiao;

       
        $regiao->save();  
        return response()->json(['message' => 'Regiao criado com sucesso!'], 201);


    }
}
