<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Validator; // Importar o validador

class UsuarioController extends Controller
{
    // Retornar todos os usuários (se necessário)
    public function index()
    {
        $usuarios = UsuarioModel::all();
        return response()->json($usuarios);
    }

    // Método para armazenar um novo usuário
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:tbUsuario,emailUsuario|max:255', // Validação de e-mail único
            'foto' => 'nullable|string', // Opcional, pode ajustar de acordo com suas necessidades
            'cns' => 'nullable|string|max:255', // Ajuste conforme a necessidade
            'situacao' => 'required|boolean', // Considerando que seja uma flag booleana
            'senha' => 'required|string|min:6', // Adiciona validação de senha
        ]);

        // Se a validação falhar, retornar os erros
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Criação do usuário
        try {
            $usuario = new UsuarioModel();
            $usuario->nomeUsuario = $request->nome;
            $usuario->fotoUsuario = $request->foto;
            $usuario->cnsUsuario = $request->cns;
            $usuario->situacaoUsuario = $request->situacao;
            $usuario->senhaUsuario = bcrypt($request->senha); // Criptografando a senha
            $usuario->dataCadastroUsuario = now();
            $usuario->emailUsuario = $request->email;

            // Salva o usuário no banco
            $usuario->save();

            return response()->json(['message' => 'Usuário criado com sucesso!'], 201);
        } catch (\Exception $e) {
            // Tratamento de exceção
            return response()->json(['message' => 'Erro ao criar o usuário', 'error' => $e->getMessage()], 500);
        }
    }

    public function storeapi(Request $request)
    {
        $usuario = new UsuarioModel();
        
        $usuario->nomeUsuario = $request->nome;
        $usuario->fotoUsuario = $request->foto;
        $usuario->cnsUsuario = $request->cns;
        $usuario->situacaoUsuario = $request->situacao;
        $usuario->senhaUsuario = $request->senha;
        $usuario->dataCadastroUsuario = now(); // Converte para YYYY-MM-DD

       
        $usuario->save();  
        return response()->json(['message' => 'Usuario criado com sucesso!'], 201);


    }

    // Método para atualizar um usuário existente
    public function updateapi(Request $request, $id)
    {
        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:tbUsuario,emailUsuario,' . $id . ',idUsuario|max:255', // Ignora o e-mail do próprio usuário
            'foto' => 'nullable|string',
            'cns' => 'nullable|string|max:255',
            'situacao' => 'required|boolean',
            'senha' => 'nullable|string|min:6', // Se a senha for opcional durante a atualização
        ]);

        // Se a validação falhar, retornar os erros
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Atualização do usuário
        try {
            $usuario = UsuarioModel::findOrFail($id);

            // Atualizando os campos
            $usuario->nomeUsuario = $request->nome;
            $usuario->fotoUsuario = $request->foto;
            $usuario->cnsUsuario = $request->cns;
            $usuario->situacaoUsuario = $request->situacao;
            if ($request->filled('senha')) {
                $usuario->senhaUsuario = bcrypt($request->senha); // Criptografar se houver senha nova
            }
            $usuario->emailUsuario = $request->email;
            $usuario->save();

            return response()->json(['message' => 'Usuário atualizado com sucesso!'], 200);
        } catch (\Exception $e) {
            // Tratamento de exceção
            return response()->json(['message' => 'Erro ao atualizar o usuário', 'error' => $e->getMessage()], 500);
        }
    }

    public function indexApi()
    {
        $usuarios = UsuarioModel::all();
        return response()->json([
            'message' => 'Sucesso',
            'code' => 200,
            'data' => $usuarios 
        ]);
    }  

    public function getUserByCNS($cns)
{
    // Verificar se existe um usuário com o CNS fornecido
    $user = UsuarioModel::where('cnsUsuario', $cns)->first();
    
    // Se o usuário não for encontrado, retorna uma mensagem de erro
    if (!$user) {
        return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    // Retorna os dados do usuário
    return response()->json([
        'id' => $user->idUsuario,
        'nome_usuario' => $user->nomeUsuario,
        'cns' => $user->cnsUsuario,
        'foto' => $user->fotoUsuario,
    ]);
}

  
}
