<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelefoneUBSModel;
//vini
class TelefoneUBSController extends Controller
{
    public function index()
    {
        $telefones = TelefoneUBSModel::all();
        return response()->json($telefones);
    }

    public function store(Request $request)
    {
        $telefone = new TelefoneUBSModel();
       
        $telefone->numeroTelefoneUBS = $request->telefone;
        $telefone->situacaoTelefoneUBS = $request->situacao;
        $telefone->dataCadastroTelefoneUBS = now();

        $telefone->save();
        return response()->json(['message' => 'Telefone UBS criado com sucesso!'], 201);
    }


    public function updateapi(Request $request, $id)
    {
        TelefoneUBSModel::where('idTelefoneUBS', $id)->update([
            'idUBS' => $request->idUBS,
            'telefoneUBS' => $request->telefone,
            'situacaoTelefoneUBS' => $request->situacao,
        ]);

        return response()->json(['message' => 'Sucesso', 'code' => 200]);
    }
}
