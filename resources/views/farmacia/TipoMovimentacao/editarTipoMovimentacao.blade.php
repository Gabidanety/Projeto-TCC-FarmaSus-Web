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
        <h1>Editar Tipo de Movimentação</h1>
        <p>Atualize os dados da movimentação.</p>
    </div>
</div>

<main>
    <form action="{{ route('atualizarTipoMovimentacao', $movimentacao->idTipoMovimentacao) }}" method="POST" class="formulario">
        @csrf
            @method('PUT') 
        
        <div class="input-container">
            <label for="movimentacao">
                <i class="fas fa-info-circle icon"></i>
                Movimentação:
            </label>
            <input type="text" name="movimentacao" id="movimentacao" value="{{ old('movimentacao', $movimentacao->movimentacao) }}" placeholder="Digite o nome da movimentação" style="background-color: #F7F7F7;" required>
        </div>

        <div class="input-container">
            <label for="situacaoTipoMovimentacao">
                <i class="fas fa-info-circle icon"></i> 
                Situação:
            </label>
            <input type="number" name="situacaoTipoMovimentacao" id="situacaoTipoMovimentacao" value="{{ old('situacaoTipoMovimentacao', $movimentacao->situacaoTipoMovimentacao) }}" placeholder="Digite a situação da movimentação" style="background-color: #F7F7F7;" required>
        </div>

        <div class="input-container">
            <label for="dataCadastroTipoMovimentacao">
                <i class="fas fa-calendar-alt icon"></i> 
                Data de Cadastro:
            </label>
            <input type="date" name="dataCadastroTipoMovimentacao" id="dataCadastroTipoMovimentacao" value="{{ old('dataCadastroTipoMovimentacao', $movimentacao->dataCadastroTipoMovimentacao) }}" style="background-color: #F7F7F7;" required>
        </div>

        <div class="input-container">
            <label for="idPrescricao">
                <i class="fas fa-info-circle icon"></i> 
                ID Prescrição:
            </label>
            <input type="number" name="idPrescricao" id="idPrescricao" value="{{ old('idPrescricao', $movimentacao->idPrescricao) }}" placeholder="Digite o ID da prescrição" style="background-color: #F7F7F7;" required>
        </div>
        <button type="submit" class="botaozinho">Salvar Alterações</button>
    </form>
</main>
<br>
@include('includes.footer')
