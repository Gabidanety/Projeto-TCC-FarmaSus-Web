<?php

namespace App\Http\Controllers;

use App\Models\ModelPrescricao;
use App\Models\ModelMedicamentoFarmaciaUBS;

use Illuminate\Http\Request;

class PrescricaoController extends Controller
{
    public function index()
    {
        $prescricoes = ModelPrescricao::with('medicamento')->get();
        $medicamento = ModelMedicamentoFarmaciaUBS::all();
        return view('farmacia.Medicamento.cadPrescrição', compact('medicamento','prescricoes'));
    }

    public function store(Request $request)
    {
        $prescricao = new ModelPrescricao();
        $prescricao->dataPrescricao = $request->dataPrescricao;
        $prescricao->quantPrescricao = $request->quantPrescricao;
        $prescricao->dosagemPrescricao = $request->dosagemPrescricao;
        $prescricao->duracaoRemedio = $request->duracaoRemedio;
        $prescricao->idMedicamento = $request->idMedicamento;
        $prescricao->situacaoPrescricao = "A";
        $prescricao->dataCadastroPrescricao = now();
        $prescricao->save();

        return redirect('/prescricao')->with('success', 'Prescrição Cadastrada com sucesso!');
    }



    public function update(Request $request, $id)
    {
        $prescricao = ModelPrescricao::findOrFail($id); // Encontrar a prescrição pelo ID
    
        // Atualiza os dados
        $prescricao->dataPrescricao = $request->dataPrescricao;
        $prescricao->quantPrescricao = $request->quantPrescricao;
        $prescricao->dosagemPrescricao = $request->dosagemPrescricao;
        $prescricao->duracaoRemedio = $request->duracaoRemedio;
        $prescricao->idMedicamento = $request->idMedicamento;
        $prescricao->save();
    
        return redirect('/prescricao')->with('success', 'Prescrição Atualizaada com sucesso!');
    }
    

    public function destroy($id)
    {

        $prescricao = ModelPrescricao::findOrFail($id);
        $prescricao->situacaoPrescricao = 'D'; 
        $prescricao->save();
    
        return redirect('/prescricao')->with('success', 'Prescrição Desativada com sucesso!');

    }
}
