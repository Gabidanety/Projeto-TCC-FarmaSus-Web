<!-- CSS OK, COM BACK-END (ASS:DUDA)-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css/Farmacia-CSS/Funcionario.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Funcionário </h1>
        <p>gerencie os funcionários.</p>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/funcionario.png') }}" alt="Cadastro de Medicamentos" class="img-fluid" />
    </div>
</div>

<div class="cadastros-container">
    <h3><i class='bx bx-plus-circle' style="margin-right: 6px;"></i>Cadastrar </h3>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p>Cadastro do Funcionário</p>
            <a href="/formFuncionario" class="cadastrar-link">
                <i class="fas fa-inbox"></i> 
            </a>
        </div>
    </div>
</div>

<main>
    <table id="funcionarioTable">
        <thead>
            <tr>
                <th colspan="4">
                    <div class="filter-search-container">
                    <p class="p">Filtros</p>
                        <div class="filter-buttons">
                            <button class="filter-btn" onclick="filterByStatus('A')">Ativos</button>
                            <button class="filter-btn" onclick="filterByStatus('I')">Inativos</button>
                            <button class="filter-btn" onclick="resetFilter()">Todos</button>
                        </div>
                        <div class="search-bar">
                            <input type="text" id="searchInput" placeholder="Digite o nome ou CPF do funcionário" onkeyup="filterTable()">
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Cargo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($funcionarios as $funcionario)
                <tr data-status="{{ $funcionario->situacaoFuncionario }}">
                    <td>{{ $funcionario->nomeFuncionario }}</td>
                    <td>{{ $funcionario->cpfFuncionario }}</td>
                    <td>{{ $funcionario->cargoFuncionario }}</td>
                    <td class="text-center">
                        <a href="{{ route('funcionario.edit', $funcionario->idFuncionario) }}" class="btn btn-primary btn-acao">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <form action="{{ route('funcionario.destroy', $funcionario->idFuncionario) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-acao" onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
<br>
<script>
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('funcionarioTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) { // Começa em 1 para pular o cabeçalho
            const tdNome = tr[i].getElementsByTagName('td')[0];
            const tdCpf = tr[i].getElementsByTagName('td')[1];
            if (tdNome || tdCpf) {
                const txtValueNome = tdNome.textContent || tdNome.innerText;
                const txtValueCpf = tdCpf.textContent || tdCpf.innerText;
                if (txtValueNome.toLowerCase().indexOf(filter) > -1 || txtValueCpf.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function filterByStatus(status) {
        const table = document.getElementById('funcionarioTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const rowStatus = tr[i].getAttribute('data-status');
            if (rowStatus == status) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }

        // Limpa a barra de pesquisa ao filtrar por status
        document.getElementById('searchInput').value = '';
    }

    function resetFilter() {
        const table = document.getElementById('funcionarioTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            tr[i].style.display = ""; // Mostra todas as linhas
        }

        // Limpa a barra de pesquisa ao resetar o filtro
        document.getElementById('searchInput').value = '';
    }
</script>

@include('includes.footer')
