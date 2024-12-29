<!--CSS OK, ASS:DUDA-->
<!--PÁGINA OFICIAL DO ESTOQUE-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/Estoque.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Estoque </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/estoque (1).png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>

<div class="cadastros-container">
    <h3><i class='bx bx-plus-circle' style="margin-right: 6px;"></i> Acessar </h3>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p>Entrada Medicamento</p>
            <a href="/EntradaMedicamentoHome" class="cadastrar-link">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
        </div>
        <div class="cadastro-item">
            <p>Saída Medicamento</p>
            <a href="/saidaMed" class="cadastrar-link">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
        <div class="cadastro-item">
            <p>Medicamentos Registrados</p>
            <a href="/MedicamentoHome" class="cadastrar-link">
                <i class="fas fa-clipboard-list"></i>
            </a>
        </div>
    </div>
</div>

<main>
    <!-- Tabela de Medicamentos Registrados -->
    <div class="col-lg-12 mb-4">
        <div class="card-container" style="background-color: transparent;">
            <div class="card-header">
                <h5 class="mb-0" style="font-weight: bold;"> Medicamentos Registrados </h5>
                <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar por Nome, Genérico, Código ou Lote" style="margin-top: 10px;">

            </div>
            <div class="table-responsiva">
                <table class="table table-bordered table-striped" id="medicamentoTable">
                    <thead class="table-cor">
                        <tr>
                            <th>Nome</th>
                            <th>Nome Genérico</th>
                            <th>Código de Barras</th>
                            <th>Lote</th>
                            <th>Validade</th>
                            <th>Situação</th>
                            <th>Movimentação</th>
                            <th>inf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicamento as $med)
                        @if ($med->situacaoMedicamento == 'A' || $med->situacaoMedicamento == '1')

                        <tr>
                            <td>{{ $med->nomeMedicamento }}</td>
                            <td>{{ $med->nomeGenericoMedicamento }}</td>
                            <td>{{ $med->codigoDeBarrasMedicamento }}</td>
                            <td>{{ $med->loteMedicamento }}</td>
                            <td>{{ \Carbon\Carbon::parse($med->validadeMedicamento)->format('d/m/Y') }}</td>
                            <td>{{ $med->situacaoMedicamento == 'A'|| $med->situacaoMedicamento == '1' ? 'Ativo' : 'Inativo' }}</td>
                            <td>
                                <!-- Botão Registrar Entrada -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#entradaModal{{ $med->idMedicamento }}">
                                    ↑
                                </button>
                                <!-- Botão Registrar Saída -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#saidaModal{{ $med->idMedicamento }}">
                                    ↓
                                </button>
                            </td>
                            <td>
                                <!-- Botão dos detalhes-->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalDetalhes{{ $med->idMedicamento }}">
                                    i
                                </button>
                            </td>
                        </tr>

                        <!-- Modal para os detalhes do medicamento -->
                        <div class="modal fade" id="modalDetalhes{{ $med->idMedicamento }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header  text-black">
                                        <h5 class="modal-title" id="exampleModalLabel">Detalhes do Medicamento</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Código de Barras:</strong> {{ $med->codigoDeBarrasMedicamento }}</p>
                                        <p><strong>Nome:</strong> {{ $med->nomeMedicamento }}</p>
                                        <p><strong>Nome Genérico:</strong> {{ $med->nomeGenericoMedicamento }}</p>
                                        <p><strong>Lote:</strong> {{ $med->loteMedicamento }}</p>
                                        <p><strong>Dosagem:</strong> {{ $med->dosagemMedicamento }}</p>
                                        <p><strong>Forma Farmacêutica:</strong> {{ $med->formaFarmaceuticaMedicamento }}</p>
                                        <p><strong>Composição:</strong> {{ $med->composicaoMedicamento }}</p>
                                        <p><strong>Validade:</strong> {{ \Carbon\Carbon::parse($med->validadeMedicamento)->format('d/m/Y') }}</p>
                                        <p><strong>Situação:</strong> {{ $med->situacaoMedicamento == 'A' || $med->situacaoMedicamento == '1' ? 'Ativo' : 'Inativo' }}</p>
                                        <p><strong>Data de Cadastro:</strong> {{ \Carbon\Carbon::parse($med->dataCadastroMedicamento)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($funcionario as $f)

                        <div class="row">
    <!-- Modal para Registrar Entrada -->
    <div class="col-md-6">
        <div class="modal fade" id="entradaModal{{ $med->idMedicamento }}" tabindex="-1" aria-labelledby="entradaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="entradaModalLabel">Registrar Entrada de Medicamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/CadEstoque" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Primeira Coluna -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="medicamento">Medicamento:</label>
                                        <select name="idMedicamento" class="form-control" id="medicamento" required>
                                            <option value="{{ $med->idMedicamento }}" data-lote="{{ $med->loteMedicamento }}" data-validade="{{ $med->validadeMedicamento }}">
                                                {{ $med->nomeMedicamento }}
                                            </option>
                                        </select>
                                        <small id="medicamentoError" style="color: red; display: none;">Medicamento não cadastrado.</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="dataEntrada">Data de Entrada:</label>
                                        <input type="date" name="dataEntrada" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="quantidade">Quantidade:</label>
                                        <input type="number" name="quantidade" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="funcionario">Funcionário Responsável:</label>
                                        <select name="idFuncionario" class="form-control" id="funcionario" required>
                                            <option value="">Selecione um funcionário</option>
                                            <option value="{{ $f->idFuncionario }}">{{ $f->nomeFuncionario }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Segunda Coluna -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lote">Lote:</label>
                                        <input type="text" name="lote" class="form-control" required id="lote">
                                    </div>

                                    <div class="form-group">
                                        <label for="validade">Validade:</label>
                                        <input type="date" name="validade" class="form-control" required id="validade">
                                    </div>

                                    <div class="form-group">
                                        <label for="motivoEntrada">Motivo da Entrada:</label>
                                        <input type="text" name="motivoEntrada" class="form-control" id="motivoEntrada" required placeholder="Digite o motivo da entrada">
                                        <input type="hidden" name="idMotivoEntrada" id="idMotivoEntrada">
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Registrar Saída -->
    <div class="col-md-6">
        <div class="modal fade" id="saidaModal{{ $med->idMedicamento }}" tabindex="-1" aria-labelledby="saidaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-black">
                        <h5 class="modal-title" id="saidaModalLabel">Registrar Saída de Medicamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/CadEstoqueSaida" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Primeira Coluna -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idMedicamento">Medicamento:</label>
                                        <select id="idMedicamento" name="idMedicamento" required>
                                            <option value="">Selecione o Medicamento</option>
                                            <option value="{{ $med->idMedicamento }}" data-lote="{{ $med->lote }}" data-validade="{{ $med->validade }}">
                                                {{ $med->nomeMedicamento }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="dataSaida">Data de Saída:</label>
                                        <input type="date" id="dataSaida" name="dataSaida" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="quantidade">Quantidade:</label>
                                        <input type="number" id="quantidade" name="quantidade" min="1" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="idFuncionario">Funcionário:</label>
                                        <select id="idFuncionario" name="idFuncionario" required>
                                            <option value="">Selecione o Funcionário</option>
                                            <option value="{{ $f->idFuncionario }}">{{ $f->nomeFuncionario }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Segunda Coluna -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="motivoSaida">Motivo de Saída:</label>
                                        <input type="text" id="motivoSaida" name="motivoSaida" placeholder="Descreva o motivo" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="lote">Lote:</label>
                                        <input type="text" id="lote" name="lote" maxlength="90" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="validade">Data de Validade:</label>
                                        <input type="date" id="validade" name="validade" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn-submit" style="font-size: 12px; font-weight:bold;">Cadastrar Saída e Motivo</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                        @endforeach
                        @endif
                        @endforeach
                        </div>
                    </div>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tabela-e-card">
        <div class="row-2">
            <div class="col-6">
                <div class="tabela-responsiva">
                    <div class="cabecalho">
                        <h5 style="font-weight: bold; font-size: 30px;">Relátório do Estoque</h5>
                        <input type="text" id="searchInputEstoque" class="form-control" placeholder="Pesquisar por Medicamento e Funcionário">
                    </div>
                    <table class="tabela-borda" id="estoqueTable">
                        <thead class="tabela-comeco">
                            <tr>
                                <th>Medicamento</th>
                                <th>Funcionário</th>
                                <th>Movimentação</th>
                                <th>Quantidade</th>
                                <th>Validade</th>
                                <th>Situação</th>
                                <th>Detalhes</th>
                            </tr>
                        </thead>
                        @foreach ($estoque as $e)
                        <tbody>
                            <tr>
                                <td>{{ $e->medicamento->nomeMedicamento }}</td>
                                <td>{{ $e->funcionario->nomeFuncionario }}</td>
                                <td>{{ $e->tipoMovimentacao->movimentacao }}</td>
                                <td>{{ $e->quantEstoque }}</td>
                                <td>{{ \Carbon\Carbon::parse($e->dataMovimentacao)->format('d/m/Y') }}</td>
                                <td>{{ $e->situacaoEstoque == 'A' ||  $e->situacaoEstoque == '1' ? 'Ativo' : 'Inativo'  }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEstoque{{ $e->idEstoque }}">i</button>
                                    <!-- Modal para os detalhes do medicamento -->
                                    <div class="modal fade" id="modalEstoque{{ $e->idEstoque }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header text-white">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="font-weight:bold;">Detalhes do Estoque</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Medicamento:</strong> {{ $e->medicamento->nomeMedicamento }}</p>
                                                    <p><strong>Quantidade:</strong> {{ $e->quantEstoque }}</p>
                                                    <p><strong>Nome Funcionário:</strong> {{ $e->funcionario->nomeFuncionario }}</p>
                                                    <p><strong>Movimentação:</strong> {{ $e->tipoMovimentacao->movimentacao }}</p>
                                                    <p><strong>Data do Cadastro:</strong> {{ \Carbon\Carbon::parse($e->dataMovimentacao)->format('d/m/Y') }}</p>
                                                    <p><strong>Situação:</strong> {{ $e->situacaoEstoque == 'A' || $e->situacaoEstoque == '1' ? 'Ativo' : 'Inativo' }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary Bsalvar" data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-3">
                <div class="card-status">
                    <div class="status-cabecalho">
                        <h3>Status do Estoque</h3>
                    </div>
                    <div class="corpo-status" style="max-height: 250px; overflow-y: scroll;">
                        <!-- Notificações de Movimentações -->
                            @if ($movimentacoes->isNotEmpty())
                                @foreach ($movimentacoes as $movimentacao)
                                    <p style="color: {{ $movimentacao->tipo == 'entrada' ? 'green' : 'red' }};">
                                        @if ($movimentacao->tipo == 'entrada')
                                        Entrada - {{ $movimentacao->nomeMedicamento }} -
                                        {{ $movimentacao->quantidade }} Unidades -
                                        {{ \Carbon\Carbon::parse($movimentacao->dataMovimentacao)->format('d/m/Y H:i') }}
                                        @else
                                        Saída - {{ $movimentacao->nomeMedicamento }} -
                                        {{ $movimentacao->quantidade }} Unidades -
                                        {{ \Carbon\Carbon::parse($movimentacao->dataMovimentacao)->format('d/m/Y H:i') }}
                                        @endif
                                    </p>
                                @endforeach
                            @else
                                <p>Nenhuma movimentação registrada.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    $(document).ready(function() {

        // Atualiza os campos de lote e validade quando o medicamento é selecionado
        document.getElementById('medicamento').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            // Obtendo os atributos de lote e validade
            const lote = selectedOption.getAttribute('data-lote');
            const validade = selectedOption.getAttribute('data-validade');

            // Preenchendo os campos do formulário
            document.getElementById('lote').value = lote || '';
            document.getElementById('validade').value = validade || '';
        });
        // Motivo de entrada cadastra automático
        document.getElementById('motivoEntrada').addEventListener('blur', function() {
            const motivoEntrada = this.value;

            if (motivoEntrada) {
                fetch('/motivoEntrada/buscarOuCriar', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            motivoEntrada: motivoEntrada
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.idMotivoEntrada) {
                            document.getElementById('idMotivoEntrada').value = data.idMotivoEntrada;
                        } else {
                            console.error('Erro ao criar motivo de entrada:', data);
                        }
                    })
                    .catch(error => console.error('Erro ao buscar/criar motivo de entrada:', error));
            }
        });

        // Pesquisa para a tabela de estoque
        $('#searchInputEstoque').on('keyup', function() {
            var value = $(this).val().toLowerCase(); // Obter valor e converter para minúsculas
            $('#estoqueTable tbody tr').filter(function() {
                // Mostrar ou ocultar a linha com base no valor pesquisado na tabela de estoque
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Pesquisa para a tabela de outra funcionalidade (ajuste o seletor da tabela de acordo com sua necessidade)
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase(); // Obter valor e converter para minúsculas
            $('#medicamentoTable tbody tr').filter(function() {
                // Mostrar ou ocultar a linha com base no valor pesquisado na outra tabela
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Ação de edição do modal de estoque
        $('.edit-btn').click(function() {
            const idEstoque = $(this).data('id');
            const idMedicamento = $(this).data('id-medicamento');
            const idFuncionario = $(this).data('id-funcionario');
            const idTipoMovimentacao = $(this).data('id-tipo-movimentacao');
            const quantEstoque = $(this).data('quant-estoque');
            const dataMovimentacao = $(this).data('data-movimentacao');

            // Preenche os campos do formulário com os dados do estoque
            $('#idMedicamento').val(idMedicamento);
            $('#idFuncionario').val(idFuncionario);
            $('#idTipoMovimentacao').val(idTipoMovimentacao);
            $('#quantEstoque').val(quantEstoque);
            $('#dataMovimentacao').val(dataMovimentacao);
            $('#estoqueId').val(idEstoque); // Armazena o ID do estoque

            // Atualiza a ação do formulário para edição
            $('#estoqueForm').attr('action', `/estoque/${idEstoque}`);

            // Esconde o botão de submissão e mostra o grupo de botões de edição
            $('#submitBtn').hide();
            $('#editBtnGroup').show();
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


@include('includes.footer')
