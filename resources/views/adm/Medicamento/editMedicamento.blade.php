<!--CSS OK (ASS:Duda)-->
@include('includes.header') 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/CadastroMedicamento.css') }}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Editar Medicamentos </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/medi.png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>

<main>
    <div class="form-wrapper">
        <form action="{{ route('medicamento.update', $medicamento->idMedicamento) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th colspan="2">Detalhes do Medicamento</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><label for="nomeMedicamento">Nome do Medicamento:</label></td>
                        <td><input type="text" class="form-control" id="nomeMedicamento" name="nome" value="{{ $medicamento->nomeMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="nomeGenericoMedicamento">Nome Genérico:</label></td>
                        <td><input type="text" class="form-control" id="nomeGenericoMedicamento" name="nomeGenerico" value="{{ $medicamento->nomeGenericoMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="codigoDeBarrasMedicamento">Código de Barras:</label></td>
                        <td><input type="text" class="form-control" id="codigoDeBarrasMedicamento" name="codigoDeBarras" value="{{ $medicamento->codigoDeBarrasMedicamento }}" readonly required></td>
                    </tr>

                    <tr>
                        <td><label for="fotoMedicamentoOriginal">Foto Medicamento Original:</label></td>
                        <td>
                            <img id="imgPreviewOriginal" src="{{ asset('storage/' . $medicamento->fotoMedicamentoOriginal) }}" alt="Foto do Medicamento Original" style="max-width: 150px; cursor: pointer;" onclick="document.getElementById('fotoOriginal').click();">
                            <input type="file" id="fotoOriginalMedicamento" name="fotoOriginalMedicamento" style="display: none;" onchange="previewImage(event, 'imgPreviewOriginal')">
                        </td>
                    </tr>

                    <tr>
                        <td><label for="fotoMedicamentoGenero">Foto Medicamento Genérico:</label></td>
                        <td>
                            <img id="imgPreviewGenero" src="{{ asset('storage/' . $medicamento->fotoMedicamentoGenero) }}" alt="Foto do Medicamento Genérico" style="max-width: 150px; cursor: pointer;" onclick="document.getElementById('fotoGenero').click();">
                            <input type="file" id="fotoGenericoMedicamento" name="fotoGenericoMedicamento" style="display: none;" onchange="previewImage(event, 'imgPreviewGenero')">
                        </td>
                    </tr>

                    <tr>
                        <td><label for="registroAnvisaMedicamento">Registro ANVISA:</label></td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="registroAnvisa" id="registroSim" value="Deferido" {{ $medicamento->registroAnvisaMedicamento == 'D' || $medicamento->registroAnvisaMedicamento == 'on' ? 'checked' : '' }}>
                                <label class="form-check-label" for="registroSim">Deferido</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="registroAnvisa" id="registroNao" value="Indeferido" {{ $medicamento->registroAnvisaMedicamento == 'I' || $medicamento->registroAnvisaMedicamento == 'off' ? 'checked' : '' }}>
                                <label class="form-check-label" for="registroNao">Indeferido</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="idDetentor">Detentor:</label></td>
                        <td>
                            <select class="form-control" id="idDetentor" name="idDetentor" required>
                                <option value="">Selecione o Detentor</option>
                                @foreach($detentor as $d)
                                    <option value="{{ $d->idDetentor }}" {{ $medicamento->idDetentor == $d->idDetentor ? 'selected' : '' }}>
                                        {{ $d->nomeDetentor }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="idTipoMedicamento">Tipo de Medicamento:</label></td>
                        <td>
                            <select class="form-control" id="idTipoMedicamento" name="idTipo" required>
                                <option value="">Selecione o Tipo de Medicamento</option>
                                @foreach($tiposMedicamento as $t)
                                    <option value="{{ $t->idTipoMedicamento }}" {{ $medicamento->idTipoMedicamento == $t->idTipoMedicamento ? 'selected' : '' }}>
                                        {{ $t->tipoMedicamento }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="formaFarmaceuticaMedicamento">Forma Farmacêutica:</label></td>
                        <td>
                            <select class="form-control" id="formaFarmaceuticaMedicamento" name="formaFarmaceutica" required>
                                <option value="">Selecione a Forma Farmacêutica</option>
                                <option value="Comprimido" {{ $medicamento->formaFarmaceuticaMedicamento == 'Comprimido' ? 'selected' : '' }}>Comprimido</option>
                                <option value="Cápsula" {{ $medicamento->formaFarmaceuticaMedicamento == 'Cápsula' ? 'selected' : '' }}>Cápsula</option>
                                <option value="Pomada" {{ $medicamento->formaFarmaceuticaMedicamento == 'Pomada' ? 'selected' : '' }}>Pomada</option>
                                <option value="Solução" {{ $medicamento->formaFarmaceuticaMedicamento == 'Solução' ? 'selected' : '' }}>Solução</option>
                                <option value="Suspensão" {{ $medicamento->formaFarmaceuticaMedicamento == 'Suspensão' ? 'selected' : '' }}>Suspensão</option>
                                <option value="Creme" {{ $medicamento->formaFarmaceuticaMedicamento == 'Creme' ? 'selected' : '' }}>Creme</option>
                                <option value="Gel" {{ $medicamento->formaFarmaceuticaMedicamento == 'Gel' ? 'selected' : '' }}>Gel</option>
                                <option value="Injeção" {{ $medicamento->formaFarmaceuticaMedicamento == 'Injeção' ? 'selected' : '' }}>Injeção</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="concentracaoMedicamento">Concentração:</label></td>
                        <td><input type="text" class="form-control" id="concentracaoMedicamento" name="concentracao" value="{{ $medicamento->concentracaoMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="composicaoMedicamento">Composição:</label></td>
                        <td><textarea class="form-control" id="composicaoMedicamento" name="composicao" required>{{ $medicamento->composicaoMedicamento }}</textarea></td>
                    </tr>

                    <tr>
                        <td><label for="situacaoMedicamento">Situação:</label></td>
                        <td>
                            <select class="form-control" id="situacaoMedicamento" name="situacaoMedicamento">
                                <option value="A" {{ $medicamento->situacaoMedicamento == 'A' ? 'selected' : '' }}>Ativo</option>
                                <option value="D" {{ $medicamento->situacaoMedicamento == 'D' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </td>
                    </tr>

                </tbody>
            </table>

            <button type="submit" class="submit-btn">Salvar Alterações</button>
        </form>
    </div>
</main>
<br>
<!-- JavaScript para pré-visualizar a imagem selecionada -->
<script>
    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById(previewId);
            output.src = reader.result; // Atualiza o src da imagem para a nova imagem
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@include('includes.footer')
