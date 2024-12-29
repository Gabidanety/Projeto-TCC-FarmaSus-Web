<!--CSS finalizado OK (ASS:Duda-->
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
        <h1 style="font-weight: bold;"> Editar Farmácia </h1>
    </div>
</div>

<main>
    @if (session('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('farmacia.update', $farmacia->idFarmaciaUBS) }}" method="POST" class="formulario">
        @csrf
        <!-- Usando o campo _method para simular o método PUT -->
        <input type="hidden" name="_method" value="POST"> <!-- Corrigido para POST -->
        <div class="form-group">
            <label for="nomeFamaciaUBS">Nome da Farmácia</label>
            <input type="text" class="form-control" id="nomeFamaciaUBS" name="nomeFarmaciaUBS" value="{{ $farmacia->nomeFarmaciaUBS }}" required>
        </div>
        <div class="form-group">
            <label for="emailFamaciaUBS">Email</label>
            <input type="email" class="form-control" id="emailFamaciaUBS" name="emailFarmaciaUBS" value="{{ $farmacia->emailFarmaciaUBS }}" required>
        </div>
        <div class="form-group">
            <label for="tipoFamaciaUBS">Tipo da Farmácia</label>
            <input type="text" class="form-control" id="tipoFamaciaUBS" name="tipoFarmaciaUBS" value="{{ $farmacia->tipoFarmaciaUBS }}">
        </div>
        <button type="submit" class="botaozinho">Atualizar</button>
    </form>
</main>
    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.transition = "opacity 1s ease-out";
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.remove();
                }, 1000);
            }
        }, 6000);
    </script>

@include('includes.footer')