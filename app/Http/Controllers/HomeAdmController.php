<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicamentoModel;
use App\Models\UBSModel;
use App\Models\UsuarioModel;
use App\Models\ClienteAdmModel;

use App\Models\TipoMedicamentoModel;
use Illuminate\Support\Facades\DB;

class HomeAdmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
  
    $atividades = collect();

    // Últimos cadastros de usuários
    $usuarios = DB::table('tbUsuario')->select('nomeUsuario', 'dataCadastroUsuario as data')
        ->orderBy('dataCadastroUsuario', 'desc')
        ->limit(2)
        ->get()
        ->map(function ($usuario) {
            return "Novo usuário cadastrado: {$usuario->nomeUsuario} - " . now()->diffForHumans($usuario->data);
        });

    // Últimos medicamentos cadastrados
    $medicamentos = DB::table('tbMedicamento')->select('nomeMedicamento', 'dataCadastroMedicamento as data')
        ->orderBy('dataCadastroMedicamento', 'desc')
        ->limit(2)
        ->get()
        ->map(function ($medicamento) {
            return "Novo medicamento cadastrado: {$medicamento->nomeMedicamento} - " . now()->diffForHumans($medicamento->data);
        });

    // Últimas UBS cadastradas
    $ubs = DB::table('tbUBS')->select('nomeUBS', 'dataCadastroUBS as data')
        ->orderBy('dataCadastroUBS', 'desc')
        ->limit(2)
        ->get()
        ->map(function ($ubs) {
            return "Nova UBS cadastrada: {$ubs->nomeUBS} - " . now()->diffForHumans($ubs->data);
        });

    $atividades = $atividades->merge($usuarios)->merge($medicamentos)->merge($ubs);

    $pacientesGrafico = DB::table('tbCliente')
    ->selectRaw('MONTH(dataCadastroCliente) as mes, COUNT(*) as total')
    ->groupBy('mes')
    ->orderBy('mes')
    ->get();

// UBS cadastradas por mês
$ubsGrafico = DB::table('tbUBS')
    ->selectRaw('MONTH(dataCadastroUBS) as mes, COUNT(*) as total')
    ->groupBy('mes')
    ->orderBy('mes')
    ->get();


    return view('welcome', ['atividades' => $atividades,'pacientesGrafico'=>$pacientesGrafico,'ubsGrafico'=>$ubsGrafico]);


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
