<!--CSS OK, ASS:DUDA-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/MotivoCadastro.css')}}">

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
        <form action="{{ route('medicamentosFarma.update', $medicamento->idMedicamento) }}" method="POST">
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
                        <td><input type="text" class="form-control" id="nomeMedicamento" name="nomeMedicamento" value="{{ $medicamento->nomeMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="nomeGenericoMedicamento">Nome Genérico:</label></td>
                        <td><input type="text" class="form-control" id="nomeGenericoMedicamento" name="nomeGenericoMedicamento" value="{{ $medicamento->nomeGenericoMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="codigoDeBarrasMedicamento">Código de Barras:</label></td>
                        <td><input type="text" class="form-control" id="codigoDeBarrasMedicamento" name="codigoDeBarrasMedicamento" value="{{ $medicamento->codigoDeBarrasMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="validadeMedicamento">Validade:</label></td>
                        <td><input type="date" class="form-control" id="validadeMedicamento" name="validadeMedicamento" value="{{ $medicamento->validadeMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="loteMedicamento">Lote:</label></td>
                        <td><input type="text" class="form-control" id="loteMedicamento" name="loteMedicamento" value="{{ $medicamento->loteMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="dosagemMedicamento">Dosagem:</label></td>
                        <td><input type="text" class="form-control" id="dosagemMedicamento" name="dosagemMedicamento" value="{{ $medicamento->dosagemMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="formaFarmaceuticaMedicamento">Forma Farmacêutica:</label></td>
                        <td><input type="text" class="form-control" id="formaFarmaceuticaMedicamento" name="formaFarmaceuticaMedicamento" value="{{ $medicamento->formaFarmaceuticaMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="composicaoMedicamento">Composição:</label></td>
                        <td><textarea class="form-control" id="composicaoMedicamento" name="composicaoMedicamento" required>{{ $medicamento->composicaoMedicamento }}</textarea></td>
                    </tr>

                    <tr>
                        <td><label for="situacaoMedicamento">Situação:</label></td>
                        <td>
                            <select class="form-control" id="situacaoMedicamento" name="situacaoMedicamento" required>
                                <option value="A" {{ $medicamento->situacaoMedicamento == 'A' ? 'selected' : '' }}>Ativo</option>
                                <option value="I" {{ $medicamento->situacaoMedicamento == 'I' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </td>
                    </tr>

                </tbody>
            </table>

            <button type="submit" class="submit-btn">Salvar</button>
        </form>
    </div>
</main>
<br>

@include('includes.footer')