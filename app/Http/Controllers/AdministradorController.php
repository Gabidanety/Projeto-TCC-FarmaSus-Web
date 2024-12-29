<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdministradorModel; // Corrigi o nome do model ClienteAdm
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // LOGIN

    public function logout()
    {
        Auth::logout(); // Desloga o usuário
        // session()->forget('user_id'); // Remove o ID do usuário da sessão

        session()->flash('message', 'Você foi deslogado com sucesso.'); // Armazena a mensagem na sessão

        return redirect('/login'); // Redireciona para a página de login
    }


    public function login(Request $request)
    {
        // Validar o input
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        // Encontrar o usuário pelo email no banco correto
        $user = AdministradorModel::where('emailAdministrador', $request->email)->first();

        // Verificar se a senha está correta
        if ($user && Hash::check($request->senha, $user->senhaAdministrador)) {

            // Logar o administrador com o guard 'admin'
            Auth::guard('admin')->login($user);

            session()->flash('message', 'Bem-vindo administrador, ' . $user->nomeAdministrador . '! Pronta(o) para fazer um check-up?');

            return redirect('/'); 

        } else {
            session()->flash('error', 'Email ou senha incorretos.');
            return redirect()->back();    
        }
    }   

    public function getAuthIdentifierName()
    {
        return 'idAdministrador'; // Nome do campo de ID no banco
    }
    
    public function getAuthIdentifier()
    {
        return $this->getKey(); // Retorna a chave primária
    }
    
    
    public function showProfile()
    {
        $admin = Auth::user(); // Obtém o administrador logado

        if (!$admin) {
            // Se não houver administrador logado, redireciona para a página de login
            return redirect()->route('login')->with('message', 'Você precisa estar logado para acessar esta página.');
        }
        return view('adm.Perfil.perfil', compact('admin')); // Passa o administrador para a view
    }
    public function store(Request $request)
    {

        // ALTER TABLE tbadministrador MODIFY senhaAdministrador VARCHAR(100);

        $adm = new AdministradorModel();

        $adm->fotoAministrador = "sem foto";
        $adm->nomeAdministrador = $request->nome;
        $adm->emailAdministrador = $request->email;
        $adm->senhaAdministrador = Hash::make($request->senha); //  
        $adm->situacaoAdministrador = 'A'; // Por exemplo, 'A' para ativo
        $adm->dataCadastroAdministrador = now(); // Data atual 
        $adm->save();

        // Redirecionar ou retornar uma resposta
        return redirect('/')->with('success', 'Administrador cadastrado com sucesso!');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
