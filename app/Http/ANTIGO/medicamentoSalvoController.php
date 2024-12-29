<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\medicamentoSalvoModel;
use Illuminate\Routing\Controller;

class medicamentoSalvoController extends Controller
{
    public function updateapi(Request $request, $id)
    {
        MedicamentoSalvoModel::where('idMedicamentoSalvo', $id)->update([
            'idMedicamento' => $request->idMedicamento,	
        ]);

        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
    }

    public function storeapi(Request $request)
    {
        $medSalvo = new medicamentoSalvoModel();

        $medSalvo->idMedicamentoSalvo = $request->idMedicamentoSalvo;
        $medSalvo->idMedicamento = $request->idMedicamento;

        $medSalvo->save();
        return response()->json(['message' => 'Medicamento salvo criado com sucesso!'], 201);

    }
}
