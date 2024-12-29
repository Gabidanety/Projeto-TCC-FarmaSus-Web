<!--CSS finalizado OK (ASS:Duda-->

@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/FarmaciaAdm.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Farmácias </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/AdmTrabalhandoSemFundo.png') }}" alt="UBS" class="img-fluid">
    </div>
</div>

<div class="cadastros-container">
    <h3><i class='bx bx-plus-circle' style="margin-right: 6px;"></i> Cadastrar </h3>
    <div class="cadastros-list">
        <div class="cadastro-item">
            <p>Cadastrar Farmácia</p> 
            <a href="/farmaciaForms" class="cadastrar-link">
                <i class="fas fa-plus"></i>
                <span class="status-busca"> Cadastrar </span>
            </a>
        </div>
    </div>
</div>

<br>

<main>

    @if (session('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h5 style="font-size: 30px; font-weight: bold;">Pesquisar Farmácia</h5>
                
                <form action="{{ url('/farmacia') }}" method="GET">
                    <div class="search-container2">
                        <input type="text" name="query" id="searchInput" placeholder="Pesquisar farmácia..." class="search-input2" value="{{ request('query') }}">
                        <button type="submit" class="search-button2"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="form-wrapper">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($farmacias->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">Nenhuma farmácia cadastrada.</td>
                            </tr>
                        @else
                            @foreach($farmacias as $farmaciaItem)
                                <tr>
                                    <td>{{ $farmaciaItem->nomeFarmaciaUBS }}</td>
                                    <td>{{ $farmaciaItem->emailFarmaciaUBS }}</td>
                                    <td>{{ $farmaciaItem->tipoFarmaciaUBS }}</td>
                                    <td>
                                        <a href="{{ route('farmacia.edit', $farmaciaItem->idFarmaciaUBS) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('farmacia.destroy', $farmaciaItem->idFarmaciaUBS) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta farmácia?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
    <script>
        // Mensagem de sucesso desaparecendo após alguns segundos
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