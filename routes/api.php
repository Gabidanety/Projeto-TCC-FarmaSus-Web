<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;



use App\Http\Controllers\UBSController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MedicamentoFarmaciaUBSController;

use App\Http\Controllers\TelefoneUBSController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteAdmController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/






/*Update */

// Route::put('/cliente/{id}', 'App\Http\Controllers\ClienteController@update');
// Route::put('/cliente/{id}', [ClienteController::class, 'update']);


//NOVAS


//INSERT

Route::post('/insertUBS', 'App\Http\Controllers\UBSController@store');

Route::post('/insertTelefone', 'App\Http\Controllers\TelefoneUBSController@store');


//UBS
Route::get('/selectUbsApi', 'App\Http\Controllers\UBSController@indexApi');
// Route::get('/selectMedApi', 'App\Http\Controllers\MedicamentoController@indexApi'); //adm geral
Route::get('/selectMedApi', 'App\Http\Controllers\MedicamentoFarmaciaUBSController@indexApi'); //med farmacia

Route::get('/medicamentos', 'App\Http\Controllers\MedicamentoController@indexApi'); //med farmacia

Route::get('/selectUser', 'App\Http\Controllers\UsuarioController@indexApi'); //med farmacia

Route::get('/selectCliente', 'App\Http\Controllers\ClienteAdmController@indexApi'); //med farmacia

Route::get('/medicamentos/ubs/nome/{nomeUBS}', [MedicamentoFarmaciaUBSController::class, 'getMedicamentosByNomeUBS']);

Route::get('/selectMedApi/{id}', [MedicamentoFarmaciaUBSController::class, 'show']);

Route::get('/usuario/cns/{cns}', [UsuarioController::class, 'getUserByCNS']);

Route::get('/ubs/medicamento/nome/{nomeMedicamento}', [MedicamentoController::class, 'getUBSByMedicamentoNome']);


Route::get('/medicamentos/nome/{medicamentoNome}', [MedicamentoController::class, 'showByNome']);
























































Route::put('/telefone/{id}', 'App\Http\Controllers\TelefoneController@updateapi');
Route::put('/tipoFarmacia/{id}', 'App\Http\Controllers\tipoFarmaciaController@updateapi');
Route::put('/regiao/{id}', 'App\Http\Controllers\regiaoControllers@updateapi');
Route::put('/medicamentoSalvo/{id}', 'App\Http\Controllers\medicamentoSalvoController@updateapi');
Route::put('/comentarios/{id}', 'App\Http\Controllers\comentariosController@updateapi');
Route::put('/medicamento/{id}', 'App\Http\Controllers\medicamentoController@updateapi');
Route::put('/estoque/{id}', 'App\Http\Controllers\estoqueController@updateapi');
//Route::put('/cliente/{id}', 'App\Http\Controllers\ClienteController@updateapi');
Route::put('/favoritos/{id}', 'App\Http\Controllers\favoritosController@updateapi');
Route::put('/notificacaoComentario/{id}', 'App\Http\Controllers\notificacaoComentarioController@updateapi');
Route::put('/notificacaoEstoque/{id}', 'App\Http\Controllers\notificacaoEstoqueController@updateapi');
Route::put('/farmacia/{id}', 'App\Http\Controllers\farmaciaController@updateapi');

//Route::get('/cliente','App\Http\Controllers\ClienteController@index');




Route::put('/medicamentoSalvo/{id}', 'App\Http\Controllers\medicamentoSalvoController@updateapi');

Route::put('/contato/{id}', 'App\Http\Controllers\contatoController@updateapi');


//Route::get('/cliente', [ClienteController::class, 'indexLogin']);

//com erro
//Route::post('/cliente', 'App\Http\Controllers\ClienteController@storeapi');

//rodando
Route::post('/telefone', 'App\Http\Controllers\TelefoneController@storeapi');
Route::post('/farmacia', 'App\Http\Controllers\farmaciaController@storeapi');
Route::post('/TipoFarmacia', 'App\Http\Controllers\TipoFarmaciaController@storeapi');
Route::post('/regiao', 'App\Http\Controllers\regiaoControllers@storeapi');
Route::post('/medicamento', 'App\Http\Controllers\medicamentoController@storeapi');
Route::post('/tipoMedicamento', 'App\Http\Controllers\tipoMedicamentoController@storeapi');
Route::post('/comentario', 'App\Http\Controllers\comentariosController@storeapi');
Route::post('/contato', 'App\Http\Controllers\contatoController@storeapi');
Route::post('/estoque', 'App\Http\Controllers\estoqueController@storeapi');
Route::post('/favoritos', 'App\Http\Controllers\favoritosController@storeapi');
Route::post('/medicamentoSalvo', 'App\Http\Controllers\medicamentoSalvoController@storeapi');
Route::post('/noti', 'App\Http\Controllers\notificacaoComentarioController@storeapi');
Route::post('/notificacaoEstoque', 'App\Http\Controllers\notificacaoEstoqueController@storeapi');
Route::post('/Adm', 'App\Http\Controllers\AdministradorController@storeapi');

//APP
Route::post('/UsuarioInserirAPP', 'App\Http\Controllers\UsuarioController@storeapi');




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});