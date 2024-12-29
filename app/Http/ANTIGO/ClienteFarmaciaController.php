<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteFarmaciaModel;
use App\Models\TelefoneClienteFarmaciaModel;
use Illuminate\Routing\Controller;

class ClienteFarmaciaController extends Controller
{
    public function index()
    {
        $clientes = ClienteFarmaciaModel::all(); // Busca todos os clientes
        return response()->json($clientes); // Retorna os clientes em formato JSON
    }

    public function indexLogin()
    {
        $clientes = ClienteFarmaciaModel::all();
        return response()->json($clientes); // Retorna dados como JSON
    }

    // Exibir o formulário de criação (view chamada 'cadastros')
    public function create()
    {
        return view('farmacia.cadastros'); // Renderiza a view onde está o formulário
    }

    // Armazenar cliente e telefone
    public function store(Request $request)
    {
    
        // Criação do telefone
        $telefone = new TelefoneClienteFarmaciaModel();
        $telefone->numeroTelefoneCliente = $request->numeroTelefoneCliente;
        $telefone->situacaoTelefoneCliente = '0'; // Definindo o valor padrão como 0
        $telefone->dataCadastroTelefoneCliente = now();
        $telefone->save();

        // Criação do cliente
        $cliente = new ClienteFarmaciaModel();
        $cliente->nomeCliente = $request->nomeCliente;
        $cliente->cpfCliente = $request->cpfCliente;
        $cliente->dataNascCliente = $request->dataNascCliente;
        $cliente->userCliente = $request->userCliente;
        $cliente->cepCliente = $request->cepCliente;
        $cliente->logradouroCliente = $request->logradouroCliente;
        $cliente->bairroCliente = $request->bairroCliente;
        $cliente->numeroCliente = $request->numeroCliente;
        $cliente->estadoCliente = $request->estadoCliente;
        $cliente->cidadeCliente = $request->cidadeCliente;
        $cliente->ufCliente = $request->ufCliente;
        $cliente->complementoCliente = $request->complementoCliente;
        $cliente->idTelefoneCliente = $telefone->idTelefoneCliente; // Relacionando com o telefone
        $cliente->situacaoCliente = '0'; // Definindo o valor padrão como 0
        $cliente->dataCadastroCliente = now();
        $cliente->save();

        return redirect()->back()->with('success', 'Cliente criado com sucesso!');
    }

    // Métodos de API e outros
    public function storeapi(Request $request)
    {
        $cliente = new ClienteFarmaciaModel();
        $cliente->cnsCliente = $request->cns;
        $cliente->emailCliente = $request->email;
        $cliente->senhaCliente = bcrypt($request->senha);
        $cliente->userCliente = $request->user;
        $cliente->save();

        return response()->json(['message' => 'Cliente criado com sucesso!'], 201);
    }

    public function show($id)
    {
        // Lógica para mostrar um cliente específico
    }

    public function edit($id)
    {
        // Lógica para editar um cliente específico
    }

    public function updateapi(Request $request, $id)
    {
        ClienteFarmaciaModel::where('idCliente', $id)->update([
            'nomeCliente' => $request->nomeCliente,
            'cpfCliente' => $request->cpfCliente,
            'cnsCliente' => $request->cnsCliente,
            'emailCliente' => $request->emailCliente,
            'senhaCliente' => $request->senhaCliente, // Encrypta a senha
        ]);

        return response()->json([
            'message' => 'Sucesso',
            'code' => 200
        ]);
    }

    public function destroy($id)
    {
        // Lógica para remover um cliente específico
    }
}
