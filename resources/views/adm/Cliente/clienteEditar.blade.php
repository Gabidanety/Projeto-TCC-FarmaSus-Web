<!--CSS completo (ASS: Duda) Cuidado pois estão estou usando um para duas páginas-->

@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/EditarUBS.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Editar Pacientes </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/AdmCriando.png') }}" alt="paciente" class="img-fluid">
    </div>
</div>

<main>
    <!-- Exibir mensagens de sucesso ou erro -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="form-wrapper" style="height: 1000px;">
        <form action="{{ route('cliente.update', $cliente->idCliente) }}" method="POST" class="styled-form">
            @csrf
            @method('PUT') <!-- Método PUT para atualização -->

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th colspan="2">Atualizar Informações do Paciente</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Nome do Cliente -->
                    <tr>
                        <td><label for="nomeCliente">Nome do Cliente:</label></td>
                        <td><input type="text" id="nomeCliente" name="nomeCliente" value="{{ $cliente->nomeCliente }}" required></td>
                    </tr>

                    <!-- CPF do Cliente -->
                    <tr>
                        <td><label for="cpfCliente">CPF do Cliente:</label></td>
                        <td><input type="text" id="cpfCliente" name="cpfCliente" maxlength="11" value="{{ $cliente->cpfCliente }}" required></td>
                    </tr>

                    <!-- CNS do Cliente -->
                    <tr>
                        <td><label for="cnsCliente">CNS do Cliente:</label></td>
                        <td><input type="text" id="cnsCliente" name="cnsCliente" maxlength="15" value="{{ $cliente->cnsCliente }}" required></td>
                    </tr>

                    <!-- Data de Nascimento -->
                    <tr>
                        <td><label for="dataNascCliente">Data de Nascimento:</label></td>
                        <td><input type="date" id="dataNascCliente" name="dataNascCliente" value="{{ $cliente->dataNascCliente }}" required></td>
                    </tr>

                    <!-- Usuário -->
                    <tr>
                        <td><label for="userCliente">Usuário:</label></td>
                        <td><input type="text" id="userCliente" name="userCliente" value="{{ $cliente->userCliente }}" required></td>
                    </tr>

                    <!-- Telefone do Cliente -->
                    <tr>
                        <td><label for="numeroTelefoneCliente">Novo Telefone do Cliente:</label></td>
                        <td><input type="text" id="numeroTelefoneCliente" name="numeroTelefoneCliente" maxlength="15" oninput="mascaraTelefone(this)" value="{{ $telefone->numeroTelefoneCliente }}" required></td>
                    </tr>

                    <!-- CEP do Cliente -->
                    <tr>
                        <td><label for="cepCliente">CEP do Cliente:</label></td>
                        <td><input type="text" id="cepCliente" name="cepCliente" maxlength="8" value="{{ $cliente->cepCliente }}" required></td>
                    </tr>

                    <!-- Complemento -->
                    <tr>
                        <td><label for="complementoCliente">Complemento:</label></td>
                        <td><input type="text" id="complementoCliente" name="complementoCliente" value="{{ $cliente->complementoCliente }}"></td>
                    </tr>

                    <!-- Logradouro -->
                    <tr>
                        <td><label for="logradouroCliente">Logradouro:</label></td>
                        <td><input type="text" id="logradouroCliente" name="logradouroCliente" value="{{ $cliente->logradouroCliente }}" required readonly></td>
                    </tr>

                    <!-- Bairro -->
                    <tr>
                        <td><label for="bairroCliente">Bairro:</label></td>
                        <td><input type="text" id="bairroCliente" name="bairroCliente" value="{{ $cliente->bairroCliente }}" required readonly></td>
                    </tr>

                    <!-- Cidade -->
                    <tr>
                        <td><label for="cidadeCliente">Cidade:</label></td>
                        <td><input type="text" id="cidadeCliente" name="cidadeCliente" value="{{ $cliente->cidadeCliente }}" required readonly></td>
                    </tr>

                    <!-- UF -->
                    <tr>
                        <td><label for="ufCliente">UF:</label></td>
                        <td>
                            <select id="ufCliente" name="ufCliente" required onchange="updateEstado()">
                                <option value="">Selecione um estado</option>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AP">AP</option>
                                <option value="AM">AM</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MT">MT</option>
                                <option value="MS">MS</option>
                                <option value="MG">MG</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PR">PR</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="SC">SC</option>
                                <option value="SP">SP</option>
                                <option value="SE">SE</option>
                                <option value="TO">TO</option>
                            </select>
                        </td>
                    </tr>

                    <!-- Estado -->
                    <tr>
                        <td><label for="estadoCliente">Estado:</label></td>
                        <td><input type="text" id="estadoCliente" name="estadoCliente" value="{{ $cliente->estadoCliente }}" required></td>
                    </tr>

                    <!-- Número -->
                    <tr>
                        <td><label for="numeroCliente">Número:</label></td>
                        <td><input type="text" id="numeroCliente" name="numeroCliente" maxlength="11" value="{{ $cliente->numeroCliente }}" required></td>
                    </tr>

                </tbody>
            </table>

            <div class="form-group button-wrapper" style="margin-bottom: 90%;">
                <button type="submit" class="submit-btn">Atualizar Cliente</button>
            </div>

        </form>
    </div>

</main>
<br>
@include('includes.footer')

<!-- Script para buscar endereço usando a API do ViaCEP -->
<script>
    // Máscara para o telefone
    function mascaraTelefone(input) {
        var valor = input.value.replace(/\D/g, '');
        if (valor.length <= 10) {
            input.value = valor.replace(/(\d{2})(\d)/, '($1) $2').replace(/(\d)(\d{4})$/, '$1-$2');
        } else {
            input.value = valor.replace(/(\d{2})(\d)(\d{4})(\d+)/, '($1) $2 $3-$4');
        }
    }

    // API ViaCEP
    document.getElementById('cepCliente').addEventListener('blur', function() {
        var cep = this.value.replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if(validacep.test(cep)) {
                document.getElementById('logradouroCliente').value = '...';
                document.getElementById('bairroCliente').value = '...';
                document.getElementById('cidadeCliente').value = '...';
                document.getElementById('ufCliente').value = '...';
                
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!("erro" in data)) {
                            document.getElementById('logradouroCliente').value = data.logradouro;
                            document.getElementById('bairroCliente').value = data.bairro;
                            document.getElementById('cidadeCliente').value = data.localidade;
                            document.getElementById('ufCliente').value = data.uf;
                        } else {
                            alert("CEP não encontrado.");
                        }
                    });
            } else {
                alert("Formato de CEP inválido.");
            }
        }
    });
</script>
