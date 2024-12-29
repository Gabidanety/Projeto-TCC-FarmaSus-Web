<?php

namespace App\Http\Controllers;

use App\Models\ModelMedicamentoFarmaciaUBS;
use App\Models\MedicamentoModel;
use App\Models\UBSModel;
use Illuminate\Support\Facades\DB;
use App\Models\ModelUbsMed;
use App\Models\ModelMotivoDesativadoMedFarma;

use Illuminate\Http\Request;

class MedicamentoFarmaciaUBSController extends Controller
{
    public function index()
    {
        $medicamentos = ModelMedicamentoFarmaciaUBS::orderBy('dataCadastroMedicamento', 'desc')->get();
        $desativados = ModelMotivoDesativadoMedFarma::with('medicamento')->orderBy('dataDesativamento', 'desc')->take(10)->get();


        return view('farmacia.Medicamento.medicamentoFarmacia', compact('medicamentos','desativados'));
    }

    // public function store(Request $request)
    // {
    //     $medicamento = new ModelMedicamentoFarmaciaUBS();

    //     $medicamento->nomeMedicamento = $request->nomeMedicamento;
    //     $medicamento->nomeGenericoMedicamento = $request->nomeGenericoMedicamento;
    //     $medicamento->codigoDeBarrasMedicamento = $request->codigoDeBarrasMedicamento;
    //     $medicamento->validadeMedicamento = $request->validadeMedicamento;
    //     $medicamento->loteMedicamento = $request->loteMedicamento;
    //     $medicamento->dosagemMedicamento = $request->dosagemMedicamento;
    //     $medicamento->formaFarmaceuticaMedicamento = $request->forma;
    //     $medicamento->composicaoMedicamento = $request->composicaoMedicamento;
    //     $medicamento->situacaoMedicamento = "A";
    //     $medicamento->dataCadastroMedicamento = now();
    //     $medicamento->idUBS = $request->idUBS;

    //     $medicamento->save();

    //     return redirect('/MedicamentoHome');
    // }
    public function store(Request $request)
    {
        // Conexão com o banco bdAdminGeral e busca pelo medicamento no cadastro geral
        // Buscar o medicamento no banco bdAdminGeral pelo código de barras
       $medicamentoGeral = MedicamentoModel::where('codigoDeBarrasMedicamento', $request->codigoDeBarrasMedicamento)->first();
   
       if (!$medicamentoGeral) {
           return redirect()->back()->with('error', 'Medicamento não encontrado no sistema geral.');
       }
    
        // Prosseguir com o cadastro do medicamento na farmácia
        $medicamentoFarmacia = new ModelMedicamentoFarmaciaUBS();
    
        $medicamentoFarmacia->nomeMedicamento = $medicamentoGeral->nomeMedicamento;
        $medicamentoFarmacia->nomeGenericoMedicamento = $medicamentoGeral->nomeGenericoMedicamento;
        $medicamentoFarmacia->codigoDeBarrasMedicamento = $medicamentoGeral->codigoDeBarrasMedicamento;
        $medicamentoFarmacia->validadeMedicamento = $request->validadeMedicamento;
        $medicamentoFarmacia->loteMedicamento = $request->loteMedicamento;
        $medicamentoFarmacia->dosagemMedicamento = $request->dosagemMedicamento;
        $medicamentoFarmacia->formaFarmaceuticaMedicamento = $request->forma;
        $medicamentoFarmacia->composicaoMedicamento = $medicamentoGeral->composicaoMedicamento;
        $medicamentoFarmacia->situacaoMedicamento = "A";
        $medicamentoFarmacia->dataCadastroMedicamento = now();
        $medicamentoFarmacia->idUBS = $request->idUBS;
    
        $medicamentoFarmacia->save();
    
        // Criar o vínculo entre medicamento e UBS na tabela tbubsmed
        ModelUbsMed::create([
            'idMedicamento' => $medicamentoGeral->idMedicamento, // ID do medicamento do banco geral
            'idUBS' => $request->idUBS,                         // ID da UBS fornecida no formulário
        ]);
    
        return redirect('/MedicamentoHome')->with('success', 'Medicamento cadastrado com sucesso!');
    }
    
    

    public function edit($id)
    {
        $medicamento = ModelMedicamentoFarmaciaUBS::findOrFail($id);
        return view('farmacia.Medicamento.atualizarMedicamento', compact('medicamento'));
    }

    public function update(Request $request, $id)
    {
        $medicamento = ModelMedicamentoFarmaciaUBS::findOrFail($id);

        $medicamento->nomeMedicamento = $request->nomeMedicamento;
        $medicamento->nomeGenericoMedicamento = $request->nomeGenericoMedicamento;
        $medicamento->codigoDeBarrasMedicamento = $request->codigoDeBarrasMedicamento;
        $medicamento->validadeMedicamento = $request->validadeMedicamento;
        $medicamento->loteMedicamento = $request->loteMedicamento;
        $medicamento->dosagemMedicamento = $request->dosagemMedicamento;
        $medicamento->formaFarmaceuticaMedicamento = $request->formaFarmaceuticaMedicamento;
        $medicamento->composicaoMedicamento = $request->composicaoMedicamento;
        $medicamento->situacaoMedicamento = $request->situacaoMedicamento;

        $medicamento->save();

        return redirect('/MedicamentoHome')->with('success', 'Medicamento atualizado com sucesso!');
    }


    public function destroy(Request $request, $id)
    {
          // Valida se o motivo foi enviado
    $request->validate([
        'motivo' => 'required|string|max:200',
    ]);

    // Encontra o medicamento pelo ID
    $medicamento = ModelMedicamentoFarmaciaUBS::findOrFail($id);
    $medicamento->situacaoMedicamento = 'D'; 
    $medicamento->save();

    // Cria o motivo de desativação
    $desativados = new ModelMotivoDesativadoMedFarma();
    $desativados->idMedicamento = $id;
    $desativados->Motivo = $request->motivo;
    $desativados->dataDesativamento = now();
    $desativados->save();

    // Redireciona com mensagem de sucesso
    return redirect('/MedicamentoHome')->with('success', 'Medicamento desativado com sucesso!');
    }

    public function ativar($id)
    {
        $medicamento = ModelMedicamentoFarmaciaUBS::findOrFail($id);
        $medicamento->situacaoMedicamento = 'A'; 
        $medicamento->save();
    
        return redirect('/MedicamentoHome')->with('success', 'Medicamento ativado com sucesso!');
    
    }

    public function filtrar(Request $request)
    {
        // Obter todos os medicamentos
        $medicamentos = ModelMedicamentoFarmaciaUBS::query();
        $desativados = ModelMotivoDesativadoMedFarma::with('medicamento')->orderBy('dataDesativamento', 'desc')->take(10)->get();

        // Filtrando por forma farmacêutica
        if ($request->filled('formaFarmaceutica')) {
            $medicamentos->whereIn('formaFarmaceuticaMedicamento', $request->formaFarmaceutica);
        }
    
        // Filtrando por validade
        if ($request->filled('filtroValidadeInicio')) {
            $medicamentos->where('validadeMedicamento', '>=', $request->filtroValidadeInicio);
        }
        if ($request->filled('filtroValidadeFim')) {
            $medicamentos->where('validadeMedicamento', '<=', $request->filtroValidadeFim);
        }
    
        // Filtrando por data de cadastro
        if ($request->filled('filtroDataCadastroInicio')) {
            $medicamentos->where('dataCadastroMedicamento', '>=', $request->filtroDataCadastroInicio);
        }
        if ($request->filled('filtroDataCadastroFim')) {
            $medicamentos->where('dataCadastroMedicamento', '<=', $request->filtroDataCadastroFim);
        }
    
        // Filtrando por situação
        if ($request->filled('filtroSituacao')) {
            $medicamentos->where('situacaoMedicamento', $request->filtroSituacao);
        }
    
        // Obtendo os resultados filtrados
        $medicamentos = $medicamentos->get();
    
        // Retornar a view com os medicamentos filtrados
        return view('farmacia.Medicamento.medicamentoFarmacia', compact('medicamentos','desativados'));
    }
    
    public function indexApi()
{
    // Obter todos os registros de UBS do modelo
    $med = UBSModel::table('tbUBS')->select('idUBS', 'nomeUBS', 'fotoUBS')->get();  // Seleciona apenas os dados necessários

    // Retornar a resposta JSON com os dados e uma mensagem de sucesso
    return response()->json([
        'message' => 'Sucesso',
        'code' => 200,
        'data' => $med  // Inclui os dados obtidos do modelo
    ]);
}

    public function getMedicamentosByNomeUBS($nomeUBS)
{
    // Verificar se existe uma UBS com o nome fornecido
    $ubs = UBSModel::where('nomeUBS', $nomeUBS)->first();
    
    // Se a UBS não for encontrada, retorna uma mensagem de erro
    if (!$ubs) {
        return response()->json(['message' => 'UBS não encontrada'], 404);
    }

    // Obter o id da UBS encontrada
    $idUBS = $ubs->idUBS;

    // Obter todos os medicamentos relacionados à UBS encontrada
    $medicamentos = ModelMedicamentoFarmaciaUBS::where('idUBS', $idUBS)->get();

    // Retornar os dados da UBS e a lista completa de medicamentos relacionados
    return response()->json([
        'ubs' => $ubs,
        'medicamentos' => $medicamentos
    ]);
}
    public function show($id)
    {
        // Buscando o medicamento pelo ID
        $medicamento = ModelMedicamentoFarmaciaUBS::find($id);

        if ($medicamento) {
            return response()->json($medicamento, 200); // Retorna os dados do medicamento
        } else {
            return response()->json(['message' => 'Medicamento não encontrado'], 404);
        }
    }

//     public function getUBSByNomeMedicamento($nomeMedicamento)
// {
//     // Verificar se existe um medicamento com o nome fornecido
//     $medicamentos = ModelMedicamentoFarmaciaUBS::where('nomeMedicamento', $nomeMedicamento)->get();

//     // Se nenhum medicamento for encontrado, retorna uma mensagem de erro
//     if ($medicamentos->isEmpty()) {
//         return response()->json(['message' => 'Medicamento não encontrado'], 404);
//     }

//     // Obter as UBS associadas aos medicamentos encontrados
//     $ubsList = $medicamentos->map(function ($medicamento) {
//         return $medicamento->ubs;
//     })->unique();

//     // Retornar os dados formatados
//     return response()->json([
//         'medicamento' => $nomeMedicamento,
//         'ubs' => $ubsList
//     ]);
// }



}
