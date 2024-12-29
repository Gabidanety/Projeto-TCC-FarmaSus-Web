<!--CSS OK(ASS: Duda-->
@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/CadastroDetentor.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Cadastrar Detentores </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/AdmAlterandoSemFundo.png') }}" alt="Medicamentos" class="img-fluid">
    </div>
</div>

<main>
    <div class="form-wrapper">
            <form action="/cadastroDetentor" method="POST" onsubmit="return checkForm()">
                @csrf
                <table class="dashboard-table">
                <thead>
                        <tr>
                            <th colspan="2">Cadastro de Detentores</th>
                        </tr>
                    </thead>
                    <tr>
                        <td><label for="nomeDetentor">Nome do Detentor</label></td>
                        <td><input type="text" class="form-control" id="nomeDetentor" name="nome" required></td>
                    </tr>
                    <tr>
                        <td><label for="emailDetentor">Email</label></td>
                        <td><input type="email" class="form-control" id="emailDetentor" name="email" required></td>
                    </tr>
                    <tr>
                        <td><label for="cnpjDetentor">CNPJ</label></td>
                        <td>
                            <input type="text" class="form-control" id="cnpjDetentor" name="cnpj" required>
                            <span id="cnpjError" class="text-danger" style="display: none;">CNPJ inválido.</span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="cepDetentor">CEP</label></td>
                        <td>
                            <input type="text" class="form-control" id="cepDetentor" name="cep" required>
                            <span id="cepError" class="text-danger" style="display: none;">CEP inválido.</span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="logradouroDetentor">Logradouro</label></td>
                        <td><input type="text" class="form-control" id="logradouroDetentor" name="logradouro" required></td>
                    </tr>
                    <tr>
                        <td><label for="bairroDetentor">Bairro</label></td>
                        <td><input type="text" class="form-control" id="bairroDetentor" name="bairro" required></td>
                    </tr>
                    <tr>
                        <td><label for="cidadeDetentor">Cidade</label></td>
                        <td><input type="text" class="form-control" id="cidadeDetentor" name="cidade" required></td>
                    </tr>
                    <tr>
                        <td><label for="estadoDetentor">Estado</label></td>
                        <td><input type="text" class="form-control" id="estadoDetentor" name="estado" required></td>
                    </tr>
                    <tr>
                        <td><label for="numeroDetentor">Número</label></td>
                        <td><input type="text" class="form-control" id="numeroDetentor" name="numero" required></td>
                    </tr>
                    <tr>
                        <td><label for="complementoDetentor">Complemento</label></td>
                        <td><input type="text" class="form-control" id="complementoDetentor" name="complemento" required></td>
                    </tr>
                </table>
                <button type="submit" class="submit-btn">Cadastrar</button>
            </form>
        </div>
    </div>
</main>
<br>
    <script>
        // Função de validação do CNPJ
        function validaCNPJ(cnpj) {
            cnpj = cnpj.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

                if (cnpj.length !== 14) {
                    return false; // CNPJ deve ter 14 dígitos
                }

                // Elimina CNPJs inválidos conhecidos
                if (/^(\d)\1+$/.test(cnpj)) {
                    return false; // Elimina sequências repetidas (ex: 11111111111111)
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
                    return false; // O primeiro dígito verificador está incorreto
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
                return resultado === parseInt(digitos.charAt(1)); // Retorna se o segundo dígito verificador está correto
            }

            function checkCNPJ() {
                const cnpj = document.getElementById('cnpjDetentor').value;
                if (!validaCNPJ(cnpj)) {
                    alert('CNPJ inválido. Por favor, insira um CNPJ válido.'); // Alerta para CNPJ inválido
                    document.getElementById('cnpjError').style.display = 'inline'; // Exibe mensagem de erro
                    return false;
                }
                document.getElementById('cnpjError').style.display = 'none'; // Esconde a mensagem de erro se válido
                return true; // Retorna true se o CNPJ for válido
            }

            function formatCNPJ() {
                const cnpjInput = document.getElementById('cnpjDetentor');
                let cnpj = cnpjInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                if (cnpj.length <= 14) {
                    cnpj = cnpj.replace(/(\d{2})(\d)/, "$1.$2"); // 00.0
                    cnpj = cnpj.replace(/(\d{3})(\d)/, "$1.$2"); // 00.000
                    cnpj = cnpj.replace(/(\d{3})(\d{1,2})$/, "$1/$2"); // 00.000/0000
                    cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2"); // 0000-00
                }

                cnpjInput.value = cnpj; // Atualiza o valor do campo
            }

            // Validação e formatação ao perder o foco (blur)
            document.getElementById('cnpjDetentor').addEventListener('blur', function() {
                checkCNPJ();
                formatCNPJ();
            });

            // Função para validar o CEP
            function validaCEP(cep) {
                cep = cep.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos
                return cep.length === 8; // CEP deve ter 8 dígitos
            }

            function checkCEP() {
                const cep = document.getElementById('cepDetentor').value;
                if (!validaCEP(cep)) {
                    alert('CEP inválido. Por favor, insira um CEP válido.'); // Alerta para CEP inválido
                    document.getElementById('cepError').style.display = 'inline'; // Exibe mensagem de erro
                    return false;
                }
                document.getElementById('cepError').style.display = 'none'; // Esconde a mensagem de erro se válido
                return true; // Retorna true se o CEP for válido
            }

            function formatCEP() {
                const cepInput = document.getElementById('cepDetentor');
                let cep = cepInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                if (cep.length <= 8) {
                    cep = cep.replace(/(\d{5})(\d)/, "$1-$2"); // 00000-00
                }

                cepInput.value = cep; // Atualiza o valor do campo
            }

            // Função para buscar o endereço pelo CEP
            function buscarEnderecoPorCEP(cep) {
                const url = `https://viacep.com.br/ws/${cep}/json/`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouroDetentor').value = data.logradouro;
                            document.getElementById('bairroDetentor').value = data.bairro;
                            document.getElementById('cidadeDetentor').value = data.localidade;
                            document.getElementById('estadoDetentor').value = data.uf;
                        } else {
                            alert('CEP não encontrado.'); // Alerta se o CEP não existir
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar o endereço:', error);
                        alert('Erro ao buscar o endereço.'); // Alerta em caso de erro
                    });
            }

            // Verifica e busca o endereço ao perder o foco no campo CEP
            document.getElementById('cepDetentor').addEventListener('blur', function() {
                const cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                formatCEP();
                if (validaCEP(cep)) {
                    buscarEnderecoPorCEP(cep);
                }
            });

            // Verifica o formulário antes de enviar
            function checkForm() {
                return checkCNPJ() && checkCEP();
            }
    </script>
@include('includes.footer')