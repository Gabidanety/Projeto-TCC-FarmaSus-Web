<!-- CSS finalizado aqui (ASS: Duda)-->
 
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
        <h1 style="font-weight: bold;"> Cadastrar Pacientes </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/AdmCriando.png') }}" alt="paciente" class="img-fluid">
    </div>
</div>

<!-- MAIN -->
<main>
    <!--Alert para exibir mensagens de sucesso ou erro -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="form-wrapper">
        <form action="/criarCliente" method="POST" class="styled-form">
            @csrf 

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th colspan="2"> Cadastrar Paciente </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="nomeCliente">Nome do Cliente:</label></td>
                        <td><input type="text"id=" nomeCliente" name="nomeCliente" required ></td>
                    </tr>

                    <tr>
                        <td><label for="cpfCliente">CPF do Cliente:</label></td>
                        <td>
                            <input type="text" id="cpfCliente" name="cpfCliente" maxlength="14" required>
                            @error('cpfCliente')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>
                    </tr>

                    <tr>
                        <td> <label for="cnsCliente">CNS do Cliente:</td>
                        <td>
                            <input type="text" id="cnsCliente" name="cnsCliente" maxlength="15" required>
                            @error('cnsCliente')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>
                    </tr>

                    <tr>
                        <td><label for="dataNascCliente">Data de Nascimento:</td>
                        <td><input type="date" id="dataNascCliente" name="dataNascCliente" required></td>
                    </tr>

                    <tr>
                        <td><label for="telefoneCliente">Telefone do Cliente:</label></td>
                        <td>
                            <input type="text" id="telefoneCliente" name="telefoneCliente" maxlength="11" required>
                            @error('telefoneCliente')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>
                    </tr>

                    <tr>
                        <td><label for="cepCliente">CEP do Cliente:</label></td>
                        <td><input type="text" id="cepCliente" name="cepCliente" maxlength="9" required></td>
                    </tr>

                    <tr>
                        <td><label for="complementoCliente">Complemento:</label></td>
                        <td><input type="text" id="complementoCliente" name="complementoCliente"></td>
                    </tr>

                    <tr>
                        <td><label for="logradouroCliente">Logradouro:</label></td>
                        <td><input type="text" id="logradouroCliente" name="logradouroCliente" required></td>
                    </tr>

                    <tr>
                        <td><label for="bairroCliente">Bairro:</label></td>
                        <td><input type="text" id="bairroCliente" name="bairroCliente" required></td>
                    </tr>

                    <tr>
                        <td><label for="cidadeCliente">Cidade:</label></td>
                        <td><input type="text" id="cidadeCliente" name="cidadeCliente" required></td>
                    </tr>

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

                    <tr>
                        <td><label for="estadoCliente">Estado:</label></td>
                        <td><input type="text" id="estadoCliente" name="estadoCliente" required></td>
                    </tr>

                    <tr>
                        <td><label for="numeroCliente">Número:</label></td>
                        <td><input type="text" id="numeroCliente" name="numeroCliente" maxlength="11" required></td>
                    </tr>

                </tbody>
            </table>

            <div class="form-group">
                <button type="submit" class="submit-btn">Cadastrar Cliente</button>
            </div>

        </form>
    </div>
</main>
<br>
@include('includes.footer')



<!-- Script para buscar endereço usando a API do ViaCEP -->
<script>
   document.getElementById('cepCliente').addEventListener('blur', function() {
    var cep = this.value.replace(/\D/g, '');
    if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if (validacep.test(cep)) {
            document.getElementById('logradouroCliente').value = "...";
            document.getElementById('bairroCliente').value = "...";
            document.getElementById('cidadeCliente').value = "...";
            document.getElementById('ufCliente').value = "...";
            document.getElementById('estadoCliente').value = "..."; // Adicionei esta linha para limpar o campo Estado

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!("erro" in data)) {
                    document.getElementById('logradouroCliente').value = data.logradouro;
                    document.getElementById('bairroCliente').value = data.bairro;
                    document.getElementById('cidadeCliente').value = data.localidade;
                    document.getElementById('ufCliente').value = data.uf;

                    // Adicione o nome completo do estado
                    fetch(`https://servicodados.ibge.gov.br/api/v2/malhas/${data.uf}?formato=application/json`)
                    .then(response => response.json())
                    .then(estadoData => {
                        if (estadoData.nome) {
                            document.getElementById('estadoCliente').value = estadoData.nome; // Preencher o estado
                        } else {
                            document.getElementById('estadoCliente').value = data.uf; // Se não encontrar o nome completo, use a sigla
                        }
                    })
                    .catch(error => {
                        console.error("Erro ao buscar o nome do estado:", error);
                        document.getElementById('estadoCliente').value = data.uf; // Se houver erro, use a sigla
                    });

                } else {
                    alert("CEP não encontrado.");
                }
            })
            .catch(error => {
                alert("Erro ao buscar o CEP.");
            });
        } else {
            alert("Formato de CEP inválido.");
        }
    }
});

</script>
<!-- Script de formatação para CPF e Telefone -->
<!-- <script>
// Formatação do campo CPF
document.getElementById('cpfCliente').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = value;
});

// Formatação do campo Telefone
document.getElementById('telefoneCliente').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{2})(\d)/, '($1) $2');
    value = value.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
    e.target.value = value;
});
</script> -->

<script>
    document.getElementById('submitBtn').addEventListener('click', function() {
        // Limpar mensagens de erro anteriores
        document.querySelectorAll('.text-danger').forEach(el => el.remove());

        // Validar campos
        let isValid = true;
        const nomeCliente = document.getElementById('nomeCliente').value.trim();
        const cpfCliente = document.getElementById('cpfCliente').value.trim();
        const cnsCliente = document.getElementById('cnsCliente').value.trim();
        const telefoneCliente = document.getElementById('telefoneCliente').value.trim();

        if (!nomeCliente) {
            isValid = false;
            displayError('nomeCliente', 'O nome do cliente é obrigatório.');
        }
        if (!cpfCliente) {
            isValid = false;
            displayError('cpfCliente', 'O CPF do cliente é obrigatório.');
        }
        if (!cnsCliente) {
            isValid = false;
            displayError('cnsCliente', 'O CNS do cliente é obrigatório.');
        }
        if (!telefoneCliente) {
            isValid = false;
            displayError('telefoneCliente', 'O telefone do cliente é obrigatório.');
        }

        // Verificar se o CPF, CNS ou telefone já está cadastrado
        if (isValid) {
            checkIfExists(cpfCliente, cnsCliente, telefoneCliente).then(exists => {
                if (exists) {
                    displayError('cpfCliente', 'CPF já cadastrado no banco.');
                    displayError('cnsCliente', 'CNS já cadastrado no banco.');
                    displayError('telefoneCliente', 'Telefone já cadastrado no banco.');
                } else {
                    document.querySelector('.styled-form').submit();
                }
            });
        }
    });

    function displayError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const error = document.createElement('span');
        error.className = 'text-danger';
        error.innerText = message;
        field.parentElement.appendChild(error);
    }

    
</script>
