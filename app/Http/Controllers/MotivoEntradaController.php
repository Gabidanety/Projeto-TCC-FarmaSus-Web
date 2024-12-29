<?php

namespace App\Http\Controllers;

use App\Models\ModelMotivoEntrada;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MotivoEntradaController extends Controller
{
    // Exibir todos os motivos de entrada
    public function index()
{
    $motivos = ModelMotivoEntrada::all();
    return view('farmacia.Medicamento.motivEntrada', compact('motivos')); // Substitua 'nomeDaSuaView' pelo nome correto da sua view
}


    // Criar um novo motivo de entrada
    public function store(Request $request)
    {

        $motivo = new ModelMotivoEntrada();

        $motivo->motivoEntrada = $request->motivoEntrada; // Atribui o valor do motivo de entrada
        // $motivo->dataCadasroMotivoEntrada = now(); // Se você tiver um campo de data de cadastro, use isso

        $motivo->save(); // Salva o motivo de entrada no banco de dados

        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Motivo de entrada cadastrado com sucesso!'], 201);
    }



    // Exibir um motivo de entrada específico
    public function show($id)
    {
        $motivo = ModelMotivoEntrada::find($id);
        if (!$motivo) {
            return response()->json(['message' => 'Motivo não encontrado'], 404);
        }
        return response()->json($motivo);
    }

    // Atualizar um motivo de entrada existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'motivoEntrada' => 'required|string|max:200',
        ]);

        $motivo = ModelMotivoEntrada::find($id);
        if (!$motivo) {
            return response()->json(['message' => 'Motivo não encontrado'], 404);
        }

        $motivo->update($request->all());
        return response()->json($motivo);
    }
    public function edit($id)
    {
        $motivo = ModelMotivoEntrada::find($id);
        
        
    if (!$motivo) {
            return redirect()->back()->with('error', 'Motivo de entrada não encontrado.');
        }
        return view('motivEntradaEdit', compact('motivo'));
    }
    // Deletar um motivo de entrada
    public function destroy($id)
    {
        $motivo = ModelMotivoEntrada::find($id);
        if (!$motivo) {
            return response()->json(['message' => 'Motivo não encontrado'], 404);
        }

        $motivo->delete();
        return response()->json(['message' => 'Motivo deletado com sucesso']);
    }
}
