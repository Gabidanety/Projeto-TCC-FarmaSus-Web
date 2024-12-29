<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Controllers\Controller;

use App\Models\UsuarioModel;

use Illuminate\Support\Facades\DB;


use Illuminate\Routing\Controller;



class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //SELECT
    public function index()
    {
        $usuario = UsuarioModel::all(); // Busca todos os clientes
        return response()->json($usuario); // Retorna os clientes em formato JSON

        return view('criarUSuario', ['usuario' => $usuario]);
    }

    

    // public function indexLogin() {
    //     $clientes = UsuarioModel::all();
    //     return response()->json($clientes); // Retorna dados como JSON
    // }

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

     //INSERT WEB
    public function store(Request $request)
    {
        
        $usuario = new UsuarioModel();
        
        $usuario->nomeUsuario = $request->nome;
        $usuario->fotoUsuario = $request->foto;
        $usuario->cnsUsuario = $request->cns;
        $usuario->situacaoUsuario = $request->situacao;
        $usuario->senhaUsuario = $request->senha;
        $usuario->dataCadastroUsuario = $request->dataCadastro;

       
        $usuario->save(); 
       
        //mudar para ir na view
        return response()->json(['message' => 'Usuario criado com sucesso!'], 201);
    }

    //INSERT API
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

     //UPDATE API
    public function updateapi(Request $request, $id)
{
    UsuarioModel::where('idUsuario', $id)->update([
        'nomeUsuario' => $request->user,
        'fotoUsuario' => $request->foto,
        'cnsUsuario' => $request->cns,
        'situacaoUsuario' => $request->situacao,
        'senhaUsuario' => $request->senha,
        'dataCadastroUsuario' => $request->dataCadastro,
        
    ]);

    return response()-> json([
        'mensage' => 'Sucesso',
        'code' =>200]
     );
    
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