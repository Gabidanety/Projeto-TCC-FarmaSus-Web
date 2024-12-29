<?php

namespace App\Http\Controllers;

use App\Models\MedicamentoFarmaciaModel;
use App\Models\TipoMedicamentoModelFarmacia; // Model tipo medicamento
use App\Models\FabricanteFarmaciaModel; // Model fabricante
use Illuminate\Http\Request;

class MedicamentoFarmaciaController extends Controller
{
    // Método para listar todos os medicamentos, tipos e fabricantes
    public function index()
    {
        $medicamentos = MedicamentoFarmaciaModel::all(); 

        // Tipo de medicamento
        $tipoMedicamento = TipoMedicamentoModelFarmacia::all();

        // Fabricantes
        $fabricantes = FabricanteFarmaciaModel::all();

        return view('farmacia.MedicamentoFarmacia', compact('medicamentos', 'tipoMedicamento', 'fabricantes')); // Passa os dados para a view
    }

    // Método para armazenar um novo medicamento
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nomeMedicamento' => 'required|string|max:100',
            'nomeGenericoMedicamento' => 'required|string|max:100',
            'codigoDeBarrasMedicamento' => 'required|string|max:15|unique:tbMedicamentoFarmacia',
            'validadeMedicamento' => 'required|date',
            'loteMedicamento' => 'required|string|max:10',
            'fabricacaoMedicamento' => 'required|date',
            'dosagemMedicamento' => 'required|string|max:50',
            'formaFarmaceuticaMedicamento' => 'required|string|max:15',
            'quantMedicamento' => 'required|integer|min:1',
            'composicaoMedicamento' => 'required|string|max:200',
            'idFabricante' => 'nullable|exists:tbFabricanteFarmacia,idFabricante',
            'idTipoMedicamento' => 'required|exists:tbTipoMedicamentoFarmacia,idTipoMedicamento',
        ]);

        // Criação de um novo medicamento
        $medicamento = new MedicamentoFarmaciaModel();
        $medicamento->nomeMedicamento = $request->nomeMedicamento;
        $medicamento->nomeGenericoMedicamento = $request->nomeGenericoMedicamento;
        $medicamento->codigoDeBarrasMedicamento = $request->codigoDeBarrasMedicamento;
        $medicamento->validadeMedicamento = $request->validadeMedicamento;
        $medicamento->loteMedicamento = $request->loteMedicamento;
        $medicamento->fabricacaoMedicamento = $request->fabricacaoMedicamento;
        $medicamento->dosagemMedicamento = $request->dosagemMedicamento;
        $medicamento->formaFarmaceuticaMedicamento = $request->formaFarmaceuticaMedicamento;
        $medicamento->quantMedicamento = $request->quantMedicamento;
        $medicamento->composicaoMedicamento = $request->composicaoMedicamento;
        $medicamento->idFabricante = $request->idFabricante; // ID do fabricante
        $medicamento->idTipoMedicamento = $request->idTipoMedicamento; // Chave estrangeira
        $medicamento->situacaoMedicamento = '0'; // Situação padrão (0 para não ativo)
        $medicamento->dataCadastroMedicamento = now(); // Data atual
        
        // Salva o registro no banco de dados
        $medicamento->save();
        
        // Mensagem de sucesso
        session()->flash('success_messages', ['Medicamento criado com sucesso!']);

        // Redireciona para a lista de medicamentos
        return redirect()->route('medicamentos.index');
    }

    // Método para editar um medicamento
    public function edit($id)
    {
        $medicamento = MedicamentoFarmaciaModel::findOrFail($id);
        $tipoMedicamento = TipoMedicamentoModelFarmacia::all();
        $fabricantes = FabricanteFarmaciaModel::all();

        return view('farmacia.editarMedicamento', compact('medicamento', 'tipoMedicamento', 'fabricantes'));
    }

    // Método para atualizar a quantidade do medicamento
    public function update(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'idMedicamento' => 'required|integer|exists:tbMedicamentoFarmacia,idMedicamento',
            'quantMedicamento' => 'required|integer|min:1',
        ]);

        // Atualiza o medicamento
        $medicamento = MedicamentoFarmaciaModel::findOrFail($request->idMedicamento);
        $medicamento->quantMedicamento = $request->quantMedicamento;
        $medicamento->save();

        // Mensagem de sucesso
        session()->flash('success_messages', ['Quantidade de medicamento atualizada com sucesso!']);

        // Redireciona para a lista de medicamentos
        return redirect()->route('medicamentos.index');
    }

    // Adicione métodos adicionais conforme necessário (exibir, excluir, etc.)
}
