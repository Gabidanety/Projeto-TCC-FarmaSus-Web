<!--CSS OK ASS:DUDA-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/Medicamento.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Medicamentos </h1>
        <p>gerencie os medicamentos.</p>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/medi.png') }}" alt="Entrada De Medicamentos" class="img-fluid">
    </div>
</div>

<main>

    <div class="custom-table">
        <div class="card-header-1 d-flex justify-content-between align-items-center">
            <h5>Medicamentos</h5>

            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Pesquisar por Nome, Genérico, Código ou Lote" class="form-control">
            </div>
            <!-- Botão de Filtro -->
            <button class="botãoInfo" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-filter"></i> Filtros
            </button>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Nome Genérico</th>
                            <th>Código de Barras</th>
                            <th>Motivo</th>
                            <th>Lote</th>
                            <th>Validade</th>
                            <th>Data do desativamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($desativados as $d)
                        @if ($d->situacaoMedicamento == 'D' || $d->situacaoMedicamento == '1')

                        <tr>
                            <td>{{ $d->nomeMedicamento }}</td>
                            <td>{{ $d->nomeGenericoMedicamento }}</td>
                            <td>{{ $d->codigoDeBarrasMedicamento }}</td>
                            <td>{{ $d->motivo }}</td>
                            <td>{{ $d->loteMedicamento }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->validadeMedicamento)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->dataCadastroMedicamento)->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>


<script>
    // Função para filtrar a tabela de medicamentos
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

@include('includes.footer')