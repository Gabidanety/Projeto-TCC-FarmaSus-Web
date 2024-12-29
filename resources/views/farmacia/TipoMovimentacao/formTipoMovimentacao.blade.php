<!--CSS OK, COM BACK-END (ASS:DUDA)-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/EditarMovimentacao.css') }}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1>Cadastrar Tipo de Movimentação</h1>
        <p>Atualize os dados da movimentação.</p>
    </div>
</div>

<main>
    <form action="{{ route('tipomovimentacao.store') }}" method="POST" class="formulario" style="margin-top: 2%;">
        @csrf
        
        <div class="input-container">
            <label for="movimentacao">
                <i class="fas fa-info-circle icon"></i>
                Movimentação:
            </label>
            <input type="text" name="movimentacao" id="movimentacao" class="form-control" required maxlength="50" placeholder="Digite o tipo de movimentação" style="background-color: #F7F7F7;">
        </div>

        <div class="input-container">
            <label for="idPrescricao">
                <i class="fas fa-info-circle icon"></i>
                ID Prescrição:
            </label>
            <input type="number" name="idPrescricao" id="idPrescricao" class="form-control" required placeholder="Digite o ID da prescrição" style="background-color: #F7F7F7;">
        </div>

        <button type="submit" class="botaozinho" style="margin-top: 2%;">Salvar</button>
    </form>
</main>

@include('includes.footer')
