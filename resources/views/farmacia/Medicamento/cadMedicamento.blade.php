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
        <h1 style="font-weight: bold;"> Cadastrar novos medicamentos </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/medi.png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>


<main>
    <div class="form-wrapper">
        <form action="/CadMedFarma" method="POST">
            @csrf
            <input type="hidden" name="idUBS" value="{{ $idUBS }}">

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th colspan="2">Cadastro de Medicamento</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><label for="codigoDeBarrasMedicamento">Código de Barras:</label></td>
                        <td><input type="text" class="form-control" id="codigoDeBarrasMedicamento" name="codigoDeBarrasMedicamento" value="{{ old('codigoDeBarrasMedicamento') }}" required onblur="buscarMedicamento()"></td>
                    </tr>

                    <tr>
                        <td><label for="nomeMedicamento">Nome do Medicamento:</label></td>
                        <td><input type="text" class="form-control" id="nomeMedicamento" name="nomeMedicamento" value="{{ old('nomeMedicamento') }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="nomeGenericoMedicamento">Nome Genérico do Medicamento:</label></td>
                        <td><input type="text" class="form-control" id="nomeGenericoMedicamento" name="nomeGenericoMedicamento" value="{{ old('nomeGenericoMedicamento') }}" required></td>
                    </tr>

                    <tr>
                        <td><label for="validadeMedicamento">Data de Validade:</label></td>
                        <td><input type="date" class="form-control" id="validadeMedicamento" name="validadeMedicamento" required></td>
                    </tr>

                    <tr>
                        <td><label for="loteMedicamento">Lote:</label></td>
                        <td><input type="text" class="form-control" id="loteMedicamento" name="loteMedicamento" required></td>
                    </tr>

                    <tr>
                        <td><label for="formaMedicamento">Forma Farmacêutica:</label></td>
                        <td>
                            <select class="form-control" id="formaMedicamento" name="forma" required>
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

                    <tr>
                        <td><label for="dosagemMedicamento">Dosagem:</label></td>
                        <td><input type="text" class="form-control" id="dosagemMedicamento" name="dosagemMedicamento" required></td>
                    </tr>

                    <tr>
                        <td><label for="composicaoMedicamento">Composição:</label></td>
                        <td><textarea class="form-control" id="composicaoMedicamento" name="composicaoMedicamento" required></textarea></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="submit-btn"> Salvar Medicamento</button>
        </form>
    </div>
</main>
<br>
<script>
    function buscarMedicamento() {
        const codigoDeBarras = $('#codigoDeBarrasMedicamento').val();

        if (codigoDeBarras) {
            $.ajax({
                url: `/CodMed/${codigoDeBarras}`,
                type: 'GET',
                success: function(data) {
                    console.log(data); // Veja o que está sendo retornado

                    if (data) {
                        // Atualiza os inputs visíveis com os valores recebidos
                        $('#nomeMedicamento').val(data.nomeMedicamento);
                        $('#nomeGenericoMedicamento').val(data.nomeGenericoMedicamento);
                        $('#composicaoMedicamento').val(data.composicaoMedicamento);
                    } else {
                        alert('Código de barras não encontrado!');
                    }
                },
                error: function(jqXHR) {
                    alert('Erro ao buscar o medicamento!');
                    console.error(jqXHR.responseText); // Exibe detalhes do erro no console
                }
            });
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@include('includes.footer')