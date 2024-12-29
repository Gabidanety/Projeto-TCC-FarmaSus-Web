<!--Ester, arrumei o modal, confere se está ok
Arrumei o botão de cadastrar Paciente, se não for paciente me fala, que ai trco para cliente :) (ASS: Duda)-->

@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 
<link rel="stylesheet" href="{{ url('css/Adm-CSS/Paciente.css') }}"> <!-- CSS PARA ESSA PÁGINA, SOMENTE AQUI -->

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Pacientes </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/pacientes.png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>

<div class="cadastros-container">
    <h3><i class='bx bx-plus-circle' style="margin-right: 6px;"></i> Cadastrar</h3>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p>Cadastrar Paciente</p> 
            <a href="criarCliente" class="cadastrar-link">
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
                <!-- Título de Pesquisa -->
                <h5 style="font-size: 30px;">Pesquisar Paciente</h5>
    
                <!-- Formulário de Pesquisa -->
                <form action="{{ route('cliente.filtros') }}" method="GET">
                    <div class="search-container2">
                        <input type="text" name="query" placeholder="Nome, CPF, CNS ou UF" aria-label="Pesquisar Pacientes" value="{{ request('query') }}" class="search-input2">
                        <button class="search-button2" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <!-- Tabela de clientes -->
             
            <div class="form-wrapper">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>CNS</th>
                            <th>Data de Nascimento</th>
                            <th>Usuário</th>
                            <th>Telefone</th>
                            <th>CEP</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($clientes) && count($clientes) > 0)
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->nomeCliente }}</td>
                                    <td>{{ $cliente->cpfCliente }}</td>
                                    <td>{{ $cliente->cnsCliente }}</td>
                                    <td>{{ $cliente->dataNascCliente }}</td>
                                    <td>{{ $cliente->userCliente }}</td>
                                    <td>{{ $cliente->idTelefoneCliente }}</td>
                                    <td>{{ $cliente->cepCliente }}</td>
                                    <td>
                                        <div class="action-icons">
                                            <a href="{{ route('cliente.edit', $cliente->idCliente) }}" class="icon-action" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" onclick="openDetailsModal({{ json_encode($cliente) }})" class="icon-action" title="Ver Mais">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('deletarCliente', $cliente->idCliente) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="icon-action" title="Deletar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">Nenhum Paciente encontrado.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Overlay para desfoque -->
            <div id="overlay" class="overlay" style="display: none;"></div>
        </div>
    </div>

    <!-- Modal de Detalhes -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDetailsModal()">&times;</span>
            <h2>Detalhes do Paciente</h2>
            <div id="detailsContent">
                <p><strong>Nome:</strong> <span id="detailNome"></span></p>
                <p><strong>CPF:</strong> <span id="detailCpf"></span></p>
                <p><strong>CNS:</strong> <span id="detailCns"></span></p>
                <p><strong>Data de Nascimento:</strong> <span id="detailDataNasc"></span></p>
                <p><strong>Usuário:</strong> <span id="detailUsuario"></span></p>
                <p><strong>Telefone:</strong> <span id="detailTelefone"></span></p>
                <p><strong>CEP:</strong> <span id="detailCep"></span></p>
                <p><strong>Logradouro:</strong> <span id="detailLogradouro"></span></p>
                <p><strong>Bairro:</strong> <span id="detailBairro"></span></p>
                <p><strong>Número:</strong> <span id="detailNumero"></span></p>
                <p><strong>UF:</strong> <span id="detailUf"></span></p>
                <p><strong>Cidade:</strong> <span id="detailCidade"></span></p>
            </div>
        </div>
    </div>
</main>

@include('includes.footer')

<script>
// Função para abrir o modal de detalhes
function openDetailsModal(cliente) {
    var modal = document.getElementById("detailsModal");
    
    // Preenche os detalhes do cliente no modal
    document.getElementById("detailNome").textContent = cliente.nomeCliente || 'N/A';
    document.getElementById("detailCpf").textContent = cliente.cpfCliente || 'N/A';
    document.getElementById("detailCns").textContent = cliente.cnsCliente || 'N/A';
    document.getElementById("detailDataNasc").textContent = cliente.dataNascCliente || 'N/A';
    document.getElementById("detailUsuario").textContent = cliente.userCliente || 'N/A';
    document.getElementById("detailTelefone").textContent = cliente.idTelefoneCliente || 'N/A';
    document.getElementById("detailCep").textContent = cliente.cepCliente || 'N/A';
    document.getElementById("detailLogradouro").textContent = cliente.logradouroCliente || 'N/A';
    document.getElementById("detailBairro").textContent = cliente.bairroCliente || 'N/A';
    document.getElementById("detailNumero").textContent = cliente.numeroCliente || 'N/A';
    document.getElementById("detailUf").textContent = cliente.ufCliente || 'N/A';
    document.getElementById("detailCidade").textContent = cliente.cidadeCliente || 'N/A';

    modal.style.display = "block";
}

// Função para fechar o modal de detalhes
function closeDetailsModal() {
    var modal = document.getElementById("detailsModal");
    modal.style.display = "none";
}

// Fecha o modal se o usuário clicar fora dele
window.onclick = function(event) {
    var modal = document.getElementById("detailsModal");
    if (event.target === modal) {
        closeDetailsModal();
    }
}
</script>
