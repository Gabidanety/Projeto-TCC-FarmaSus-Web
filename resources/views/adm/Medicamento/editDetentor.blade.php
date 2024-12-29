<!-- AQUI VAI A PAGINA DESTINADA AS FUNCIONALIDADES DO DETENTOR -->
<!-- Essa página será para edição, portanto o formulário estará preenchido com os dados do detentor -->

<!--CSS OK (ASS:Duda-->
@include('includes.header') 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ url('css/Adm-CSS/Formularios.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Editar Detentores </h1>
    </div>
</div>

<main>
    <form action="{{ route('detentor.update', $detentor->idDetentor) }}" method="POST" class="formulario" style="margin-bottom: 2%;">
        @csrf
            @method('PUT')

            <div class="input-container">
                <label for="nomeDetentor">
                    <i class="fas fa-user icon"></i> 
                    Nome do Detentor :
                </label>
                <input type="text" id="nomeDetentor" name="nome" value="{{ $detentor->nomeDetentor }}" required>
            </div>

            <div class="input-container">
                <label for="cnpjDetentor">
                    <i class="fas fa-id-card icon"></i> CNPJ
                </label>
                <input type="text" id="cnpjDetentor" name="cnpj" value="{{ $detentor->cnpjDetentor }}" required>
            </div>

            <div class="input-container">
                <label for="emailDetentor">
                    <i class="fas fa-envelope icon"></i> Email
                </label>
                <input type="email" id="emailDetentor" name="email" value="{{ $detentor->emailDetentor }}" required>
            </div>

            <div class="input-container">
                <label for="logradouroDetentor">
                    <i class="fas fa-road icon"></i> Logradouro
                </label>
                <input type="text" id="logradouroDetentor" name="logradouro" value="{{ $detentor->logradouroDetentor }}" required>
            </div>

            <div class="input-container">
                <label for="bairroDetentor">
                    <i class="fas fa-map-marker-alt icon"></i> Bairro
                </label>
                <input type="text" id="bairroDetentor" name="bairro" value="{{ $detentor->bairroDetentor }}" required>
            </div>

            <div class="input-container">
                <label for="estadoDetentor">
                    <i class="fas fa-flag icon"></i> Estado
                </label>
                <input type="text" id="estadoDetentor" name="estado" value="{{ $detentor->estadoDetentor }}" required>
            </div>

            <div class="input-container">
                <label for="cidadeDetentor">
                    <i class="fas fa-city icon"></i> Cidade
                </label>
                <input type="text" id="cidadeDetentor" name="cidade" value="{{ $detentor->cidadeDetentor }}" required>
            </div>

            <div class="input-container">
                <label for="numeroDetentor">
                    <i class="fas fa-hashtag icon"></i> Número
                </label>
                <input type="text" id="numeroDetentor" name="numero" value="{{ $detentor->numeroDetentor }}" required>
            </div>

        <div class="input-conatiner">
            <label for="ufDetentor">
            <i class="fas fa-map icon"></i> UF
            </label>
            <select  id="ufDetentor" name="uf" required>
                <option value="">Selecione a UF</option>
                <option value="AC" {{ $detentor->ufDetentor == 'AC' ? 'selected' : '' }}>AC</option>
                <option value="AL" {{ $detentor->ufDetentor == 'AL' ? 'selected' : '' }}>AL</option>
                <option value="AP" {{ $detentor->ufDetentor == 'AP' ? 'selected' : '' }}>AP</option>
                <option value="AM" {{ $detentor->ufDetentor == 'AM' ? 'selected' : '' }}>AM</option>
                <option value="BA" {{ $detentor->ufDetentor == 'BA' ? 'selected' : '' }}>BA</option>
                <option value="CE" {{ $detentor->ufDetentor == 'CE' ? 'selected' : '' }}>CE</option>
                <option value="DF" {{ $detentor->ufDetentor == 'DF' ? 'selected' : '' }}>DF</option>
                <option value="ES" {{ $detentor->ufDetentor == 'ES' ? 'selected' : '' }}>ES</option>
                <option value="GO" {{ $detentor->ufDetentor == 'GO' ? 'selected' : '' }}>GO</option>
                <option value="MA" {{ $detentor->ufDetentor == 'MA' ? 'selected' : '' }}>MA</option>
                <option value="MT" {{ $detentor->ufDetentor == 'MT' ? 'selected' : '' }}>MT</option>
                <option value="MS" {{ $detentor->ufDetentor == 'MS' ? 'selected' : '' }}>MS</option>
                <option value="MG" {{ $detentor->ufDetentor == 'MG' ? 'selected' : '' }}>MG</option>
                <option value="PA" {{ $detentor->ufDetentor == 'PA' ? 'selected' : '' }}>PA</option>
                <option value="PB" {{ $detentor->ufDetentor == 'PB' ? 'selected' : '' }}>PB</option>
                <option value="PR" {{ $detentor->ufDetentor == 'PR' ? 'selected' : '' }}>PR</option>
                <option value="PE" {{ $detentor->ufDetentor == 'PE' ? 'selected' : '' }}>PE</option>
                <option value="PI" {{ $detentor->ufDetentor == 'PI' ? 'selected' : '' }}>PI</option>
                <option value="RJ" {{ $detentor->ufDetentor == 'RJ' ? 'selected' : '' }}>RJ</option>
                <option value="RN" {{ $detentor->ufDetentor == 'RN' ? 'selected' : '' }}>RN</option>
                <option value="RS" {{ $detentor->ufDetentor == 'RS' ? 'selected' : '' }}>RS</option>
                <option value="RO" {{ $detentor->ufDetentor == 'RO' ? 'selected' : '' }}>RO</option>
                <option value="RR" {{ $detentor->ufDetentor == 'RR' ? 'selected' : '' }}>RR</option>
                <option value="SC" {{ $detentor->ufDetentor == 'SC' ? 'selected' : '' }}>SC</option>
                <option value="SP" {{ $detentor->ufDetentor == 'SP' ? 'selected' : '' }}>SP</option>
                <option value="SE" {{ $detentor->ufDetentor == 'SE' ? 'selected' : '' }}>SE</option>
                <option value="TO" {{ $detentor->ufDetentor == 'TO' ? 'selected' : '' }}>TO</option>
            </select>
        </div>

        <div class="input-container">
            <label for="cepDetentor">
                <i class="fas fa-location-arrow icon"></i> CEP
            </label>
            <input type="text" id="cepDetentor" name="cep" value="{{ $detentor->cepDetentor }}" required>
        </div>

        <div class="input-container">
            <label for="complementoDetentor">
                <i class="fas fa-plus-circle icon"></i> Complemento
            </label>
            <input type="text" id="complementoDetentor" name="complemento" value="{{ $detentor->complementoDetentor }}">
        </div>

        <div class="input-container">
            <label for="situacaoDetentor">
                <i class="fas fa-check-circle icon"></i> Situação
            </label>
            <select id="situacaoDetentor" name="situacao" required>
                <option value="A" {{ $detentor->situacaoDetentor == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="D" {{ $detentor->situacaoDetentor == 'Inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
        <button type="submit" class="botaozinho">Salvar Alterações</button>
    </form>

</main>
