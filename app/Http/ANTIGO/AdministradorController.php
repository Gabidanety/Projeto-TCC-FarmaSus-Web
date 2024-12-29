<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Controllers\Controller;

use App\Models\AdministradorModel;

use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class AntigoAdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = 'select * from tbAdministrador';

        $resultado = DB::select($sql);

        return $resultado;    
    }

    // LOGIN

    public function logout()
    {
        Auth::logout(); // Desloga o usuário

        return view('adm.login'); // Redireciona para a página de login
    }

    public function login(Request $request)
    {
            // Validar o input
            $request->validate([
                'email' => 'required|email',
                'senha' => 'required|',
            ]);
    
            // Encontrar o usuário pelo email no banco correto
            $user = AdministradorModel::where('emailAdministrador', $request->email)->first();
    
            // Verificar se a senha está correta
            if ($user && Hash::check($request->senha, $user->senhaAdministrador)) {
                
                Auth::login($user);
                
                session()->flash('message', 'Bem-vindo administrador, ' . $user->nomeAdministrador . '! Pronta(o) para fazer um check-up?');

                return redirect()->route('homeAdm'); // Redireciona para a rota 'home do adm'

            } else {
                return response()->json(['error' => 'Credenciais inválidas.'], 401);
            }
     }

    //  public function perfil()
    //     {
    //         $user = Auth::user(); // Obtém o usuário autenticado

    //         // Verifique se o usuário está autenticado
    //         if (!$user) {
    //             return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar essa página.');
    //         }
        
    //         return view('adm.perfil', ['user' => $user]); // Passa o usuário para a visão
    //     }

    
        

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

     //cadastro web
    public function store(Request $request)
    {
        $adm = new AdministradorModel();
        
        //$clienteModel->idCliente = $request->id;
        $adm->nomeAdministrador = $request->nome;
        $adm->emailAdministrador = $request->email;
        $adm->senhaAdministrador = Hash::make($request->senha); //senha criptografada
        $adm->tipoAdministrador = $request->tipoAdministrador;
        $adm->dataCadastroAdministrador = now(); 
      
        $adm->save();  

        return redirect('/');

    }
    public function storeapi(Request $request)
    {
        $adm = new AdministradorModel();

        //$clienteModel->idCliente = $request->id;
        $adm->nomeAdministrador = $request->nome;
        $adm->emailAdministrador = $request->email;
        $adm->senhaAdministrador = $request->senha;
        $adm->tipoAdministrador = $request->tipoAdministrador;
        $adm->dataCadastroAdministrador = $request->dataCadastro;


      
        $adm->save(); 

        return response()->json(['message' => 'adm criado com sucesso!'], 201);

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
