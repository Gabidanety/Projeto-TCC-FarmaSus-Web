<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContatoModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RespostaContatoMail; // Adicione esta linha

class ContatoController extends Controller
{
    public function index()
    {
        // Carregar os contatos com seus respectivos usuários
        $contatos = ContatoModel::with('usuario')->where('situacaoContato', 1)->get(); // Certifique-se de filtrar contatos ativos
        return view('adm.contato', compact('contatos'));
    }

    public function store(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'idUsuario' => 'required|integer',
            'emailUsuario' => 'required|email',
            'mensagemContato' => 'required|string',
        ]);
    
        // Verificação de duplicação robusta
        DB::beginTransaction();
    
        try {
            $existingContato = ContatoModel::where('idUsuario', $request->idUsuario)
                ->where('emailUsuario', $request->emailUsuario)
                ->where('mensagemContato', $request->mensagemContato)
                ->first();
    
            if ($existingContato) {
                DB::rollBack(); 
                return response()->json(['message' => 'Esse contato já foi enviado anteriormente.'], 409);
            }
    
            // Criação do novo contato
            $contato = new ContatoModel();
            $contato->idUsuario = $request->idUsuario;
            $contato->idDetentor = $request->idDetentor; // Certifique-se de que este campo está sendo enviado
            $contato->idMedicamento = $request->idMedicamento; // Certifique-se de que este campo está sendo enviado
            $contato->situacaoContato = 1; // Mantendo como ativo
            $contato->emailUsuario = $request->emailUsuario;
            $contato->mensagemContato = $request->mensagemContato;
            $contato->dataCadastroContato = now();
    
            $contato->save();
    
            // Enviar email
            Mail::to('glow.etec@gtmail.com')->send(new RespostaContatoMail([
                'idUsuario' => $request->input('idUsuario'),
                'emailUsuario' => $request->input('emailUsuario'),
                'mensagemContato' => $request->input('mensagemContato'),
            ]));
    
            DB::commit(); 
    
            return response()->json(['message' => 'Contato criado com sucesso!'], 201);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['message' => 'Erro ao criar o contato: ' . $e->getMessage()], 500);
        }
    }


    public function excluir(Request $request, $id)
    {
        // Encontra o contato pelo ID
        $contato = ContatoModel::find($id);
        if (!$contato) {
            return redirect()->back()->with('error', 'Contato não encontrado.');
        }

        // Altera a situação do contato para 0 (inativo)
        $contato->situacaoContato = 0; // Define como inativo
        $contato->save();

        // Mensagem de sucesso
        return redirect()->route('contato.index')->with('success', 'Contato excluído com sucesso!');
    }


    public function resposta(Request $request, $id)
{
    // Validação da resposta
    $request->validate([
        'resposta' => 'required|string',
    ]);

    // Encontra o contato pelo ID
    $contato = ContatoModel::find($id);
    if (!$contato) {
        return response()->json(['message' => 'Contato não encontrado.'], 404);
    }

    // Salva a resposta
    $contato->respostaContato = $request->input('resposta');
    $contato->save();

    // Aqui você pode enviar um e-mail se necessário

    return response()->json(['message' => 'Resposta enviada com sucesso!'], 200);
}

    
}
