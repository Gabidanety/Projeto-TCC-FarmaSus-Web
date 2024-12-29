@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/CadastrarSaida.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Cadastrar Saída De Medicamentos </h1>
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
    <form action="/saidaMed" method="POST" class="styled-form">
        @csrf

        <table class="form-table">
            <thead>
                <tr>
                    <th colspan="2">Registrar Saída de Medicamento</th>
                </tr>
            </thead>
            <tbody>
                <!-- Código de Barras -->
                <tr>
                    <td><label for="codigoBarras">Código de Barras:</label></td>
                    <td>
                        <input type="text" name="codigoBarras" id="codigoBarras" required>
                        <small id="codigoBarrasError" style="color: red; display: none;"> </small>
                    </td>
                </tr>

                <!-- Medicamento -->
                <tr>
                    <td><label for="nomeMedicamento">Medicamento:</label></td>
                    <td><input type="text" id="nomeMedicamento" readonly></td>
                </tr>

                <!-- Data de Saída -->
                <tr>
                    <td><label for="dataSaida">Data de Saída:</label></td>
                    <td>
                        <input type="date" name="dataSaida" value="{{ date('Y-m-d') }}" required>
                    </td>
                </tr>

                <!-- Quantidade -->
                <tr>
                    <td><label for="quantidade">Quantidade:</label></td>
                    <td>
                        <input type="number" name="quantidade" id="quantidade" required>
                    </td>
                </tr>

                <!-- Lote -->
                <tr>
                    <td><label for="lote">Lote:</label></td>
                    <td>
                        <input type="text" name="lote" id="lote" readonly>
                    </td>
                </tr>

                <!-- Validade -->
                <tr>
                    <td><label for="validade">Validade:</label></td>
                    <td>
                        <input type="date" name="validade" id="validade" readonly>
                    </td>
                </tr>

                <!-- Motivo da Saída -->
                <tr>
                    <td><label for="motivoSaida">Motivo da Saída:</label></td>
                    <td>
                        <input type="text" name="motivoSaida" id="motivoSaida" required placeholder="Digite o motivo da saída">
                    </td>
                </tr>

                <!-- Funcionário Responsável -->
                <tr>
                    <td><label for="funcionario">Funcionário Responsável:</label></td>
                    <td>
                        <select name="idFuncionario" id="funcionario" required>
                            <option value="">Selecione um funcionário</option>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario->idFuncionario }}">{{ $funcionario->nomeFuncionario }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Botão de Registrar -->
        <div class="form-actions">
            <button type="submit" class="submit-btn">Registrar Saída</button>
        </div>
    </form>
</div>
</main>
@include('includes.footer')

<script>
    // Alteração para buscar medicamento ao pressionar Enter no campo "Código de Barras"
    document.getElementById('codigoBarras').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {  // Verifica se a tecla pressionada foi Enter
            event.preventDefault(); // Impede o comportamento padrão (não envia o formulário)

            const codigoBarras = this.value.trim();

            if (!codigoBarras) {
                alert('Por favor, insira o código de barras.');
                return;
            }

            fetch(`/buscarPorCodigoBarras?codigoBarras=${codigoBarras}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(' ');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('codigoBarrasError').style.display = 'none';
                    document.getElementById('nomeMedicamento').value = data.nomeMedicamento;
                    document.getElementById('lote').value = data.lote;
                    document.getElementById('validade').value = data.validade;
                    document.getElementById('idMedicamento').value = data.idMedicamento;
                })
                .catch(error => {
                    console.error('Erro ao buscar medicamento:', error);
                    document.getElementById('codigoBarrasError').style.display = 'block';
                });
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
