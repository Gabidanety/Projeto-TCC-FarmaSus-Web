<!--CSS OK ASS: DUDA-->
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
        <h1 style="font-weight: bold;"> Editar Saída De Medicamentos </h1>
        <a href="/saidaLista" class="lista">
            Ver Saídas de Medicamentos
        </a>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/saidaMed.png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>

<main style="margin-top: 3%;">
    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-wrapper">
        <form action="{{ route('saidaMedMotivo.update', $saida->idSaidaMedicamento) }}" method="POST">
            @csrf
                @method('PUT')
            
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th colspan="2">Detalhes da Saída de Medicamento</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><label for="codigo">Código De Barras:</label></td>
                    <td><input type="text" id="codigo" name="codigoDeBarras" required></td>
                </tr>

                    <tr>
                        <td><label for="dataSaida">Data de Saída:</label></td>
                        <td><input type="date" id="dataSaida" name="dataSaida" value="{{ $saida->dataSaida }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="quantidade">Quantidade:</label></td>
                        <td><input type="number" id="quantidade" class="form-control" name="quantidade" value="{{ $saida->quantidade }}" min="1" required></td>
                    </tr>

                    <tr>
                        <td><label for="motivoSaida">Motivo de Saída:</label></td>
                        <td><input type="text" id="motivoSaida" name="motivoSaida" value="{{ $saida->motivoSaida }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="situacao">Situação:</label></td>
                        <td>
                            <select id="situacao" name="situacao" required>
                                <option value="1" {{ $saida->situacao == 1 ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ $saida->situacao == 0 ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="idFuncionario">Funcionário Responsável:</label></td>
                        <td><input type="number" id="idFuncionario" class="form-control" name="idFuncionario" value="{{ $saida->idFuncionario }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="idMedicamento">Medicamento:</label></td>
                        <td><input type="number" id="idMedicamento" class="form-control" name="idMedicamento" value="{{ $saida->idMedicamento }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="lote">Lote:</label></td>
                        <td><input type="text" id="lote" name="lote" value="{{ $saida->lote }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="validade">Validade:</label></td>
                        <td><input type="date" id="validade" name="validade" value="{{ $saida->validade }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="observacao">Observação:</label></td>
                        <td><input type="text" id="observacao" name="observacao" value="{{ $saida->observacao }}"></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="submit-btn" style="margin-bottom: 40%;">Atualizar Saída</button>
        </form>
    </div>
<br>
</main>
