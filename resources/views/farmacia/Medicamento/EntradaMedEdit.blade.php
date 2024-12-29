<!--CSS OK (ASS:Duda)-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/Entrada.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Editar Entrada De Medicamentos </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/saidaMed.png') }}" alt="Entrada De Medicamentos" class="img-fluid">
    </div>
</div>

<main>
<div class="form-wrapper">
    <form action="{{ route('entradaMedUpdate', $entrada->idEntradaMedicamento) }}" method="POST" class="styled-form">
        @csrf
        @method('PUT')

        <!-- Tabela de Formulário -->
        <table class="form-table">
            <thead>
                <tr>
                    <th colspan="2">Atualizar Entrada de Medicamento</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><label for="codigo">Código De Barras:</label></td>
                    <td><input type="text" name="codigobarras" id="codigodebarras" placeholder="00000000000000"></td>
                </tr>

                <!-- Medicamento -->
                <tr>
                    <td><label for="medicamento">Medicamento:</label></td>
                    <td>
                        <select name="idMedicamento" id="medicamento" class="form-control" required>
                            <option value="">Selecione um medicamento</option>
                            @foreach($medicamentos as $medicamentoOption)
                                <option value="{{ $medicamentoOption->idMedicamento }}" 
                                        data-lote="{{ $medicamentoOption->loteMedicamento }}" 
                                        data-validade="{{ $medicamentoOption->validadeMedicamento }}"
                                        @if($medicamentoOption->idMedicamento == $entrada->idMedicamento) selected @endif>
                                    {{ $medicamentoOption->nomeMedicamento }}
                                </option>
                            @endforeach
                        </select>
                        <small id="medicamentoError" style="color: red; display: none;">Medicamento não cadastrado.</small>
                    </td>
                </tr>

                <!-- Data de Entrada -->
                <tr>
                    <td><label for="dataEntrada">Data de Entrada:</label></td>
                    <td><input type="date" name="dataEntrada" class="form-control" value="{{ $entrada->dataEntrada }}" required></td>
                </tr>

                <!-- Quantidade -->
                <tr>
                    <td><label for="quantidade">Quantidade:</label></td>
                    <td><input type="number" name="quantidade" class="form-control" value="{{ $entrada->quantidade }}" required></td>
                </tr>

                <!-- Lote -->
                <tr>
                    <td><label for="lote">Lote:</label></td>
                    <td><input type="text" name="lote" class="form-control" value="{{ $entrada->lote }}" required readonly id="lote"></td>
                </tr>

                <!-- Validade -->
                <tr>
                    <td><label for="validade">Validade:</label></td>
                    <td><input type="date" name="validade" class="form-control" value="{{ $entrada->validade }}" required readonly id="validade"></td>
                </tr>

                <!-- Motivo da Entrada -->
                <tr>
                    <td><label for="motivoEntrada">Motivo da Entrada:</label></td>
                    <td><input type="text" name="motivoEntrada" class="form-control" id="motivoEntrada" value="{{ $motivoEntrada }}" required placeholder="Digite o motivo da entrada"></td>
                </tr>

                <!-- Funcionário Responsável -->
                <tr>
                    <td><label for="funcionario">Funcionário Responsável:</label></td>
                    <td>
                        <select name="idFuncionario" id="funcionario" class="form-control" required>
                            <option value="">Selecione um funcionário</option>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario->idFuncionario }}" @if($funcionario->idFuncionario == $entrada->idFuncionario) selected @endif>
                                    {{ $funcionario->nomeFuncionario }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Botão de Atualizar -->
        <button type="submit" class="submit-btn">Atualizar</button>
    </form>
</div>
<br>
</main>



@include('includes.footer')


<script>
// Script para preencher automaticamente lote e validade ao selecionar o medicamento
document.getElementById('medicamento').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var lote = selectedOption.getAttribute('data-lote');
    var validade = selectedOption.getAttribute('data-validade');

    document.getElementById('lote').value = lote ? lote : '';
    document.getElementById('validade').value = validade ? validade : '';
});
</script>

