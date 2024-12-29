<!--Vinícius, fiz algumas alterações no modo telefone (ao clicar duas vezes no botão adicionar telefone,
 um modal informativo aparece dizendo que o número total já foi alcançado), Tirei o header pois ele não era necessário 
 e todos os scripts de JS estão  no final da página pois eles são internos. Creio que o front dessa já está ok (ASS: Maria Eduarda)-->

@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/EditarUBS.css') }}"> <!--CSS PARA ESSA PÁGINA FICA APENAS NESSE ARQUIVO :)-->

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Cadastrar UBS </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/AdmTrabalhandoSemFundo.png') }}" alt="UBS" class="img-fluid">
    </div>
</div>

<main>
    <div class="form-wrapper" style="height: 1000px;">
        <form id="ubsForm" action="{{ route('insertUBS') }}" method="POST" enctype="multipart/form-data" onsubmit="return checkCNPJ()">
            @csrf

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th colspan="2">Cadastro de UBS</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Nome da UBS -->
                    <tr>
                        <td><label for="ubs"><i class="fas fa-hospital"></i> Nome da UBS :</label></td>
                        <td><input type="text" name="ubs" id="ubs" class="form-control" required></td>
                    </tr>

                    <!-- E-mail -->
                    <tr>
                        <td><label for="email"><i class="fas fa-envelope"></i> E-mail :</label></td>
                        <td><input type="email" name="email" id="email" class="form-control" required></td>
                    </tr>

                    <!-- CNPJ -->
                    <tr>
                        <td><label for="cnpj"><i class="fas fa-id-card"></i> CNPJ :</label></td>
                        <td><input type="text" name="cnpj" id="cnpj" class="form-control" required></td>
                    </tr>

                    <!-- CEP -->
                    <tr>
                        <td><label for="cep"><i class="fas fa-map-marker-alt"></i> CEP :</label></td>
                        <td><input type="text" name="cep" id="cep" class="form-control" required onblur="buscaCep()"></td>
                    </tr>

                    <!-- Logradouro -->
                    <tr>
                        <td><label for="logradouro"><i class="fas fa-road"></i> Logradouro :</label></td>
                        <td><input type="text" name="logradouro" id="logradouro" class="form-control" required></td>
                    </tr>

                    <!-- Bairro -->
                    <tr>
                        <td><label for="bairro"><i class="fas fa-home"></i> Bairro :</label></td>
                        <td><input type="text" name="bairro" id="bairro" class="form-control" required></td>
                    </tr>

                    <!-- Cidade -->
                    <tr>
                        <td><label for="cidade"><i class="fas fa-city"></i> Cidade :</label></td>
                        <td><input type="text" name="cidade" id="cidade" class="form-control" required></td>
                    </tr>

                    <!-- UF -->
                    <tr>
                        <td><label for="uf"><i class="fas fa-globe"></i> UF :</label></td>
                        <td>
                            <select name="uf" id="uf" class="form-control" required>
                                <option value="">Selecione o estado</option>
                                <option value="AC">Acre (AC)</option>
                                <option value="AL">Alagoas (AL)</option>
                                <option value="AP">Amapá (AP)</option>
                                <option value="AM">Amazonas (AM)</option>
                                <option value="BA">Bahia (BA)</option>
                                <option value="CE">Ceará (CE)</option>
                                <option value="DF">Distrito Federal (DF)</option>
                                <option value="ES">Espírito Santo (ES)</option>
                                <option value="GO">Goiás (GO)</option>
                                <option value="MA">Maranhão (MA)</option>
                                <option value="MG">Minas Gerais (MG)</option>
                                <option value="MS">Mato Grosso do Sul (MS)</option>
                                <option value="MT">Mato Grosso (MT)</option>
                                <option value="PA">Pará (PA)</option>
                                <option value="PB">Paraíba (PB)</option>
                                <option value="PR">Paraná (PR)</option>
                                <option value="PE">Pernambuco (PE)</option>
                                <option value="PI">Piauí (PI)</option>
                                <option value="RJ">Rio de Janeiro (RJ)</option>
                                <option value="RN">Rio Grande do Norte (RN)</option>
                                <option value="RS">Rio Grande do Sul (RS)</option>
                                <option value="RO">Rondônia (RO)</option>
                                <option value="RR">Roraima (RR)</option>
                                <option value="SC">Santa Catarina (SC)</option>
                                <option value="SP">São Paulo (SP)</option>
                                <option value="SE">Sergipe (SE)</option>
                                <option value="TO">Tocantins (TO)</option>
                            </select>
                        </td>
                    </tr>

                    <!-- Número -->
                    <tr>
                        <td><label for="numero"><i class="fas fa-sort-numeric-up"></i> Número :</label></td>
                        <td><input type="text" name="numero" id="numero" class="form-control" required></td>
                    </tr>

                    <!-- Telefone -->
                    <tr>
                        <td><label for="telefone"><i class="fas fa-phone"></i> Telefone :</label></td>
                        <td>
                            <input type="text" name="telefone" id="telefone" class="form-control" required>
                            <input type="text" name="telefone2" id="telefone2" class="form-control" required>
                        </td>
                    </tr>

                    <!-- Latitude -->
                    <tr>
                        <td><label for="latitude"><i class="fas fa-map-marker"></i> Latitude :</label></td>
                        <td><input type="text" name="latitude" id="latitude" class="form-control" required readonly></td>
                    </tr>

                    <!-- Longitude -->
                    <tr>
                        <td><label for="longitude"><i class="fas fa-map-marker"></i> Longitude :</label></td>
                        <td><input type="text" name="longitude" id="longitude" class="form-control" required readonly></td>
                    </tr>

                    <!-- Região -->
                    <tr>
                        <td><label for="regiao"><i class="fas fa-globe-americas"></i> Selecione a Região :</label></td>
                        <td>
                            <select id="idRegiao" name="idRegiao" class="form-control" required>
                                <option value="">Selecione a região</option>
                                @foreach($regioes as $r)
                                    <option value="{{ $r->idRegiaoUBS }}">{{ $r->nomeRegiaoUBS }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- Foto UBS -->
                    <tr>
                        <td><label for="fotoUbs"><i class="fas fa-image"></i> Foto da UBS :</label></td>
                        <td><input type="file" name="fotoUBS" id="fotoUBS" class="form-control" required></td>
                    </tr>

                </tbody>
            </table>

            <button type="submit" class="submit-btn">Adicionar UBS</button>
        </form>
    </div>
</main>
<br>
<!-- Modal para exibir o número atingido de telefones -->
<div id="alertModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p id="alertText"></p>
    </div>
</div>

@include('includes.footer')

    <script>
        function buscaCep() {
            const cep = document.getElementById('cep').value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            // Preencher os campos de endereço
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('uf').value = data.uf;

                            // Chama a função para buscar latitude e longitude
                            getLatLongNominatim(data.logradouro, data.localidade, data.uf);
                        } else {
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(() => alert('Erro ao buscar o CEP.'));
            }
        }

        // Função para buscar latitude e longitude usando o Nominatim (OpenStreetMap)
        function getLatLongNominatim(logradouro, cidade, uf) {
            const enderecoCompleto = `${logradouro}, ${cidade}, ${uf}, Brasil`;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(enderecoCompleto)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const location = data[0];
                        document.getElementById('latitude').value = location.lat;
                        document.getElementById('longitude').value = location.lon;
                    } else {
                        alert('Não foi possível obter a latitude e longitude.');
                    }
                })
                .catch(() => alert('Erro ao buscar a latitude e longitude.'));
        }

        // Exibe o modal personalizado com a mensagem desejada
        function showModal(message) {
            document.getElementById("alertText").innerText = message;
            document.getElementById("alertModal").style.display = "block";
        }

        // Fecha o modal
        function closeModal() {
            document.getElementById("alertModal").style.display = "none";
        }

        let phoneCount = 0; // declaração global

        function addPhoneField() {
            if (phoneCount < 2) {
                const container = document.getElementById('telefoneContainer');

                const newField = document.createElement('div');
                newField.className = 'telefone-field';
                newField.innerHTML = `
                    <input type="text" name="telefone[]" placeholder="Número do Telefone" required>
                    <button type="button" class="remove-phone" onclick="removePhoneField(this)">
                        <i class="fas fa-minus-circle"></i>
                    </button>
                `;
                container.appendChild(newField);
                phoneCount++;
            } else {
                showModal("O limite máximo de números de telefone já foi alcançado.");
            }
        }

        function removePhoneField(button) {
            const phoneField = button.parentElement;
            phoneField.remove();
            phoneCount--; // Decrementa o contador ao remover um campo
        }

        // Validação do CNPJ
        function validaCNPJ(cnpj) {
            cnpj = cnpj.replace(/[^\d]+/g, '');

            if (cnpj.length !== 14) {
                return false;
            }

            // Elimina CNPJs inválidos conhecidos
            if (/^(\d)\1+$/.test(cnpj)) {
                return false;
            }

            let tamanho = cnpj.length - 2;
            let numeros = cnpj.substring(0, tamanho);
            let digitos = cnpj.substring(tamanho);
            let soma = 0;
            let pos = tamanho - 7;

            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) {
                    pos = 9;
                }
            }

            let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado !== parseInt(digitos.charAt(0))) {
                return false;
            }

            tamanho = tamanho + 1;
            numeros = cnpj.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;

            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) {
                    pos = 9;
                }
            }

            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            return resultado === parseInt(digitos.charAt(1));
        }

        function checkCNPJ() {
            const cnpj = document.getElementById('cnpj').value;
            if (!validaCNPJ(cnpj)) {
                alert('CNPJ inválido. Por favor, insira um CNPJ válido.');
                return false;
            }
            return true;
        }

        // Função para garantir o envio correto do formulário
        function submitForm() {
            if (checkCNPJ()) {
                document.getElementById('ubsForm').submit();
            }
        }   
    </script>
