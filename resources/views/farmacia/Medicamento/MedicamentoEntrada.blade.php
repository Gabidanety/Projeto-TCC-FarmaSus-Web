<!--CSS OK(ASS:Duda)-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/EntradaMedicamento.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Entrada De Medicamentos </h1>
        <p>gerencie as entradas.</p>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/saidaMed.png') }}" alt="Entrada De Medicamentos" class="img-fluid">
    </div>
</div>

<div class="cadastros-container">
    <h3><i class='bx bx-plus-circle' style="margin-right: 6px;"></i> Cadastrar </h3>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p> Cadastrar Entrada Medicamento</p>
            <a href="{{ route('entradaMedInsert') }}" class="cadastrar-link">
                <i class="fas fa-inbox"></i> 
            </a>
        </div>
    </div>
</div>

<main>
    <div class="pesquisa">
        <p class="titulo-pesquisa">Buscar Entradas</p>
        <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar por Nome, Lote, Funcionário ou Motivo">
    </div>

    <div class="container">
        <table class="table table-bordered table-striped" id="medicamentoTable"> <!-- Adicionando o ID aqui -->
            <thead>
                <tr>
                    <th>Nome do Medicamento</th>
                    <th>Data de Entrada</th>
                    <th>Quantidade</th>
                    <th>Lote</th>
                    <th>Validade</th>
                    <th>Motivo da Entrada</th>
                    <th>Funcionário Responsável</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicamentos as $med)
                    <tr>
                        <!-- <td>{{ $med->idEntradaMedicamento }}</td> -->
                        <td>{{ $med->nomeMedicamento }}</td>
                        <td>{{ $med->dataEntrada }}</td>
                        <td>{{ $med->quantidade }}</td>
                        <td>{{ $med->lote }}</td>
                        <td>{{ $med->validade }}</td>
                        <td>{{ $med->motivoEntrada }}</td>
                        <td>{{ $med->nomeFuncionario }}</td>
                        <td>
                            <a href="{{ route('entradaMedEdit', $med->idEntradaMedicamento) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('entradaMedDelete', $med->idEntradaMedicamento) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@include('includes.footer')

<!-- Script para o filtro -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#medicamentoTable tbody tr');

    rows.forEach(row => {
        const columns = row.getElementsByTagName('td');
        let match = false;

        for (let i = 0; i < columns.length; i++) {
            if (columns[i].textContent.toLowerCase().includes(filter)) {
                match = true;
                break;
            }
        }

        row.style.display = match ? '' : 'none'; // Exibir ou ocultar a linha
    });
});
</script>