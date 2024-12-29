<!-- CSS OK, (ASS:DUDA)-->
@include('includes.headerFarmacia') 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css/Farmacia-CSS/EditarMovimentacao.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1>Cadastrar Funcionário</h1>
        <p>cadastre um novo funcionário.</p>
    </div>
</div>

<main>
    <form action="{{ route('insertFuncionario') }}" method="POST" class="formulario">
        @csrf <!-- Proteção contra CSRF vini -->
        <div class="input-container">
            <label for="nomeFuncionario">
                <i class="fas fa-info-circle icon"></i>
                Nome Funcionario:
            </label>
            <input type="text" name="nomeFuncionario" id="nomeFuncionario" placeholder="Digite o nome do funcionário" style="background-color: #F7F7F7;">
        </div>
        <div class="input-container">
            <label for="cpfFuncionario">
                <i class="fas fa-info-circle icon"></i> 
                cpf Funcionario :
            </label>
            <input type="text" name="cpfFuncionario" id="cpfFuncionario" placeholder="Digite o cpf do funcionário" style="background-color: #F7F7F7;">
        </div>
        <div class="input-container">
            <label for="cargoFuncionario">
                <i class="fas fa-info-circle icon"></i> 
                Cargo Funcionario :
            </label>
            <input type="text" name="cargoFuncionario" id="cargoFuncionario" placeholder="Digite o cargo do funcionário" style="background-color: #F7F7F7;">
        </div>
        <button type="submit" class="botaozinho">Cadastrar Funcionário</button>
    </form>
</main>



