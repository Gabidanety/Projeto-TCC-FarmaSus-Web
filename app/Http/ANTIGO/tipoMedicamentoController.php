<?php

namespace App\Http\Controllers;

use App\Models\tipoMedicamento;
use App\Models\TipoMedicamentoModelFarmacia;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class tipoMedicamentoController extends Controller
{

    // public function index()
    // {
    //     // Busca todos os tipos de medicamentos do banco de dados
    //     $tipoMedicamento = TipoMedicamentoModelFarmacia::all();
        
    //     // Retorna a view com os dados
    //     return view('farmacia.MedicamentoFarmacia', compact('tipoMedicamento'));
    // }

    public function storeapi(Request $request)
    {
        $tipoMedicamento = new TipoMedicamentoModelFarmacia();

        //$tipoMedicamento->idTipoMedicamento = $request->id;
        $tipoMedicamento->tipoMedicamento = $request->tipoMed;

       
        $tipoMedicamento->save();  
        return response()->json(['message' => 'Tipo Medicamento criado com sucesso!'], 201);


    }
}
