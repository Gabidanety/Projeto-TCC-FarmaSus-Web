<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\FarmaciaUBSModel; // Certifique-se de que o nome do modelo está correto

class FarmaciaUBSController extends Controller
{
    // Exibir o formulário de criação e a lista de farmácias
    public function showForm(Request $request)
{
    // Obtém o valor do filtro
    $query = $request->input('query');

    // Base para consulta de farmácias ativas
    $farmacias = FarmaciaUBSModel::where('situacaoFarmaciaUBS', 'A');

    // Adiciona o filtro se a query estiver preenchida
    if ($query) {
        $farmacias = $farmacias->where('nomeFarmaciaUBS', 'LIKE', "%{$query}%");
    }

    $farmacias = $farmacias->get();

    // Retorna a view com os dados das farmácias filtradas
    return view('adm.Ubs.farmacias', compact('farmacias'));
}


    // Armazenar os dados da Farmácia UBS
    public function store(Request $request) 
    {
        // Validação dos dados
        $request->validate([
            'nomeFamaciaUBS' => 'required|string|max:100',
            'emailFamaciaUBS' => 'required|email|max:100',
            'senhaFamaciaUBS' => 'required|string|min:3', // Senha deve ter pelo menos 3 caracteres
            'tipoFamaciaUBS' => 'nullable|string|max:100',
        ]);

        // Criação de uma nova instância de FarmaciaUBSModel
        $farmacia = new FarmaciaUBSModel();
        $farmacia->nomeFarmaciaUBS = $request->nomeFamaciaUBS;
        $farmacia->emailFarmaciaUBS = $request->emailFamaciaUBS;
        $farmacia->senhaFarmaciaUBS = Hash::make($request->senhaFamaciaUBS); // Hash da senha
        $farmacia->tipoFarmaciaUBS = $request->tipoFamaciaUBS; // Campo opcional
        $farmacia->situacaoFarmaciaUBS = 'A'; // Define como 'Ativa'
        $farmacia->dataCadastroFarmaciaUBS = now(); // Data de cadastro

        // Salva os dados no banco
        $farmacia->save();

        // Mensagem de sucesso
        session()->flash('success', 'Farmácia UBS cadastrada com sucesso!');

        // Redireciona para exibir o formulário e as farmácias cadastradas
        return redirect('/farmacia');
    }

    // Método para exibir o formulário de edição
    public function edit($id)
    {
        // Encontra a farmácia pelo ID
        $farmacia = FarmaciaUBSModel::findOrFail($id);
        
        // Retorna a view de edição com os dados da farmácia
        return view('adm.Ubs.editFarmaciaUbs', compact('farmacia'));
    }
    
    // Atualizar dados via POST (simulando PUT com _method)
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nomeFarmaciaUBS' => 'required|string|max:100',
            'emailFarmaciaUBS' => 'required|email|max:100',
            'tipoFamaciaUBS' => 'nullable|string|max:100',
        ]);
    
        // Atualiza os dados da farmácia
        $farmacia = FarmaciaUBSModel::findOrFail($id);
        $farmacia->nomeFarmaciaUBS = $request->nomeFarmaciaUBS;
        $farmacia->emailFarmaciaUBS = $request->emailFarmaciaUBS;
        $farmacia->tipoFarmaciaUBS = $request->tipoFarmaciaUBS;
        $farmacia->save();
    
        // Mensagem de sucesso
        session()->flash('success', 'Farmácia atualizada com sucesso!');
    
        // Redireciona de volta para a lista de farmácias
        return redirect('/farmacia');
    }
    
    // Método para mudar o status da farmácia
    public function changeStatus($id)
    {
        // Marca a farmácia como excluída
        $farmacia = FarmaciaUBSModel::findOrFail($id);
        $farmacia->situacaoFarmaciaUBS = '0'; // Marca como excluída
        $farmacia->save();

        // Mensagem de sucesso
        session()->flash('success', 'Farmácia excluída com sucesso!');

        // Redireciona de volta para a lista de farmácias
        return redirect('/farmacia');
    }
}
