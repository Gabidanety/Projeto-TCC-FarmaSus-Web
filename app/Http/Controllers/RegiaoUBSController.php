<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegiaoUBSModel;
//vini
class RegiaoUBSController extends Controller
{
    public function index()
    {
        
        $regioes = RegiaoModel::all(); // Busca todas as regiões do banco
        return view('adm.Ubs.formUBS', compact('regioes')); // Passa as regiões para a view
    }

    public function store(Request $request)
    {
        $regiao = new RegiaoUBSModel();
        $regiao->nomeRegiaoUBS = $request->regiao;
        $regiao->situacaoRegiaoUBS = $request->situacao;
        $regiao->dataCadastroRegiaoUBS = now();

        $regiao->save();
        return response()->json(['message' => 'Região UBS criada com sucesso!'], 201);
    }

    public function updateapi(Request $request, $id)
    {
        RegiaoUBSModel::where('idRegiaoUBS', $id)->update([
            'nomeRegiaoUBS' => $request->nome,
            'situacaoRegiaoUBS' => $request->situacao,
        ]);

        return response()->json(['message' => 'Sucesso', 'code' => 200]);
    }
}
