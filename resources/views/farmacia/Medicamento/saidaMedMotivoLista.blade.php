<!--CSS OK (ASS:Duda)-->

@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/Saida.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Saída De Medicamentos </h1>
        <p>gerencie as saídas.</p>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/saidaMed.png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>

<div class="cadastros-container">
    <h3><i class='bx bx-plus-circle' style="margin-right: 6px;"></i> Cadastrar </h3>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p>Cadastrar Prescrição</p>
            <a href="/prescricao" class="cadastrar-link">
                <i class="fas fa-file-medical"></i> 
            </a>
        </div>
    </div>
    <br>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p>Cadastrar Saída</p>
            <a href="/saidaMedMotivoCadastro" class="cadastrar-link">
                <i class="fas fa-sign-out-alt"></i> 
            </a>
        </div>
    </div>
</div>

<main>
    <table id="funcionarioTable">
        <thead>
            <tr>
                <th colspan="9">
                    <div class="filter-search-container">
                        <p class="p">Filtros</p>
                        <div class="filter-buttons">
                            <button class="filter-btn" onclick="filterByStatus('A')">Ativos</button>
                            <button class="filter-btn" onclick="filterByStatus('I')">Inativos</button>
                            <button class="filter-btn" onclick="resetFilter()">Todos</button>
                        </div>
                        <div class="search-bar">
                            <input type="text" id="searchInput" placeholder="Digite o medicamento ou motivo de saída" onkeyup="filterTable()">
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>Medicamento</th>
                <th>Data de Saída</th>
                <th>Quantidade</th>
                <th>Motivo de Saída</th>
                <th>Lote</th>
                <th>Validade</th>
                <th>Funcionário</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saidas as $saida)
                <tr data-status="{{ $saida->situacao }}">
                    <td>{{ $saida->medicamento->nomeMedicamento ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($saida->dataSaida)->format('d/m/Y') }}</td>
                    <td>{{ $saida->quantidade }}</td>
                    <td>{{ $saida->motivoSaida }}</td>
                    <td>{{ $saida->lote }}</td>
                    <td>{{ \Carbon\Carbon::parse($saida->validade)->format('d/m/Y') }}</td>
                    <td>{{ $saida->funcionario->nomeFuncionario ?? 'N/A' }}</td>
                    <td>{{ $saida->situacao == 'A' || $saida->situacao == '1' ? 'Ativo' : 'Inativo' }}</td>
                    <td class="text-center">
                        <a href="{{ route('saidaMedMotivo.edit', $saida->idSaidaMedicamento) }}" class="btn btn-primary btn-acao">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <form id="delete-form-{{ $saida->idSaidaMedicamento }}" action="{{ route('saidaMedMotivo.desativar', $saida->idSaidaMedicamento) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-danger btn-acao" onclick="return confirm('Tem certeza que deseja excluir ?');">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
