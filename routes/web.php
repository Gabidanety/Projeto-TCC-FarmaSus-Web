<?php

use App\Http\Controllers\ClienteAdmController;
use App\Http\Controllers\TelefoneClienteAdmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteFarmaciaController; // Certifique-se de importar o ClienteController
use App\Http\Controllers\MedicamentoFarmaciaController;
use App\Http\Controllers\TelefoneClienteController;
use App\Http\Controllers\tipoMedicamentoController;
use App\Http\Controllers\TelefoneFabricanteFarmaciaController;
use App\Http\Controllers\FarmaciaUBSController;


//novos controllers
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\UBSController;
use App\Http\Controllers\TelefoneUBSController;
use App\Http\Controllers\RegiaoUBSController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\DetentorController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\MedicamentoFarmaciaUBSController;
use App\Http\Controllers\PrescricaoController;
use App\Http\Controllers\FuncionarioFarmaciaUBSController;

use App\Http\Controllers\EntradaMedicamentoController;
use App\Http\Controllers\MotivoEntradaController;
use App\Http\Controllers\EstoqueFarmaciaUBSController;
use App\Http\Controllers\SaidaMedicamentoController;
use App\Http\Controllers\HomeAdmController;
use App\Http\Controllers\HomeFarmaciaController;


use App\Models\ModelMotivoEntrada;

use Illuminate\Http\Request;



//controllers farmacia


use App\Http\Controllers\MotivoSaidaController;


use App\Http\Controllers\TipoMovimentacaoController;



// TODAS DO LADO ADM 
Route::get('/', function () {
    return view('welcome'); // Retorna a view home do Adm
})->name('homeAdm');


Route::get('/configuracoes', function () {
    return view('adm.configuracoes');
});



//UBS

// Rota para exibir o formulário de cadastro da UBS
Route::get('/formUBS', function () {
    return view('adm.Ubs.formUBS');
});


//Rotas para Rota para abir o form do telefone 
Route::get('/formTelefone', function () {
    return view('adm.Ubs.formTelefone');
});


//Rota para o form da região
Route::get('/formRegiao', function () {
    return view('adm.Ubs.formRegiao');
});

//Rota do insert do telefone
Route::post('/insertTelefone', [TelefoneUBSController::class, 'store'])->name('insertTelefone');

//Rota para o select do posto
Route::get('/selectUBS', [UBSController::class, 'index']);

//Rota do select da regiao
Route::get('/selectRegiao', [RegiaoUBSController::class, 'index']);



Route::get('/selectRegiaoForm', [UBSController::class, 'apresentarRegiao']);

Route::put('/ubs/{idUBS}', [UBSController::class, 'update'])->name('ubs.update');
Route::get('/ubs/{idUBS}/edit', [UBSController::class, 'edit'])->name('ubs.edit');

Route::post('/ubs/status/{idUBS}', [UbsController::class, 'changeStatus'])->name('changeStatus');


// Rota para salvar os dados da UBS, que deve estar no método 'store' do UBSController
Route::post('/insertUBS', [UBSController::class, 'store'])->name('insertUBS');

//Rota para o insert da região
Route::post('/insertRegiao', [RegiaoUBSController::class, 'store'])->name('insertRegiao');



//FARMACIA ADM

//rota para o formulario de inserção da Farmacia
// Route::get('/insertFarmaciaUbs', [FarmaciaUBSController::class, 'create']);

// Route::post('/insertFarmaciaUbs', [FarmaciaUBSController::class, 'store']);



// //rota para mostrar select das farmacia cadastradas
// Route::get('/insertFarmaciaUbs', [FarmaciaUBSController::class, 'create']);

// Route::get('/insertFarmaciaUbs', [FarmaciaUBSController::class, 'showForm'])->name('farmacia.showForm');

//ROTAS FARMACIA
// Rota para cadastrar farmácia via POST
// Route::post('/insertFarmaciaUbs', [FarmaciaUBSController::class, 'store']);

// Rota para exibir o formulário e as farmácias cadastradas
// Route::get('/insertFarmaciaUbs', [FarmaciaUBSController::class, 'showForm'])->name('farmacia.showForm');

// Rota para armazenar os dados da farmácia

Route::get('/farmaciaForms', function () {
    return view('adm.Ubs.insertFarmaciaUbs');
});

Route::post('/insertFarmacia', [FarmaciaUBSController::class, 'store']);

Route::get('/farmacia', [FarmaciaUBSController::class, 'showForm']);


// Rota para exibir o formulário de edição
Route::get('/farmacia/{id}/edit', [FarmaciaUBSController::class, 'edit'])->name('farmacia.edit');
Route::post('/farmacia/{id}', [FarmaciaUBSController::class, 'update'])->name('farmacia.update');

// Rota para atualizar uma farmácia
Route::post('/updateFarmaciaUbs/{id}', [FarmaciaUBSController::class, 'update'])->name('farmacia.update');

// Rota para marcar uma farmácia como excluída
Route::delete('/farmacia/{id}', [FarmaciaUBSController::class, 'changeStatus'])->name('farmacia.destroy');



//rota CLIENTE
Route::get('/criarCliente', [ClienteAdmController::class, 'create']);
Route::post('/criarCliente', 'App\Http\Controllers\ClienteAdmController@store');
Route::post('/storeTelefone', [TelefoneClienteAdmController::class, 'store']);

Route::get('/Cliente', [ClienteAdmController::class, 'index']);

// Rota para exibir o formulário de edição
Route::get('/clientes/edit/{idCliente}', [ClienteAdmController::class, 'edit'])->name('cliente.edit');

// Rota para atualizar o cliente (PUT)
Route::put('/clientes/{idCliente}', [ClienteAdmController::class, 'update'])->name('cliente.update');


Route::delete('/deletarCliente/{id}', [ClienteAdmController::class, 'destroy'])->name('deletarCliente');

// Rota para exibir a tela de clientes com filtros aplicados
Route::get('/cliente/filtros', [ClienteAdmController::class, 'filtros'])->name('cliente.filtros');
Route::get('/cliente', [ClienteAdmController::class, 'index'])->name('cliente.index');




//ROTAS DO MEDICAMENTO
Route::get('/medicamento', [MedicamentoController::class, 'medicamentos']); //para aparecer a tabela de med
Route::get('/medicamentoForm', [MedicamentoController::class, 'index'])->name('medicamentoForm'); //para aparecer o tipo med e o detentor no cadastro
Route::post('/cadastroMed', [MedicamentoController::class, 'store']); //cadastro do med

Route::get('/medicamento/edit/{idMedicamento}', [MedicamentoController::class, 'edit'])->name('medicamento.edit');
Route::put('/medicamento/{idMedicamento}', [MedicamentoController::class, 'update'])->name('medicamento.update');
Route::put('/medicamentos/desativar/{id}', [MedicamentoController::class, 'desativar'])->name('medicamento.desativar');

// Route::post('/filtro-medicamentos', [MedicamentoController::class, 'filtrar']);
Route::get('/medicamentos/search', [MedicamentoController::class, 'search'])->name('medicamentos.search');

Route::get('/medicamentosfilter', [MedicamentoController::class, 'applyFilters']);

//TIPO MEDICAMENTO 

Route::get('/TipoMedicamento', function (Request $request) {
    return view('adm.Medicamento.cadastroTipoMed', ['formData' => $request->input()]);
})->name('TipoMedicamento');

Route::post('/TipoMedicamento', [TipoMedicamentoController::class, 'store'])->name('TipoMedicamento');

//DETENTOR
Route::get('/detentor', [DetentorController::class, 'index']);
Route::get('/detentorCadastro', function () {
    return view('adm.Medicamento.cadastroDetentor');
});

Route::get('/newDetentor', function (Request $request) {
    return view('adm.Medicamento.newDetentor', ['formData' => $request->input()]);
})->name('NewDetentor');
Route::post('/newDetentor', [DetentorController::class, 'NewDetentor'])->name('newDetentor');

Route::post('/cadastroDetentor', [DetentorController::class, 'store']); //cadastro do med
Route::put('/detentor/{idDetentor}', [DetentorController::class, 'update'])->name('detentor.update');
Route::get('/detentor/edit/{idDetentor}', [DetentorController::class, 'edit'])->name('detentor.edit');
Route::put('/detentor/desativar/{idDetentor}', [DetentorController::class, 'desativar'])->name('desativarDetentor');

//MENSSAGEM

// Defina a rota para o índice de contatos
// Route::get('/contatos', [ContatoController::class, 'index'])->name('contato.index');

Route::prefix('contato')->group(function () {
    Route::get('/', [ContatoController::class, 'index'])->name('contato.index'); // Rota para listar contatos
    Route::post('/store', [ContatoController::class, 'store'])->name('contato.store'); // Rota para armazenar um novo contato
    Route::delete('/excluir/{id}', [ContatoController::class, 'excluir'])->name('contato.excluir'); // Rota para excluir um contato
});

//resposta da mensagem ao email

Route::post('/contato/{id}/resposta', [ContatoController::class, 'resposta'])->name('contato.resposta');

Route::get('/contato', [ContatoController::class, 'index'])->name('contato.index');

//Peerfil
Route::get('/perfilADM', [AdministradorController::class, 'perfil'])->name('perfil');



//Home ADM
Route::get('/', [HomeAdmController::class, 'index']);

// Route::get('/', function () {
//     return view('welcome');
// });

// 
Route::get('/formsAdm', function () {
    return view('adm.cadastroAdm');
});

// Login e cadastro adm
Route::post('/admLogin', 'App\Http\Controllers\AdministradorController@login');
Route::post('/logout','App\Http\Controllers\AdministradorController@logout');
Route::post('/cadastroAdm','App\Http\Controllers\AdministradorController@store');

//Perfil ARRUMAR
Route::get('/perfil', [AdministradorController::class, 'showProfile'])->middleware('auth');


//views login e cadastro
Route::get('/login', function () {
    return view('adm.login');
});
Route::get('/cadastroAdm', function () {
    return view('adm.cadastroAdm');
});








// TODAS DO LADO FARMACIA 

/* Páginas  farmacia*/

// Route::get('/homeFarmacia', function () {
//     return view('farmacia.homeFarmacia');
// });
Route::get('/homeFarmacia', [HomeFarmaciaController::class, 'index']);

Route::get('/loginFarmacia', function () {
    return view('farmacia.loginFarmacia');
});

Route::get('/cadastroFarmacia', function () {
    return view('farmacia.cadastroFarmacia');
});
// Login Farmacia -- não funciona ainda
Route::post('/farmaciaLogin', 'App\Http\Controllers\FarmaciaController@login');
Route::post('/farmaLogout','App\Http\Controllers\FarmaciaController@logout');

// Cadastros -- não funciona ainda
Route::post('/farmacia', 'App\Http\Controllers\FarmaciaController@store');


Route::get('/perfilFarmacia', function () {
    return view('farmacia.perfilFarmacia');
});

Route::get('/editarPerfilFarmacia', function () {
    return view('farmacia.editarPerfilFarmacia');
});


//ESTOQUE

// Route::get('/estoqueHome', function () {
//     return view('farmacia.Estoque.estoque');
// });
Route::get('/estoqueHome', [EstoqueFarmaciaUBSController::class, 'index']);
Route::post('/CadEstoque', [EntradaMedicamentoController::class, 'estoque']);
Route::post('/CadEstoqueSaida', [SaidaMedicamentoController::class, 'estoque']);

Route::put('/Estoque/{id}', [EstoqueFarmaciaUBSController::class, 'update'])->name('estoque.update');
Route::patch('/Estoque/{id}/desativar', [EstoqueFarmaciaUBSController::class, 'destroy'])->name('desativar');
Route::patch('/Estoque/{id}/ativar', [EstoqueFarmaciaUBSController::class, 'ativar'])->name('estoque.ativar');


Route::get('/SaidaMed', function () {
    return view('farmacia.Estoque.medicamentoSaida');
});





//MEDICAMENTO FARMACIA

Route::get('/MedicamentoHome', [MedicamentoFarmaciaUBSController::class, 'index']);

Route::get('/FormsMed', function () {
    return view('farmacia.Medicamento.cadMedicamento');
});
Route::get('/FormsMed', [UBSController::class, 'showFormsMed']);

Route::get('/editMedFarmacia', function () {
    return view('farmacia.Medicamento.atualizarMedicamento');
});

Route::post('/CadMedFarma', [MedicamentoFarmaciaUBSController::class, 'store']);
Route::get('/medicamentosFarma/{id}/edit', [MedicamentoFarmaciaUBSController::class, 'edit'])->name('medicamentosFarma.edit');

Route::put('/medicamentosFarma/{id}', [MedicamentoFarmaciaUBSController::class, 'update'])->name('medicamentosFarma.update');
Route::patch('/medicamentosFarmaDel/{id}', [MedicamentoFarmaciaUBSController::class, 'destroy'])->name('medicamentosFarma.desativar');
Route::patch('/medicamentosFarmaAtiv/{id}', [MedicamentoFarmaciaUBSController::class, 'ativar'])->name('medicamentosFarma.ativar');

//busca pelo codBa
Route::get('/CodMed/{codigoDeBarras}', [MedicamentoController::class, 'buscarMedicamentoPorCodigo'])->name('CodMed');
//filtre
Route::get('/filtrarMedFarma', [MedicamentoFarmaciaUBSController::class, 'filtrar'])->name('medicamentos.filtrar');



//Prescrição
Route::get('/prescricao', [PrescricaoController::class, 'index']);
Route::post('/Cadprescricao', [PrescricaoController::class, 'store']);
Route::put('/Cadprescricao/{id}', [PrescricaoController::class, 'update'])->name('prescricao.update');
Route::patch('/PrescricaoDel/{id}', [PrescricaoController::class, 'destroy'])->name('prescricao.desativar');

//filtre
Route::get('/filtrarMedFarma', [MedicamentoFarmaciaUBSController::class, 'filtrar'])->name('medicamentos.filtrar');



//ENTRADA MEDICAMENTO
Route::get('/EntradaMedicamentoHome', [EntradaMedicamentoController::class, 'index'])->name('medicamentos.index');

//rota botao novo entrada medicamento
Route::get('/entradamedinsert', [EntradaMedicamentoController::class, 'create'])->name('entradaMedInsert');
//rota botao edite entrada medicamento
Route::get('/entradaMedicamento/{id}/edit', [EntradaMedicamentoController::class, 'edit'])->name('entradaMedEdit');
Route::put('/entradaMedicamento/{id}', [EntradaMedicamentoController::class, 'update'])->name('entradaMedUpdate');

Route::delete('/entradaMedicamento/{id}', [EntradaMedicamentoController::class, 'destroy'])->name('entradaMedDelete');

// Rota para buscar medicamento pelo código de barras
//Route::get('/medicamento/buscar', [EntradaMedicamentoController::class, 'buscarPorCodigoBarras'])->name('medicamento.buscarPorCodigoBarras');

Route::get('/entradaMedicamento', [EntradaMedicamentoController::class, 'showForm'])->name('entradaMedForm');
Route::get('/buscarPorCodigoBarras', [EntradaMedicamentoController::class, 'buscarPorCodigoBarras']);
Route::post('/entradaMedicamento/store', [EntradaMedicamentoController::class, 'store'])->name('entradaMedStore');


//Route::get('/buscarMedicamentoPorCodigo', [EntradaMedicamentoController::class, 'buscarMedicamentoPorCodigo']);
// Rota para armazenar a nova entrada de medicamento
//Route::post('/entrada-medicamento', [EntradaMedicamentoController::class, 'store'])->name('entradaMedStore');
//busca o funcionario pelo nome
Route::get('/funcionario/buscar', [EntradaMedicamentoController::class, 'buscarFuncionario'])->name('buscarFuncionario');
//cria o motivo automatico
Route::post('/motivoEntrada/buscarOuCriar', [MotivoEntradaController::class, 'buscarOuCriarMotivo'])->name('motivoEntrada.buscarOuCriar');

Route::get('/motivEntrada', [MotivoEntradaController::class, 'index'])->name('motivEntrada.index');
Route::post('/motivEntrada', [MotivoEntradaController::class, 'store'])->name('motivEntrada.store');
Route::get('/motivEntradaEdit/{id}', [MotivoEntradaController::class, 'edit'])->name('motivEntrada.edit');
Route::put('/motivEntrada/{id}', [MotivoEntradaController::class, 'update'])->name('motivEntrada.update');
Route::delete('/motivEntrada/{id}', [MotivoEntradaController::class, 'destroy'])->name('motivEntrada.destroy');


//saidamed

// Exibe o formulário
Route::get('/saidaMed', [SaidaMedicamentoController::class, 'create'])->name('saidaMed.create');
Route::post('/saidaMed', [SaidaMedicamentoController::class, 'store'])->name('saidaMed.store');
Route::get('/saidaLista', [SaidaMedicamentoController::class, 'showview']);

Route::get('/saidaMedMotivo', [SaidaMedicamentoController::class, 'create'])->name('saidaMedMotivo.create');
Route::post('/saidaMedMotivo', [SaidaMedicamentoController::class, 'store'])->name('saidaMedMotivo.store');

// Route::post('/saidas', [SaidaMedicamentoController::class, 'store'])->name('saidaMedMotivo.store');

// Route::get('/saida-med-motivo/lista', [SaidaMedicamentoController::class, 'index'])->name('saidaMedMotivo.index');

Route::get('/saidaMedMotivo', [SaidaMedicamentoController::class, 'index'])->name('saidaMedMotivo.index');
Route::get('/saidaMedMotivoCadastro', [SaidaMedicamentoController::class, 'create'])->name('saidaMedMotivoCadastro');


Route::resource('saidaMedMotivo', SaidaMedicamentoController::class)->except(['show']);

Route::get('saidaMedMotivo/{id}/edit', [SaidaMedicamentoController::class, 'edit'])->name('saidaMedMotivo.edit');
Route::put('saidaMedMotivo/{id}', [SaidaMedicamentoController::class, 'update'])->name('saidaMedMotivo.update');
Route::patch('saidaMedMotivo/{id}/desativar', [SaidaMedicamentoController::class, 'excluir'])->name('saidaMedMotivo.desativar');

//pega os dados
Route::get('/getMedicamentoDetails/{id}', [SaidaMedicamentoController::class, 'getDetails']);


// Rota para armazenar uma nova saída
Route::post('/', [SaidaMedicamentoController::class, 'store'])->name('saidaMedMotivo.store'); 

// Rota para mostrar o formulário de edição de uma saída específica

// Rota para atualizar os dados de uma saída específica

// Rota para excluir uma saída (marcando como inativa)




// Route::get('/saida-medicamentos', [SaidaMedicamentoController::class, 'index'])->name('saidaMedMotivo.index');
// Esta rota exibe a lista de saídas de medicamentos e motivos

// Route::get('/saida-medicamento/create', [SaidaMedicamentoController::class, 'create'])->name('saidaMedMotivo.create');
// Esta rota exibe o formulário para cadastrar uma nova saída de medicamento

// Route::post('/saida-medicamento/store', [SaidaMedicamentoController::class, 'store'])->name('saidaMedMotivo.store');
// Esta rota trata do envio do formulário para salvar a saída de medicamento e o motivo no banco de dados


//motivSaida

// Rota para exibir o formulário de cadastro de motivo de saída
Route::get('/motivoSaida', [MotivoSaidaController::class, 'create'])->name('motivoSaida.create');

// Rota para processar o cadastro de motivo de saída
Route::post('/motivo-saida', [MotivoSaidaController::class, 'store'])->name('motivoSaida.store');



//FUNCIONARIO
Route::get('/FuncionarioHome', function () {
    return view('farmacia.Funcionario.funcionario');
});

Route::get('/formFuncionario', function () {
    return view('farmacia.Funcionario.formFuncionario');
});

Route::get('/editFuncionario', function () {
    return view('farmacia.Funcionario.editFuncionario');
});

//cadastro do funcionario
Route::post('/insertFuncionario', [FuncionarioFarmaciaUBSController::class, 'store'])->name('insertFuncionario');

//edit do funcionario
Route::get('/funcionarios/{idFuncionario}/edit', [FuncionarioFarmaciaUBSController::class, 'edit'])->name('funcionario.edit');

Route::put('/funcionarios/{idFuncionario}', [FuncionarioFarmaciaUBSController::class, 'update'])->name('funcionario.update');



Route::get('/funcionarios', [FuncionarioFarmaciaUBSController::class, 'index'])->name('funcionario.index');
Route::post('/funcionarios/{idFuncionario}/delete', [FuncionarioFarmaciaUBSController::class, 'destroy'])->name('funcionario.destroy');



//Tipo movimentação

Route::get('/TipoMovimentaçãoHome', function () {
    return view('farmacia.TipoMovimentacao.TipoMovimentacao');
});

Route::get('/formTipoMovimentacao', function () {
    return view('farmacia.TipoMovimentacao.formTipoMovimentacao');
});


//verificação da senha

Route::get('/verificacao', function () {
    return view('farmacia.verificacao.verificacao');
});


Route::post('/verificar-email', [UBSController::class, 'verificarEmail'])->name('verificar.email');



//tipo movimentação
Route::post('/insertTipoMovimentacao', [TipoMovimentacaoController::class, 'store'])->name('insertTipoMovimentacao');

Route::post('/tipomovimentacao/store', [TipoMovimentacaoController::class, 'store'])->name('tipomovimentacao.store');

Route::get('/entrada_medicamento', [TipoMovimentacaoController::class, 'index'])->name('entrada_medicamento');


Route::delete('/tipo-movimentacao/{id}', [TipoMovimentacaoController::class, 'destroy'])->name('excluirTipoMovimentacao');

// Rota para exibir o formulário de edição
Route::get('/editarTipoMovimentacao/{id}', [TipoMovimentacaoController::class, 'edit'])->name('editarTipoMovimentacao');

// Rota para atualizar os dados da movimentação
Route::put('/editarTipoMovimentacao/{id}', [TipoMovimentacaoController::class, 'atualizar'])->name('atualizarTipoMovimentacao');


// Em web.php (rotas)
Route::get('/perfilfarmacia2', [UBSController::class, 'perfil'])->name('perfilfarmacia2');


// Defina um middleware para verificar se o usuário está autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [UBSController::class, 'perfil'])->name('perfil');
});

