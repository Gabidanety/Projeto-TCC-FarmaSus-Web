<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteAdmModel; // Corrigi o nome do model ClienteAdm
use App\Models\TelefoneClienteAdmModel; // Model do telefone

class ClienteAdmController extends Controller // Corrigi o nome do controller
{
    public function index()
    {
        $cliente = ClienteAdmModel::where('situacaoCliente', 0)->get(); // Exibe apenas os clientes ativos
        return view('Adm.Cliente.Cliente', ['clientes' => $cliente]); // Passando os dados de forma explícita
    }
    
    public function indexLogin()
    {
        $clientes = ClienteAdmModel::all(); 
        return response()->json($clientes); // Retorna dados como JSON
    }

    // Exibir o formulário de criação (view chamada 'cadastros')
    public function create()
    {
        return view('Adm.Cliente.clienteInsert'); // Renderiza a view onde está o formulário
    }

    // Armazenar cliente e telefone
    public function store(Request $request)
    {

        // Validação dos dados de entrada
    $request->validate([
        'cpfCliente' => 'required|unique:tbCliente,cpfCliente',
        'cnsCliente' => 'required|unique:tbCliente,cnsCliente',
        'telefoneCliente' => 'required|unique:tbTelefoneCliente,numeroTelefoneCliente',
    ], [
        'cpfCliente.unique' => 'Este CPF já está cadastrado.',
        'cnsCliente.unique' => 'Este CNS já está cadastrado.',
        'telefoneCliente.unique' => 'Este telefone já está cadastrado.',
    ]);

        // Remover caracteres especiais do CPF e do telefone antes de salvar
        $cpfLimpo = preg_replace('/[^0-9]/', '', $request->cpfCliente);
        $telefoneLimpo = !empty($request->telefoneCliente) ? preg_replace('/[^0-9]/', '', $request->telefoneCliente) : null;
    
        // Verifica se o campo de telefone foi preenchido
        if (!empty($telefoneLimpo)) {
            // Criação do telefone, se o telefone for fornecido
            $telefone = new TelefoneClienteAdmModel();
            $telefone->numeroTelefoneCliente = $telefoneLimpo;
            $telefone->situacaoTelefoneCliente = '0'; // Valor padrão se não fornecido
            $telefone->dataCadastroTelefoneCliente = now();
            $telefone->save();
        }
    
        // Criação do cliente
        $cliente = new ClienteAdmModel();
        $cliente->nomeCliente = $request->nomeCliente;
        $cliente->cpfCliente = $cpfLimpo; // Salvar CPF sem formatação
        $cliente->cnsCliente = $request->cnsCliente;
        $cliente->dataNascCliente = $request->dataNascCliente;
        $cliente->userCliente = $request->userCliente ?? null;
        $cliente->cepCliente = $request->cepCliente;
        $cliente->logradouroCliente = $request->logradouroCliente;
        $cliente->bairroCliente = $request->bairroCliente;
        $cliente->numeroCliente = $request->numeroCliente;
        $cliente->estadoCliente = $request->estadoCliente;
        $cliente->cidadeCliente = $request->cidadeCliente;
        $cliente->ufCliente = $request->ufCliente;
        $cliente->complementoCliente = $request->complementoCliente;
    
        // Verifica se o telefone foi criado e associa o cliente ao telefone, se houver
        if (isset($telefone)) {
            $cliente->idTelefoneCliente = $telefone->idTelefoneCliente; // Relacionando o cliente ao telefone
        } else {
            $cliente->idTelefoneCliente = null; // Caso não tenha telefone
        }
    
        $cliente->situacaoCliente = '0'; // Valor padrão se não fornecido
        $cliente->dataCadastroCliente = now();
        $cliente->save();
    
        return view('Adm.Cliente.Cliente')->with('success', 'Cliente criado com sucesso!');
    }
    
    // Métodos de API e outros
    public function storeapi(Request $request)
    {
       $cliente = new ClienteAdmModel(); // Corrigi o nome do model 
        $cliente->cnsCliente = $request->cns;
        $cliente->emailCliente = $request->email;
        $cliente->senhaCliente = bcrypt($request->senha); // Criptografar a senha
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
            $cliente = ClienteAdmModel::findOrFail($id);
            $telefone = TelefoneClienteAdmModel::where('idTelefoneCliente', $cliente->idTelefoneCliente)->first(); // Busca o telefone
        
            return view('Adm.Cliente.clienteEditar', compact('cliente', 'telefone'));
        }
        public function update(Request $request, $id)
{
    // Validação dos dados de entrada
    // $request->validate([...]);

    // Busca o cliente pelo ID
    $cliente = ClienteAdmModel::findOrFail($id);

    // Limpa o número do novo telefone
    $novoNumeroTelefone = preg_replace('/[^0-9]/', '', $request->numeroTelefoneCliente);

    // Verifica se o número do telefone tem 11 caracteres
    if (strlen($novoNumeroTelefone) > 11) {
        return redirect()->back()->with('error', 'O número do telefone deve ter no máximo 11 caracteres.');
    }

    // Verifica se o CPF já existe, mas ignora o cliente atual
    $clienteExistente = ClienteAdmModel::where('cpfCliente', $request->cpfCliente)
                                       ->where('idCliente', '!=', $cliente->idCliente)
                                       ->first();

    if ($clienteExistente) {
        // Se o cliente com o mesmo CPF já existe, retorna um erro
        return redirect()->back()->with('error', 'Já existe um cliente com este CPF.');
    }

    // Desativa o telefone antigo se houver
    if ($cliente->idTelefoneCliente) {
        $telefoneAntigo = TelefoneClienteAdmModel::find($cliente->idTelefoneCliente);
        if ($telefoneAntigo) {
            $telefoneAntigo->situacaoTelefoneCliente = '1'; // Desativa o telefone antigo
            $telefoneAntigo->save();
        }
    }

    // Verifica se o novo número de telefone foi fornecido
    if ($request->filled('numeroTelefoneCliente')) {
        // Verifica se já existe um telefone cadastrado
        $telefoneExistente = TelefoneClienteAdmModel::where('numeroTelefoneCliente', $novoNumeroTelefone)->first();

        if (!$telefoneExistente) {
            // Criação do telefone se não existir
            $novoTelefone = new TelefoneClienteAdmModel();
            $novoTelefone->numeroTelefoneCliente = $novoNumeroTelefone;
            $novoTelefone->situacaoTelefoneCliente = '0'; // Valor padrão se não fornecido
            $novoTelefone->dataCadastroTelefoneCliente = now();
            $novoTelefone->save();

            // Associar o telefone recém-criado ao cliente
            $idTelefone = $novoTelefone->idTelefoneCliente;
        } else {
            // Se o telefone já existe, use o ID do telefone existente
            $idTelefone = $telefoneExistente->idTelefoneCliente;
        }
    } else {
        // Se o novo número de telefone não foi fornecido, mantém o telefone atual
        $idTelefone = $cliente->idTelefoneCliente;
    }

    // Atualiza os dados do cliente
    $cliente->nomeCliente = $request->nomeCliente;
    $cliente->cpfCliente = $request->cpfCliente;
    $cliente->cnsCliente = $request->cnsCliente;
    $cliente->dataNascCliente = $request->dataNascCliente;
    $cliente->userCliente = $request->userCliente;
    $cliente->cepCliente = $request->cepCliente;
    $cliente->logradouroCliente = $request->logradouroCliente;
    $cliente->bairroCliente = $request->bairroCliente;
    $cliente->estadoCliente = $request->estadoCliente;
    $cliente->cidadeCliente = $request->cidadeCliente;
    $cliente->numeroCliente = $request->numeroCliente;
    $cliente->ufCliente = $request->ufCliente;
    $cliente->complementoCliente = $request->complementoCliente;
    $cliente->idTelefoneCliente = $idTelefone; // Associa o telefone

    // Salva as alterações
    $cliente->save();

    // Redireciona com mensagem de sucesso
    return redirect()->back()->with('success', 'Cliente Atualizado com Sucesso!');
}


    
    
    public function updateapi(Request $request, $id)
    {
        ClienteAdmModel::where('idCliente', $id)->update([ // Corrigi o nome do model
            'nomeCliente' => $request->nomeCliente,
            'cpfCliente' => $request->cpfCliente,
            'cnsCliente' => $request->cnsCliente,
            'emailCliente' => $request->emailCliente,
            'senhaCliente' => bcrypt($request->senhaCliente), // Encrypta a senha
        ]);

        return response()->json([
            'message' => 'Sucesso',
            'code' => 200
        ]);
    }

    public function destroy($id)
    {
        // Tenta encontrar o cliente pelo ID
        $cliente = ClienteAdmModel::find($id);
        
        // Verifica se o cliente existe
        if ($cliente) {
            // Atualiza a situação do cliente para '1' (inativo ou invisível)
            $cliente->situacaoCliente = 1;
            $cliente->save(); // Salva a mudança no banco de dados
    
            return redirect()->back()->with('success', 'Cliente desativado.');
        } else {
            return redirect()->back()->with('error', 'Cliente não encontrado.');
        }
    }

    public function filtros(Request $request)
{
    $queryInput = $request->input('query'); // Nome único para a pesquisa geral

    // Consulta personalizada de acordo com os filtros
    $query = ClienteAdmModel::query();

    if (!empty($queryInput)) {
        $query->where(function($q) use ($queryInput) {
            $q->where('nomeCliente', 'like', '%' . $queryInput . '%')
              ->orWhere('cpfCliente', $queryInput)
              ->orWhere('cnsCliente', $queryInput)
              ->orWhere('ufCliente', 'like', '%' . $queryInput . '%');
        });
    }

    $clientes = $query->get();

    // Retorna a mesma view, mas com os resultados filtrados e os dados de entrada
    return view('Adm.Cliente.Cliente', compact('clientes', 'queryInput'));
}

public function indexApi()
{
    $cliente = ClienteAdmModel::all();
    return response()->json([
        'message' => 'Sucesso',
        'code' => 200,
        'data' => $cliente 
    ]);
} 
    
    
}
