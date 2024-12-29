<!--CSS OK por aqui (ASS:Duda)-->

@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/Formularios.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Cadastrar Tipo Medicamento </h1>
    </div>
</div>

<main>
    <form action="/TipoMedicamento" method="POST" class="formulario">
        @csrf
            <div class="input-container">
                <label for="tipoMedicamento">Tipo de Medicamento</label>
                <input type="text" class="form-control" id="tipoMedicamento" name="tipo" 
                    value="{{ old('tipo') }}" required>
            </div>
            <div class="input-container">
                <label for="formaMedicamento">Forma Farmacêutica:</label>
                <select class="form-control" id="formaMedicamento" name="forma" required>
                    <option value="">=</option>
                    <option value="Comprimido" {{ old('forma') == 'Comprimido' ? 'selected' : '' }}>Comprimido</option>
                    <option value="Cápsula" {{ old('forma') == 'Cápsula' ? 'selected' : '' }}>Cápsula</option>
                    <option value="Pomada" {{ old('forma') == 'Pomada' ? 'selected' : '' }}>Pomada</option>
                    <option value="Solução" {{ old('forma') == 'Solução' ? 'selected' : '' }}>Solução</option>
                    <option value="Suspensão" {{ old('forma') == 'Suspensão' ? 'selected' : '' }}>Suspensão</option>
                    <option value="Creme" {{ old('forma') == 'Creme' ? 'selected' : '' }}>Creme</option>
                    <option value="Gel" {{ old('forma') == 'Gel' ? 'selected' : '' }}>Gel</option>
                    <option value="Injeção" {{ old('forma') == 'Injeção' ? 'selected' : '' }}>Injeção</option>
                </select>
            </div>
        <button type="submit" class="botaozinho">Salvar</button>
    </form>
</main>

@include('includes.footer')