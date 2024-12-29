<!--Tudo Ok por aqui no front (ASS: Duda-->
@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/Detentor.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Detentores </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/geren.png') }}" alt="Detentores" class="img-fluid">
    </div>
</div>

<div class="cadastros-container">
    <h3><i class='bx bx-plus-circle' style="margin-right: 6px;"></i> Cadastrar</h3>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p>Cadastrar Detentor</p> 
            <a href="/detentorCadastro" class="cadastrar-link">
                <i class="fas fa-plus"></i>
                <span class="status-busca"> Cadastrar </span>
            </a>
        </div>
    </div>
</div>

<main>
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h5 style="font-size: 30px; font-weight: bold;">Detentores</h5>
                <!-- Formulário de Pesquisa para quando tiver -->
                <form action="" method="GET">
                    <div class="search-container2">
                        <input type="text" name="query" placeholder="Nome, CNPJ, CNS ou UF" aria-label="Pesquisar Detentores" value="{{ request('query') }}" class="search-input2">
                        <button class="search-button2" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="form-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Email</th>
                    <th>Situação</th>
                    <th>Data</th>
                    <th>Ações</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($detentores as $d)
                    <tr>
                        <td>{{ $d->nomeDetentor }}</td>
                        <td>{{ $d->cnpjDetentor }}</td>
                        <td>{{ $d->emailDetentor }}</td>
                        <!-- <td>{{ $d->situacaoDetentor }}</td> -->
                        <td>
                            @if( $d->situacaoDetentor === 'A')
                            Ativado
                            @elseif( $d->situacaoDetentor === 'D')
                            Desativado
                            @else
                            Indefinido
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($d->dataCadastroDetentor)->format('d/m/Y') }}</td>

                        <!-- Botão para abrir o modal -->
                        <td>
                            <a href="{{ route('detentor.edit', $d->idDetentor) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('desativarDetentor', $d->idDetentor) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-ban"></i> Desativar
                                </button>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalhes{{ $d->idDetentor }}">
                                <i class="fas fa-eye"></i> Ver mais
                            </button>
                        </td>

                    </tr>

                    <!-- Modal para os detalhes -->
                    <div class="modal fade" id="modalDetalhes{{ $d->idDetentor }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Detalhes do Detentor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nome:</strong> {{ $d->nomeDetentor }}</p>
                                    <p><strong>CNPJ:</strong> {{ $d->cnpjDetentor }}</p>
                                    <p><strong>Email:</strong> {{ $d->emailDetentor }}</p>
                                    <p><strong>Logradouro:</strong> {{ $d->logradouroDetentor }}</p>
                                    <p><strong>Bairro:</strong> {{ $d->bairroDetentor }}</p>
                                    <p><strong>Cidade:</strong> {{ $d->cidadeDetentor }}</p>
                                    <p><strong>Estado:</strong> {{ $d->estadoDetentor }}</p>
                                    <p><strong>UF:</strong> {{ $d->ufDetentor }}</p>
                                    <p><strong>CEP:</strong> {{ $d->cepDetentor }}</p>
                                    <p><strong>Número:</strong> {{ $d->numeroDetentor }}</p>
                                    <p><strong>Complemento:</strong> {{ $d->complementoDetentor }}</p>
                                    <p><strong>Situação:</strong> 
                                        @if( $d->situacaoDetentor === 'A') Ativado
                                        @elseif( $d->situacaoDetentor === 'D') Desativado
                                        @else Indefinido
                                        @endif
                                    </p>
                                    <p><strong>Data de Cadastro:</strong> {{ \Carbon\Carbon::parse($d->dataCadastroDetentor)->format('d/m/Y') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('detentor.edit', $d->idDetentor) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('desativarDetentor', $d->idDetentor) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT') <!-- Usando PUT para indicar a atualização -->
                                        <button type="submit" class="btn btn-danger btn-sm">Desativar</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
<br>

@include('includes.footer')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
