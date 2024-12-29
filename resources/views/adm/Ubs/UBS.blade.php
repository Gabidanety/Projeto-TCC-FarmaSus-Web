<!--CSS finalizado OK (ASS:Duda)-->

@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/UBS.css')}}">


<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> UBS </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/AdmTrabalhandoSemFundo.png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>

<div class="tabela">
    <div class="btn-container">
        <div class="btn-card">
            <p><i class="fas fa-hospital"></i> Posto</p>
            <a href="/selectRegiaoForm" class="btn-acao"><i class="fas fa-plus"></i> Criar</a>
        </div>
        <div class="btn-card">
            <p><i class="fas fa-map-marker-alt"></i> Região</p>
            <a href="/formRegiao" class="btn-acao"><i class="fas fa-plus"></i> Criar</a>
        </div>
        <div class="btn-card">
            <p><i class="fas fa-pharmacy"></i> Farmacia</p>
            <a href="/farmacia" class="btn-acao"><i class="fas fa-plus"></i> Criar</a>
        </div>
        <div class="btn-card">
            <p><i class="fas fa-phone"></i> Telefone</p>
            <a href="/formTelefone" class="btn-acao"><i class="fas fa-plus"></i> Criar</a>
        </div>
    </div>
</div>

<main>
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Unidades Básicas de Saúde (UBS)</h3>
                <div class="icon-container">
                    <div class="container-pesquisa">
                        <input type="text" id="input-pesquisa" placeholder="Pesquisar por nome ou CNPJ da UBS...">
                    </div>
                    <i class="fas fa-filter" data-bs-toggle="modal" data-bs-target="#filterModal" style="color: white;"></i>
                </div>
            </div>

            <!-- Tabela de UBS -->
            <table class="ubs-table">
                <thead>
                    <tr>
                        <th>Nome UBS</th>
                        <th>E-mail UBS</th>
                        <th>CNPJ UBS</th>
                        <th>Situação</th>
                        <th>Data Cadastro</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                        <th>Ver Mais</th>
                    </tr>
                </thead>
                
                <tbody id="ubsTableBody">
                    @foreach ($ubs as $unidade)
                    <tr class="ubs-row" data-situacao="{{ $unidade->situacaoUBS }}" style="{{ $unidade->situacaoUBS == 0 ? 'display:none;' : '' }}">
                        <td>{{ $unidade->nomeUBS }}</td>
                        <td>{{ $unidade->emailUBS }}</td>
                        <td>{{ $unidade->cnpjUBS }}</td>
                        <td>{{ $unidade->situacaoUBS }}</td>
                        <td>{{ $unidade->dataCadastroUBS }}</td>

                        <td>
                            <a href="{{ route('ubs.edit', $unidade->idUBS) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i> Editar
                            </a>
                        </td>

                        <td>
                            <form action="{{ route('changeStatus', $unidade->idUBS) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Excluir
                                </button>
                            </form>
                        </td>

                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalhes{{ $unidade->idUBS }}">
                                <i class="fas fa-eye"></i> Ver mais
                            </button>
                        </td>

                    </tr>

                    <!-- Modal de Detalhes -->
                    <div class="modal fade" id="modalDetalhes{{ $unidade->idUBS }}" tabindex="-1" aria-labelledby="modalUBSLabel" aria-hidden="true" style="margin-left: 10%; margin-top: 10%;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalUBSLabel">Detalhes da UBS</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- <img src="{{ asset('storage/' . $unidade->fotoUBS) }}" alt="Foto Original" style="max-width: 100%;" id="imagemExibida{{ $unidade->idUBS }}"> -->
                                    <p><strong>Situação UBS:</strong> {{ $unidade->situacaoUBS }}</p>
                                    <p><strong>Nome UBS:</strong> {{ $unidade->nomeUBS }}</p>
                                    <p><strong>E-mail:</strong> {{ $unidade->emailUBS }}</p>
                                    <p><strong>CNPJ:</strong> {{ $unidade->cnpjUBS }}</p>
                                    <p><strong>CEP:</strong> {{ $unidade->cepUBS }}</p>
                                    <p><strong>Endereço:</strong> {{ $unidade->logradouroUBS }}, nº {{ $unidade->numeroUBS }}, {{ $unidade->bairroUBS }}, {{ $unidade->cidadeUBS }} - {{ $unidade->estadoUBS }}</p>
                                    <p><strong>Região de São Paulo:</strong> {{ $unidade->regiao->nomeRegiaoUBS ?? 'N/A' }}</p>
                                    <p><strong>Complemento:</strong> {{ $unidade->complementoUBS }}</p>
                                    <p><strong>Latitude:</strong> {{ $unidade->latitudeUBS }}</p>
                                    <p><strong>Longitude:</strong> {{ $unidade->longitudeUBS }}</p>
                                    <p><strong>Data de Cadastro:</strong> {{ \Carbon\Carbon::parse($unidade->dataCadastroUBS)->format('d/m/Y') }}</p>
                                    <p><strong>Telefone:</strong> {{ $unidade->telefone->numeroTelefoneUBS ?? 'N/A' }}</p>
                                    <p><strong>Telefone 2:</strong> {{ $unidade->telefone->numeroTelefoneUBS2 ?? 'Não Cadastrado' }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <!-- Modal filtro -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true" style="height: 200px; margin-left: 10%; margin-top: 10%;">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Checkboxes para os filtros -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="filterActive" checked>
                        <label class="form-check-label" for="filterActive">Ativos</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="filterInactive">
                        <label class="form-check-label" for="filterInactive">Inativos</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="filterExcluded">
                        <label class="form-check-label" for="filterExcluded">Mostrar Excluídos</label>
                    </div>
                </div>
                <div class="modal-footer" style="margin-bottom: 230px;">
                    <button type="button" id="applyFilters" class="btn btn-primary">Adicionar Filtros</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</main>
    <script>
        // Função para filtrar a tabela pela barra de pesquisa
        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#ubsTableBody tr');
            
            rows.forEach(row => {
                const nomeUBS = row.cells[0].textContent.toLowerCase(); // Nome da UBS
                const cnpjUBS = row.cells[2].textContent.toLowerCase(); // CNPJ da UBS
                
                // Verifica se a linha deve ser exibida com base na pesquisa
                const matchesSearch = nomeUBS.includes(searchTerm) || cnpjUBS.includes(searchTerm);
                const situacao = row.getAttribute('data-situacao');
                const isActive = situacao == 1;
                const isInactive = situacao == 0;

                // Verifica se a linha deve ser exibida com base nos filtros
                const showActive = document.getElementById('filterActive').checked;
                const showInactive = document.getElementById('filterInactive').checked;

                const matchesFilter = (showActive && isActive) || (showInactive && isInactive);

                // A linha é visível se corresponder à pesquisa e aos filtros
                if ((matchesSearch && matchesFilter) || (searchTerm === '' && matchesFilter)) {
                    row.style.display = 'table-row'; // Mostra a linha se corresponder
                } else {
                    row.style.display = 'none'; // Esconde a linha se não corresponder
                }
            });
        }

        // Lógica para aplicar os filtros
        document.getElementById('applyFilters').addEventListener('click', function() {
            // Atualiza a pesquisa após aplicar os filtros
            filterTable(); // Chama a função de filtragem

            // Fecha o modal após aplicar os filtros
            var modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
            modal.hide();
        });
        // Adiciona o evento de entrada ao campo de pesquisa
        document.getElementById('searchInput').addEventListener('input', filterTable);
    </script>

@include('includes.footer') <!-- include -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>