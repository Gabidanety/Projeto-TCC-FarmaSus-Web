<!--CSS incluido aqui (ASS:Duda)-->
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
        <h1 style="font-weight: bold;"> Cadastrar Telefone </h1>
    </div>
</div>

<main>
    <form action="{{ route('insertTelefone') }}" method="POST" class="formulario">
        @csrf <!-- Proteção contra CSRF vini -->
        <div class="input-container">
            <label for="regiao">
                <i class="fas fa-map-marker-alt icon"></i>
                Número de Telefone:
            </label>
            <input type="text" name="telefone" id="telefone" placeholder="Digite o número" style="background-color: #F7F7F7;">
        </div>
        <div class="input-container">
            <label for="situacao">
                <i class="fas fa-info-circle icon"></i> 
                Situação :
            </label>
            <input type="text" name="situacao" id="situacao" placeholder="Digite a situação" style="background-color: #F7F7F7;">
        </div>
        <button type="submit" class="botaozinho">Cadastrar Telefone</button>
    </form>
</main>


