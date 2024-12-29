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
        <h1 style="font-weight: bold;"> Cadastro da entrada de medicamentos </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/saidaMed.png') }}" alt="Entrada De Medicamentos" class="img-fluid">
    </div>
</div>

<main>
<div class="form-wrapper">
    <form action="/entradaMedicamento/store" method="POST" class="styled-form">
        @csrf

        <table class="form-table">
            <thead>
                <tr>
                    <th colspan="2">Cadastrar Entrada de Medicamento</th>
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
                    <td><input type="text" id="nomeMedicamento"></td>
                </tr>

                <!-- Data de Entrada -->
                <tr>
                    <td><label for="dataEntrada">Data de Entrada:</label></td>
                    <td>
                        <input type="date" name="dataEntrada" value="{{ date('Y-m-d') }}" required>
                    </td>
                </tr>

                <!-- Quantidade -->
                <tr>
                    <td><label for="quantidade">Quantidade:</label></td>
                    <td>
                        <input type="number" name="quantidade" required>
                    </td>
                </tr>

                <!-- Lote -->
                <tr>
                    <td><label for="lote">Lote:</label></td>
                    <td>
                        <input type="text" name="lote" id="lote">
                    </td>
                </tr>

                <!-- Validade -->
                <tr>
                    <td><label for="validade">Validade:</label></td>
                    <td>
                        <input type="date" name="validade" id="validade" >
                    </td>
                </tr>

                <!-- Motivo da Entrada -->
                <tr>
                    <td><label for="motivoEntrada">Motivo da Entrada:</label></td>
                    <td>
                        <input type="text" name="motivoEntrada" id="motivoEntrada" required placeholder="Digite o motivo da entrada">
                        <input type="hidden" name="idMotivoEntrada" id="idMotivoEntrada">
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

        <!-- Botão de Cadastrar -->
        <button type="submit" class="submit-btn">Cadastrar</button>
    </form>
</div>

</main>
<br>
@include('includes.footer')

<script>
    document.getElementById('codigoBarras').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {  // Detecta a tecla Enter
        event.preventDefault(); // Impede o comportamento padrão (não envia o formulário)

        const codigoBarras = this.value.trim();

        if (!codigoBarras) {
            alert('Por favor, insira o código de barras.');
            return;
        }

        fetch(`/buscarPorCodigoBarras?codigoBarras=${codigoBarras}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('codigoBarrasError').style.display = 'block';
                } else {
                    document.getElementById('codigoBarrasError').style.display = 'none';
                    document.getElementById('nomeMedicamento').value = data.nomeMedicamento;
                    document.getElementById('lote').value = data.lote;
                    document.getElementById('validade').value = data.validade;
                    document.getElementById('idMedicamento').value = data.idMedicamento;
                }
            })
            .catch(error => {
                console.error('Erro ao buscar medicamento:', error);
                document.getElementById('codigoBarrasError').style.display = 'block';
            });
    }
});

// motivo entrada cadastra automático
document.getElementById('motivoEntrada').addEventListener('blur', function() {
    const motivoEntrada = this.value;

    if (motivoEntrada) {
        fetch('/motivoEntrada/buscarOuCriar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    motivoEntrada: motivoEntrada
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.idMotivoEntrada) {
                    document.getElementById('idMotivoEntrada').value = data.idMotivoEntrada;
                } else {
                    console.error('Erro ao criar motivo de entrada:', data);
                }
            })
            .catch(error => console.error('Erro ao buscar/criar motivo de entrada:', error));
    }
});

    </script>    </script>
</script>