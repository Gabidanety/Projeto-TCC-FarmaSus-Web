<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelefoneUBSModel;
use App\Models\UBSModel;
use App\Models\RegiaoUBSModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;


use App\Mail\UBSRegistrationSuccessMail;
use Illuminate\Support\Facades\Mail;

class UBSController extends Controller
{

    private function formatarCnpj($cnpj)
{
    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $cnpj);
}

    public function index()
    {
        // $ubs = UBSModel::all(); // Busca todos os dados da UBS
        // return view('adm.Ubs.UBS', ['ubs' => $ubs]); // Passa os dados para a view

        $ubs = UBSModel::with(['regiao', 'telefone'])->get(); // Certifique-se de que os relacionamentos estão definidos
        return view('adm.Ubs.UBS', compact('ubs'));
    }

   
    public function apresentarRegiao()
    {
        $regioes = RegiaoUBSModel::all();
        return view('adm.Ubs.formUBS', compact('regioes')); // Passa os dados para a view
    }
    public function store(Request $request)
    {
        // Defina a URL base do ngrok aqui
        $ngrokUrl = "https://1cf2-2804-7f0-b900-986f-3522-7a-7a17-3c7d.ngrok-free.app";
    
        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'ubs' => 'required|string|max:255',
            'fotoUBS' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'cnpj' => 'required|string|max:14',
            'cep' => 'required|string|max:10',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'idRegiao' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Busca o endereço usando ViaCEP
        $cep = $request->cep;
        $viacepResponse = Http::get("https://viacep.com.br/ws/{$cep}/json/");
    
        if ($viacepResponse->failed()) {
            return response()->json(['message' => 'CEP inválido ou ViaCEP indisponível.'], 400);
        }
    
        $endereco = $viacepResponse->json();
    
        // Se o CEP foi encontrado, obtem o logradouro, bairro, cidade e uf
        $logradouro = $endereco['logradouro'] ?? '';
        $bairro = $endereco['bairro'] ?? '';
        $cidade = $endereco['localidade'] ?? '';
        $uf = $endereco['uf'] ?? '';
    
        // Obtém as coordenadas geográficas usando Nominatim
        $query = urlencode("{$logradouro}, {$bairro}, {$cidade}, {$uf}");
        $nominatimResponse = Http::get("https://nominatim.openstreetmap.org/search?q={$query}&format=json");
    
        $latitude = null;
        $longitude = null;
    
        if ($nominatimResponse->successful() && count($nominatimResponse->json()) > 0) {
            $location = $nominatimResponse->json()[0];
            $latitude = $location['lat'];
            $longitude = $location['lon'];
        }
    
        // Cadastrar o telefone primeiro
        $telefone = new TelefoneUBSModel();
        $telefone->numeroTelefoneUBS = $request->telefone;
        $telefone->numeroTelefoneUBS2 = $request->telefone2;
        $telefone->situacaoTelefoneUBS = $request->situacaoTelefone ?? '1'; // Define 1 se não for passado
        $telefone->dataCadastroTelefoneUBS = now();
        $telefone->save();
    
        $telefoneId = $telefone->idTelefoneUBS;
    
        if ($request->filled('telefone2')) {
            $telefone->numeroTelefoneUBS2 = $request->telefone2;
            $telefone->save();
        }
    
        // Formatar o CNPJ
        $cnpjFormatado = $this->formatarCnpj($request->cnpj);
    
        // Cadastrar a UBS
        $ubs = new UBSModel();
        $ubs->nomeUBS = $request->ubs;
        $ubs->emailUBS = $request->email;
    
        // Salvar a imagem da UBS e gerar URL acessível com o domínio do ngrok
        if ($request->hasFile('fotoUBS')) {
            $fileUbs = $request->file('fotoUBS');
            $pathUbs = $fileUbs->store('ubs_fotos', 'public'); // Armazena no disco 'public'
            $ubs->fotoUBS = "{$ngrokUrl}/storage/{$pathUbs}"; // Salva a URL com o domínio do ngrok
        }
    
        $ubs->cnpjUBS = $cnpjFormatado;
        $ubs->latitudeUBS = $request->latitude;
        $ubs->longitudeUBS = $request->longitude;
        $ubs->cepUBS = $request->cep;
        $ubs->logradouroUBS = $logradouro;
        $ubs->bairroUBS = $bairro;
        $ubs->estadoUBS = $uf;
        $ubs->cidadeUBS = $cidade;
        $ubs->numeroUBS = $request->numero;
        $ubs->ufUBS = $uf;
        $ubs->complementoUBS = $request->complemento;
        $ubs->senhaUBS = bcrypt($request->senha); // Criptografando a senha
        $ubs->situacaoUBS = '1'; // Definindo a situação automaticamente como 1
        $ubs->dataCadastroUBS = now();
        $ubs->idTelefoneUBS = $telefoneId; // ID do telefone
        $ubs->idRegiaoUBS = $request->idRegiao; // ID da região
    
        $ubs->save();
    
        try {
            Mail::to('vini.va338@gmail.com')->send(new \App\Mail\UBSRegistrationSuccessMail($ubs));
        } catch (\Exception $e) {
            return redirect('/selectUBS')->with('error', 'UBS criada, mas ocorreu um erro ao enviar o e-mail: ' . $e->getMessage());
        }
        
        // Redireciona para a página /selectUBS com uma mensagem de sucesso
        return redirect('/selectUBS')->with('success', 'UBS cadastrada com sucesso! Confira sua caixa de entrada do e-mail.');
    }
    

    
    public function updateapi(Request $request, $id)
    {
        UBSModel::where('idUBS', $id)->update([
            'nomeUBS' => $request->nome,
            'cnpjUBS' => $request->cnpj,
            'logradouroUBS' => $request->logradouro,
            'bairroUBS' => $request->bairro,
            'cidadeUBS' => $request->cidade,
            'numeroUBS' => $request->numero,
            'ufUBS' => $request->uf,
            'cepUBS' => $request->cep,
            'complementoUBS' => $request->complemento,
            'situacaoUBS' => $request->situacao,
        ]);

        return response()->json(['message' => 'Sucesso', 'code' => 200]);
    }

    // public function edit($idUBS)
    // {
    //     // Busca a UBS pelo ID
    //     $ubs = UBSModel::findOrFail($idUBS);
    
    //     // Busca o telefone relacionado à UBS
    //     $telefone = TelefoneUBSModel::findOrFail($ubs->idTelefoneUBS);
    
    //     // Busca a região relacionada à UBS
    //     $regiao = RegiaoUBSModel::all();
        
    //     // Retorna a view de edição com os dados da UBS
    //     return view('adm.Ubs.editUBS', compact('ubs', 'telefone', 'regiao'));
    // }    

    public function edit($idUBS)
{
    // Busca a UBS pelo ID
    $ubs = UBSModel::findOrFail($idUBS);
    
    // Busca o telefone relacionado à UBS
    $telefone = TelefoneUBSModel::findOrFail($ubs->idTelefoneUBS);
    
    // Busca a região específica relacionada à UBS
    $regiao = RegiaoUBSModel::findOrFail($ubs->idRegiaoUBS);

    // Busca todas as regiões para preencher o select na view
    $regioes = RegiaoUBSModel::all();
    
    // Retorna a view de edição com os dados da UBS
    return view('adm.Ubs.editUBS', compact('ubs', 'telefone', 'regiao', 'regioes'));
}



// public function verificarEmail(Request $request)
// {
//     // Valida os dados recebidos
  
//     try {
//         // Busca a UBS pelo e-mail na tabela tbubs
//         $ubs = UBSModel::where('emailUBS', $request->email)->firstOrFail();

//         // Atualiza a senha da UBS
//         $ubs->senhaUBS = bcrypt($request->senha);
//         $ubs->save();

//         return redirect('/homeFarmacia')->with('success', 'Senha atualizada com sucesso!');
//     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//         return response()->json(['message' => 'UBS não encontrada.'], 404);
//     }
// }

public function verificarEmail(Request $request)
{
    // Valida os dados recebidos
    try {
        // Busca a UBS pelo e-mail na tabela tbubs
        $ubs = UBSModel::where('emailUBS', $request->email)->firstOrFail();

        // Atualiza a senha da UBS
        $ubs->senhaUBS = bcrypt($request->senha);
        $ubs->save();

        // Armazena o id da UBS na sessão
        session(['idUBS' => $ubs->idUBS]);

        // Redireciona para a página /homeFarmacia
        return redirect('/homeFarmacia')->with('success', 'Senha atualizada com sucesso!');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['message' => 'UBS não encontrada.'], 404);
    }
}

// Em algum controlador que carrega a página FormsMed
public function showFormsMed()
{
    // Acessando a variável idUBS da sessão
    $idUBS = session('idUBS');

    // Aqui você pode usar o idUBS conforme necessário
    return view('farmacia.Medicamento.cadMedicamento', compact('idUBS'));
}

// Método no controlador de login (após a verificação de login)
public function login(Request $request)
{
    // Busca a UBS usando o CNPJ fornecido
    $ubs = UBSModel::where('cnpj', $request->cnpj)->first();

    // Verifica se a UBS foi encontrada e a senha é válida
    if ($ubs && Hash::check($request->senha, $ubs->senhaUBS)) {
        // Armazena o emailUBS na sessão
        session(['emailUBS' => $ubs->emailUBS]);

        // Redireciona para a página do perfil
        return redirect()->route('perfil');
    } else {
        // Se as credenciais estiverem incorretas
        return redirect()->back()->with('error', 'Credenciais inválidas');
    }
}





public function perfil()
{
    // Recupera o email da sessão
    $emailUBS = session('emailUBS');

    // Se o emailUBS não estiver na sessão, redireciona para o login
    if (!$emailUBS) {
        return redirect('/login')->with('error', 'Você precisa estar logado para acessar o perfil.');
    }

    // Busca a UBS no banco de dados com o email armazenado na sessão
    $ubs = UBSModel::where('emailUBS', $emailUBS)->first();

    // Se a UBS não for encontrada, redireciona para o login
    if (!$ubs) {
        return redirect('/login')->with('error', 'UBS não encontrada.');
    }

    // Caso a UBS seja encontrada, exibe o perfil
    return view('farmacia.perfilFarmacia', compact('ubs'));
}

// Método de logout no controlador
public function logout()
{
    session()->forget('emailUBS');
    return redirect('/login');
}


public function update(Request $request, $id)
{
    // Validação dos dados
    $validator = Validator::make($request->all(), [
        'nomeUBS' => 'required|string|max:255',
        'cnpjUBS' => 'required|string|max:14',
        'logradouroUBS' => 'required|string|max:255',
        'bairroUBS' => 'required|string|max:255',
        'cidadeUBS' => 'required|string|max:255',
        'numeroUBS' => 'required|string|max:10',
        'ufUBS' => 'required|string|max:2',
        'cepUBS' => 'required|string|max:10',
        'complementoUBS' => 'nullable|string|max:255',
        'telefone' => 'required|string|max:15',
        'idRegiao' => 'required|exists:tbRegiaoUBS,idRegiaoUBS', // Adicionando a validação para o ID da região
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Atualiza a UBS
    $ubs = UBSModel::findOrFail($id);
    $ubs->update([
        'nomeUBS' => $request->nomeUBS,
        'cnpjUBS' => $request->cnpjUBS,
        'logradouroUBS' => $request->logradouroUBS,
        'bairroUBS' => $request->bairroUBS,
        'cidadeUBS' => $request->cidadeUBS,
        'numeroUBS' => $request->numeroUBS,
        'ufUBS' => $request->ufUBS,
        'idRegiaoUBS' => $request->idRegiao, // Atualizando o ID da região
        'cepUBS' => $request->cepUBS,
        'complementoUBS' => $request->complementoUBS,
        'situacaoUBS' => $request->situacaoUBS ?? '1', // Define '1' se o campo não for enviado
    ]);

    // Atualiza o telefone
    $telefone = TelefoneUBSModel::findOrFail($ubs->idTelefoneUBS);
    $telefone->update([
        'numeroTelefoneUBS' => $request->telefone,
        'situacaoTelefoneUBS' => $request->situacaoTelefone ?? '1', // Define '1' se o campo não for enviado
    ]);

    return redirect('/selectUBS')->with('message', 'UBS e telefone atualizados com sucesso!');
}

public function changeStatus($idUBS)
{
    // Encontre a unidade básica de saúde pelo ID
    $ub = UBSModel::findOrFail($idUBS); // Corrigido para usar UBSModel
    
    // Troca o estado: se for 1, muda para 0; se for 0, muda para 1
    $ub->situacaoUBS = $ub->situacaoUBS == 1 ? 0 : 1; // Aqui deve ser 'situacaoUBS', não 'estado'
    $ub->save();

    // Retorna uma resposta
    return redirect()->back()->with('success', 'Estado alterado com sucesso!');
}


// API
public function indexApi()
{
    // Obter todos os registros de UBS do modelo
    $ubs = UBSModel::all();

    // Retornar a resposta JSON com os dados e uma mensagem de sucesso
    return response()->json([
        'message' => 'Sucesso',
        'code' => 200,
        'data' => $ubs // Inclui os dados obtidos do modelo
    ]);
}
}