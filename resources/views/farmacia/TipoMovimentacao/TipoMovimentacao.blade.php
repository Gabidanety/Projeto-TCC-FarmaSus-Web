<!--CSS OK, COM BACK-END (ASS:DUDA)-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css/Farmacia-CSS/TipoMovimentacao.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;">Tipos de Movimentação</h1>
        <p>gerencie os tipos de movimentação</p>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/saidaEEntrada.png') }}" alt="Cadastro de Medicamentos" class="img-fluid" />
    </div>
</div>

<div class="cadastros-container">
    <h3><i class='bx bx-plus-circle' style="margin-right: 6px; color:#000;"></i> Cadastrar </h3>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p>Cadastrar Tipo de Movimentação</p>
            <a href="/formTipoMovimentacao" class="cadastrar-link">
                <i class="fas fa-inbox"></i> 
            </a>
        </div>
    </div>
</div>

<main>
<table id="tabelaMovimentacoes" class="table table-bordered table-striped table-hover">
    <div class="filter-search-container">
        <div class="filter-buttons">
            <p>Filtros</p>
            <button class="filter-btn" onclick="filterByStatus('1')">Ativos</button>
            <button class="filter-btn" onclick="filterByStatus('0')">Inativos</button>
            <button class="filter-btn" onclick="resetFilter()">Todos</button>
        </div>
    </div>
    
    <thead>
        <tr>
            <th>ID</th>
            <th>Movimentação</th>
            <th>Situação</th>
            <th>Data de Cadastro</th>
            <th>ID Prescrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($movimentacoes as $movimentacao)
            <tr data-status="{{ $movimentacao->situacaoTipoMovimentacao }}">
                <td>{{ $movimentacao->idTipoMovimentacao }}</td>
                <td>{{ $movimentacao->movimentacao }}</td>
                <td>
                    <span class="badge {{ $movimentacao->situacaoTipoMovimentacao == 1 ? 'bg-success' : 'bg-warning' }}">
                        {{ $movimentacao->situacaoTipoMovimentacao == 1 ? 'Ativo' : 'Inativo' }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($movimentacao->dataCadastroTipoMovimentacao)->format('d/m/Y') }}</td>
                <td>{{ $movimentacao->idPrescricao }}</td>
                <td class="text-center">
                    <a href="{{ route('editarTipoMovimentacao', $movimentacao->idTipoMovimentacao) }}" class="btn btn-primary btn-acao">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('excluirTipoMovimentacao', $movimentacao->idTipoMovimentacao) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-acao" onclick="return confirm('Tem certeza que deseja excluir este item?')">
                            <i class="fas fa-trash-alt"></i> Excluir
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</main>

<script>
    function filterTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#tabelaMovimentacoes tbody tr');

        rows.forEach(row => {
            const movimentacao = row.cells[1].textContent.toLowerCase();
            row.style.display = movimentacao.includes(input) ? '' : 'none';
        });
    }

    function filterByStatus(status) {
        const rows = document.querySelectorAll('#tabelaMovimentacoes tbody tr');

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            row.style.display = (status === '' || rowStatus === status) ? '' : 'none';
        });

        document.getElementById('searchInput').value = '';
    }

    function resetFilter() {
        const rows = document.querySelectorAll('#tabelaMovimentacoes tbody tr');

        rows.forEach(row => {
            row.style.display = '';
        });

        document.getElementById('searchInput').value = '';
    }
</script>

@include('includes.footer')
