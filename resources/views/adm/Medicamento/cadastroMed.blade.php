<!--CSS OK (ASS:Duda)-->
@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/CadastroMedicamento.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Cadastrar Medicamentos </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/medicamento.png') }}" alt="Medicamentos" class="img-fluid">
    </div>
</div>

<main>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

        <div class="form-wrapper" style="height: 800px;">
            <form action="/cadastroMed" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th colspan="2">Cadastro de Medicamento</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Código de Barras -->
                        <tr>
                            <td><label for="codigoDeBarrasMedicamento"><i class="fas fa-barcode"></i> Código de Barras:</label></td>
                            <td><input type="text" class="form-control" id="codigoDeBarrasMedicamento" name="codigoDeBarras" value="{{ old('codigoDeBarras', $formData['codigoDeBarras'] ?? '') }}" required></td>
                        </tr>

                        <!-- Nome do Medicamento -->
                        <tr>
                            <td><label for="nomeMedicamento"><i class="fas fa-pills"></i> Nome do Medicamento:</label></td>
                            <td><input type="text" class="form-control" id="nomeMedicamento" name="nome" value="{{ old('nome', $formData['nome'] ?? '') }}" required></td>
                        </tr>

                        <!-- Nome Genérico -->
                        <tr>
                            <td><label for="nomeGenericoMedicamento"><i class="fas fa-capsules"></i> Nome Genérico:</label></td>
                            <td><input type="text" class="form-control" id="nomeGenericoMedicamento" name="nomeGenerico" value="{{ old('nomeGenerico', $formData['nomeGenerico'] ?? '') }}" required></td>
                        </tr>

                        <!-- Tipo de Medicamento -->
                        <tr>
                            <td><label for="idTipoMedicamento"><i class="fas fa-pump-medical"></i> Tipo de Medicamento:</label></td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" id="idTipoMedicamento" name="idTipo" required>
                                        <option value="">Selecione o Tipo de Medicamento</option>
                                        @foreach($tiposMedicamento as $t)
                                        <option value="{{ $t->idTipoMedicamento }}" {{ old('idTipo', $formData['idTipo'] ?? '') == $t->idTipoMedicamento ? 'selected' : '' }}>{{ $t->tipoMedicamento }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('TipoMedicamento', ['formData' => old()]) }}" class="btn btn-success">
                                        <i class="fas fa-plus" style="color: #384081"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Foto Medicamento Original -->
                        <tr>
                            <td><label for="fotoMedicamentoOriginal"><i class="fas fa-image"></i> Foto Medicamento Original:</label></td>
                            <td><input type="file" class="form-control" id="fotoMedicamentoOriginal" name="fotoOriginal" required></td>
                        </tr>

                        <!-- Foto Medicamento Genérico -->
                        <tr>
                            <td><label for="fotoMedicamentoGenero"><i class="fas fa-image"></i> Foto Medicamento Genérico:</label></td>
                            <td><input type="file" class="form-control" id="fotoMedicamentoGenero" name="fotoGenero" required></td>
                        </tr>

                        <!-- Detentor -->
                        <tr>
                            <td><label for="idDetentor"><i class="fas fa-user-tag"></i> Detentor:</label></td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" id="idDetentor" name="idDetentor" required>
                                        <option value="">Selecione o Detentor</option>
                                        @foreach($detentores as $d)
                                        <option value="{{ $d->idDetentor }}" {{ old('idDetentor', $formData['idDetentor'] ?? '') == $d->idDetentor ? 'selected' : '' }}>{{ $d->nomeDetentor }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('NewDetentor', ['formData' => old()]) }}" class="btn btn-success">
                                        <i class="fas fa-plus icon" style="color: #384081"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Forma Farmacêutica -->
                        <tr>
                            <td><label for="formaFarmaceuticaMedicamento"><i class="fas fa-prescription-bottle-alt"></i> Forma Farmacêutica:</label></td>
                            <td>
                                <select class="form-control" id="formaFarmaceuticaMedicamento" name="formaFarmaceutica" required>
                                    <option value="">Selecione a Forma Farmacêutica</option>
                                    <option value="Comprimido">Comprimido</option>
                                    <option value="Cápsula">Cápsula</option>
                                    <option value="Pomada">Pomada</option>
                                    <option value="Solução">Solução</option>
                                    <option value="Suspensão">Suspensão</option>
                                    <option value="Creme">Creme</option>
                                    <option value="Gel">Gel</option>
                                    <option value="Injeção">Injeção</option>
                                </select>
                            </td>
                        </tr>

                        <!-- Registro ANVISA -->
                        <tr>
                            <td><label for="registroAnvisaMedicamento"><i class="fas fa-file-medical-alt"></i> Registro ANVISA:</label></td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="registroAnvisa" id="registroSim" value="Deferido" required>
                                    <label class="form-check-label" for="registroSim">Deferido</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="registroAnvisa" id="registroNao" value="Indeferido" required>
                                    <label class="form-check-label" for="registroNao">Indeferido</label>
                                </div>
                            </td>
                        </tr>

                        <!-- Concentração -->
                        <tr>
                            <td><label for="concentracaoMedicamento"><i class="fas fa-vial"></i> Concentração:</label></td>
                            <td><input type="text" class="form-control" id="concentracaoMedicamento" name="concentracao" required></td>
                        </tr>

                        <!-- Composição -->
                        <tr>
                            <td><label for="composicaoMedicamento"><i class="fas fa-clipboard-list"></i> Composição:</label></td>
                            <td><textarea class="form-control" id="composicaoMedicamento" name="composicao" required></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Salvar Medicamento
                </button>
            </form>
        </div>
</main>
<br>
<script>
    // Função para salvar os dados do formulário no localStorage
    function salvarDados() {
        document.querySelectorAll('#medicamentoForm input, #medicamentoForm select, #medicamentoForm textarea').forEach(field => {
            localStorage.setItem(field.id, field.value);
        });
    }

    // Função para carregar os dados do localStorage nos campos do formulário
    function carregarDados() {
        document.querySelectorAll('#medicamentoForm input, #medicamentoForm select, #medicamentoForm textarea').forEach(field => {
            const valorSalvo = localStorage.getItem(field.id);
            if (valorSalvo) {
                field.value = valorSalvo;
            }
        });
    }

    // Chama carregarDados ao carregar a página
    window.onload = carregarDados;

    // Salva os dados sempre que um campo for alterado
    document.getElementById('medicamentoForm').addEventListener('input', salvarDados);

    // Adiciona o salvamento ao clicar nos botões de redirecionamento
    document.querySelectorAll('.btn.btn-success').forEach(button => {
        button.addEventListener('click', salvarDados);
    });
</script>
@include('includes.footer') <!-- Include do Footer -->