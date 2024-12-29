<?php

namespace App\Http\Controllers;

use App\Models\ModelFuncionario;
use Illuminate\Http\Request;

class FuncionarioFarmaciaUBSController extends Controller
{
    public function index()
{
    $funcionarios = ModelFuncionario::all(); // Busca todos os funcionários
    return view('farmacia.Funcionario.funcionario', compact('funcionarios')); // Passa a variável para a view de listagem
}

    public function store(Request $request)
    {
        $funcionario = new ModelFuncionario();

        $funcionario->nomeFuncionario = $request->nomeFuncionario;
        $funcionario->cpfFuncionario = $request->cpfFuncionario;
        $funcionario->cargoFuncionario = $request->cargoFuncionario;
        $funcionario->situacaoFuncionario = 'A';
        $funcionario->dataCadastroFuncionario = now();
        $funcionario->save();

        return redirect('/funcionarios')->with('message', 'Funcionário cadastrado com sucesso!');
    }

    public function edit($idFuncionario)
{
    $funcionario = ModelFuncionario::find($idFuncionario); // Busca o funcionário pelo ID
    if (!$funcionario) {
        return redirect()->route('funcionario.index')->with('error', 'Funcionário não encontrado.');
    }
    
    return view('farmacia.Funcionario.editFuncionario', compact('funcionario')); // Passa o funcionário para a view
}

public function update(Request $request, $idFuncionario)
{
    // Valida os dados recebidos
    $request->validate([
        'nomeFuncionario' => 'required|string|max:100',
        'cpfFuncionario' => 'required|string|max:14',
        'cargoFuncionario' => 'required|string|max:50',
    ]);

    // Busca o funcionário pelo ID
    $funcionario = ModelFuncionario::find($idFuncionario);
    
    // Verifica se o funcionário foi encontrado
    if (!$funcionario) {
        return redirect()->route('funcionario.index')->with('error', 'Funcionário não encontrado.');
    }

    // Atualiza os dados do funcionário
    $funcionario->nomeFuncionario = $request->nomeFuncionario;
    $funcionario->cpfFuncionario = $request->cpfFuncionario;
    $funcionario->cargoFuncionario = $request->cargoFuncionario;
    $funcionario->situacaoFuncionario = '1'; // Se necessário
    $funcionario->save();

    // Redireciona de volta com uma mensagem de sucesso
    return redirect()->route('funcionario.index')->with('success', 'Funcionário atualizado com sucesso!');
}
public function destroy($id)
{
    $funcionario = ModelFuncionario::find($id);
    if (!$funcionario) {
        return redirect()->route('funcionario.index')->with('success', 'Funcionário não encontrado!');
    }

    // Atualiza a situação para 0 (deletado)
    $funcionario->situacaoFuncionario = 'I';
    $funcionario->save();

    return redirect()->route('funcionario.index')->with('success', 'Funcionário desativado com sucesso!');
}

    // public function show($id)
    // {
    //     $funcionario = ModelFuncionario::find($id);
    //     if (!$funcionario) {
    //         return response()->json(['message' => 'Funcionário não encontrado'], 404);
    //     }
    //     return response()->json($funcionario);
    // }

    // public function update(Request $request, $id)
    // {
    //     $funcionario = ModelFuncionario::find($id);
    //     if (!$funcionario) {
    //         return response()->json(['message' => 'Funcionário não encontrado'], 404);
    //     }

    //     $funcionario->update($request->all());
    //     return response()->json($funcionario);
    // }

    // public function destroy($id)
    // {
    //     $funcionario = ModelFuncionario::find($id);
    //     if (!$funcionario) {
    //         return response()->json(['message' => 'Funcionário não encontrado'], 404);
    //     }

    //     $funcionario->delete();
    //     return response()->json(['message' => 'Funcionário deletado com sucesso']);
    // }
}
