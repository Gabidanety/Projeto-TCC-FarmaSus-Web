<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FarmaciaModel;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
class FarmaciaController extends Controller
{

    //LOGIN
    public function logout()
    {
        Auth::logout(); // Desloga o usuário
    
        return view('farmacia.loginFarmacia'); // Redireciona para a página de login
    }
    
    public function login(Request $request)
    {
            // Validar o input
            $request->validate([
                'cnpj' => 'required|string',
                'senha' => 'required|',
            ]);
    
            // Encontrar o usuário pelo email no banco correto
            $user = FarmaciaModel::where('cnpjFarmacia', $request->cnpj)->first();
    
            // Verificar se a senha está correta
            if ($user && Hash::check($request->senha, $user->senhaFarmacia)) {
                
                Auth::login($user);
                
                session()->flash('message', 'Bem-vindo Farmaceutico, ' . $user->nomeFarmacia . '!');

                return view('farmacia.homeFarmacia'); // Redireciona para a rota 'home do adm'

            } else {
                return response()->json(['error' => 'Credenciais inválidas.'], 401);
            }
     }
    

//UPDATE
    public function updateapi(Request $request, $id)
    {
        FarmaciaModel::where('idFarmacia', $id)->update([
            'cnpjFarmarcia' => $request->cnpjFarmarcia,	
            'geolocalizacaoFarmacia' => $request->geoFarmacia,	
            'cepFarmarcia' => $request->cepFarmacia,	
            'logradouroFarmacia' => $request->logradouroFarmacia,	
            'bairroFarmacia' => $request->bairroFarmacia,	
            'numeroFarmacia' => $request->numeroFarmacia,	
            'complementoFarmacia' => $request->complementoFarmacia,	
            'estadoFarmacia' => $request->estadoFarmacia,	
            'ufFarmacia' => $request->ufFarmacia,	
            'cidadeFarmacia' => $request->cidadeFarmacia,	
            'emailFarmacia' => $request->emailFarmacia,	
            'idRegiao' => $request->idRegiao,
            'idTipofarmacia' => $request->idTipofarmacia,	
	


        ]);
        return response()-> json([
            'mensage' => 'Sucesso',
            'code' =>200]
         );
        
}

//INSERIR
public function storeapi(Request $request)
    {
        $farmacia = new FarmaciaModel();

        $foto = 'foto';
        $log = 'log';
        $lat = 'lag';

        $farmacia->cnpjFarmacia = $request->cnpj;
        $farmacia->cepFarmacia = $request->cep;
        $farmacia->logradouroFarmacia = $request->logradouro;
        $farmacia->bairroFarmacia = $request->bairro;
        $farmacia->numeroFarmacia = $request->numero;
        $farmacia->complementofarmacia = $request->complemento;
        $farmacia->estadoFarmacia = $request->estado;
        $farmacia->ufFarmacia = $request->uf;
        $farmacia->cidadeFarmacia = $request->cidade;
        $farmacia->emailFarmacia = $request->email;
        $farmacia->idRegiao = $request-> regiao;
        $farmacia->idTipofarmacia = $request->tipoFarmacia;
        $farmacia->senhafarmacia = $request->senha;
        $farmacia->nomeFarmacia = $request->nome;
        //cadastrar depois
        $farmacia->latitudeFarmacia = $request->$lat;
        $farmacia->longetudeFarmacia= $request->$log;
        $farmacia->fotoFarmacia	 = $request->$foto;

       
        $farmacia->save();  
        return response()->json(['message' => 'Farmacia criado com sucesso!'], 201);


    }

    public function store(Request $request)
    {
        $farmacia = new FarmaciaModel();

        $farmacia->cnpjFarmacia = $request->cnpj;
        $farmacia->cepFarmacia = $request->cep;
        $farmacia->logradouroFarmacia = $request->logradouro;
        $farmacia->bairroFarmacia = $request->bairro;
        $farmacia->numeroFarmacia = $request->numero;
        $farmacia->complementoFarmacia = $request->complemento;
        $farmacia->estadoFarmacia = $request->estado;
        $farmacia->ufFarmacia = $request->uf;
        $farmacia->cidadeFarmacia = $request->cidade;
        $farmacia->emailFarmacia = $request->email;
        $farmacia->idRegiao = $request-> regiao;
        $farmacia->idTipoFarmacia = $request->tipoFarmacia;
        $farmacia->senhaFarmacia = Hash::make($request->senha); 
        $farmacia->nomeFarmacia = $request->nome;
        $farmacia->situacaoFarmacia	 = $request->situacao;
        $farmacia->dataCadastroFarmacia	  = now(); 

        //cadastrar depois
        $farmacia->latitudeFarmacia = $request->lat;
        $farmacia->longitudeFarmacia= $request->log;
        $farmacia->fotoFarmacia	 = $request->foto;

        $farmacia->save();  
        
        return redirect('/homeFarmacia');

    }
    // public function storeInsertADM(Request $request)
    // {
    //     $farmacia = new farmaciaModel();

    //     $farmacia->cnpjFarmacia = $request->cnpj;
    //     $farmacia->geolocalizacaoFarmacia = $request->geo;
    //     $farmacia->cepFarmacia = $request->cep;
    //     $farmacia->logradouroFarmacia = $request->logradouro;
    //     $farmacia->bairroFarmacia = $request->bairro;
    //     $farmacia->numeroFarmacia = $request->numero;
    //     $farmacia->complementofarmacia = $request->complemento;
    //     $farmacia->estadoFarmacia = $request->estado;
    //     $farmacia->ufFarmacia = $request->uf;
    //     $farmacia->cidadeFarmacia = $request->cidade;
    //     $farmacia->emailFarmacia = $request->email;
    //     $farmacia->idRegiao = $request-> regiao;
    //     $farmacia->idTipofarmacia = $request->tipoFarmacia;
    //     $farmacia->senhafarmacia = $request->senha;

    //     $farmacia->nomeFarmacia = $request->nome;

    //     $farmacia->save();  
        
    //     return redirect('/consultar');


    // }
}

