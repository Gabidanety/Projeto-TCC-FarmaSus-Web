<!--CSS finalizado OK (ASS:Duda-->
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
        <h1 style="font-weight: bold;"> Editar UBS </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/AdmTrabalhandoSemFundo.png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>


<main>
<div class="form-wrapper">
    <form action="{{ route('ubs.update', $ubs->idUBS) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table class="dashboard-table">
            <thead>
                <tr>
                    <th colspan="2">Edição da UBS</th>
                </tr>
            </thead>
            <tbody>
                <!-- Nome UBS -->
                <tr>
                    <td><label for="nomeUBS">Nome UBS:</label></td>
                    <td><input type="text" class="form-control" id="nomeUBS" name="nomeUBS" value="{{ old('nomeUBS', $ubs->nomeUBS) }}" required></td>
                </tr>

                <!-- E-mail -->
                <tr>
                    <td><label for="emailUBS">E-mail:</label></td>
                    <td><input type="email" class="form-control" id="emailUBS" name="emailUBS" value="{{ old('emailUBS', $ubs->emailUBS) }}" required></td>
                </tr>

                <!-- CNPJ -->
                <tr>
                    <td><label for="cnpjUBS">CNPJ:</label></td>
                    <td><input type="text" class="form-control" id="cnpjUBS" name="cnpjUBS" value="{{ old('cnpjUBS', $ubs->cnpjUBS) }}" required></td>
                </tr>

                <!-- CEP -->
                <tr>
                    <td><label for="cepUBS">CEP:</label></td>
                    <td><input type="text" class="form-control" id="cepUBS" name="cepUBS" value="{{ old('cepUBS', $ubs->cepUBS) }}" required onblur="buscaCep()"></td>
                </tr>

                <!-- Logradouro -->
                <tr>
                    <td><label for="logradouroUBS">Logradouro:</label></td>
                    <td><input type="text" class="form-control" id="logradouroUBS" name="logradouroUBS" value="{{ old('logradouroUBS', $ubs->logradouroUBS) }}" required></td>
                </tr>

                <!-- Bairro -->
                <tr>
                    <td><label for="bairroUBS">Bairro:</label></td>
                    <td><input type="text" class="form-control" id="bairroUBS" name="bairroUBS" value="{{ old('bairroUBS', $ubs->bairroUBS) }}" required></td>
                </tr>

                <!-- Cidade -->
                <tr>
                    <td><label for="cidadeUBS">Cidade:</label></td>
                    <td><input type="text" class="form-control" id="cidadeUBS" name="cidadeUBS" value="{{ old('cidadeUBS', $ubs->cidadeUBS) }}" required></td>
                </tr>

                <!-- Estado -->
                <tr>
                    <td><label for="estadoUBS">Estado:</label></td>
                    <td><input type="text" class="form-control" id="estadoUBS" name="estadoUBS" value="{{ old('estadoUBS', $ubs->estadoUBS) }}" required></td>
                </tr>

                <!-- Região -->
                <tr>
                    <td><label for="idRegiao">Região:</label></td>
                    <td>
                        <select class="form-control" id="idRegiao" name="idRegiao" required>
                            <option value="">Selecione a Região</option>
                            @foreach($regioes as $r)
                                <option value="{{ $r->idRegiaoUBS }}" {{ old('idRegiao', $ubs->idRegiaoUBS) == $r->idRegiaoUBS ? 'selected' : '' }}>{{ $r->nomeRegiaoUBS }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <!-- Complemento -->
                <tr>
                    <td><label for="complementoUBS">Complemento:</label></td>
                    <td><input type="text" class="form-control" id="complementoUBS" name="complementoUBS" value="{{ old('complementoUBS', $ubs->complementoUBS) }}"></td>
                </tr>

                <!-- Latitude -->
                <tr>
                    <td><label for="latitudeUBS">Latitude:</label></td>
                    <td><input type="text" class="form-control" id="latitudeUBS" name="latitudeUBS" value="{{ old('latitudeUBS', $ubs->latitudeUBS) }}" required readonly></td>
                </tr>

                <!-- Longitude -->
                <tr>
                    <td><label for="longitudeUBS">Longitude:</label></td>
                    <td><input type="text" class="form-control" id="longitudeUBS" name="longitudeUBS" value="{{ old('longitudeUBS', $ubs->longitudeUBS) }}" required readonly></td>
                </tr>

                <!-- Telefone -->
                <tr>
                    <td><label for="telefone">Telefone:</label></td>
                    <td><input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $telefone->numeroTelefoneUBS ?? '') }}" required></td>
                </tr>

                <!-- Telefone 2 -->
                <tr>
                    <td><label for="telefone2">Telefone 2:</label></td>
                    <td><input type="text" class="form-control" id="telefone2" name="telefone2" value="{{ old('telefone2', $telefone->numeroTelefoneUBS2 ?? '') }}"></td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="submit-btn"> Atualizar</button>
    </form>
</div>
</main>
<br>
    <script>
        function buscaCep() {
            const cep = document.getElementById('cepUBS').value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            // Preencher os campos de endereço
                            document.getElementById('logradouroUBS').value = data.logradouro;
                            document.getElementById('bairroUBS').value = data.bairro;
                            document.getElementById('cidadeUBS').value = data.localidade;
                            document.getElementById('ufUBS').value = data.uf;

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
                        document.getElementById('latitudeUBS').value = location.lat;
                        document.getElementById('longitudeUBS').value = location.lon;
                    } else {
                        alert('Não foi possível obter a latitude e longitude.');
                    }
                })
                .catch(() => alert('Erro ao buscar a latitude e longitude.'));
        }
    </script>

@include('includes.footer') <!-- include -->