<!--CSS OK, ASS:DUDA-->
@include('includes.header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Adm-CSS/DashboardAdm.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
    
    <div class="welcome-message">
        <p><i class="fas fa-user-shield"></i> Bem-vindo, <span class="farmacia-name">Administrador</span>!</p> <!--AQUI VEM O BACK PUXANDO O NOME DO LOGIN (ASS: DUDA)-->
    </div>
</div>

@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

<div class="stats-cards">
    <div class="card">
        <h3>Unidades de Saúde (UBS)</h3>
        <i class="fas fa-hospital fa-3x"></i>
        <a href="/selectUBS" class="btn btn-info">Ver UBS</a> 
    </div>
    <div class="card">
        <h3>Gestão de Pacientes</h3>
        <i class="fas fa-users fa-3x"></i>
        <a href="/cliente" class="btn btn-info">Ver Pacientes</a> 
    </div>
    <div class="card">
        <h3>Detentores de Medicamentos</h3>
        <i class="fas fa-user-tag fa-3x"></i>
        <a href="/detentor" class="btn btn-info">Ver Detentores</a>
    </div>
    <div class="card">
        <h3>Medicamentos</h3>
        <i class="fas fa-capsules fa-3x"></i>
        <a href="/medicamento" class="btn btn-info">Ver Medicamentos</a>
    </div>
</div>

<main>
    <div class="card-atividades"> <!--aqui vai back-end-->
        <h3>Últimas Atividades</h3>
        <i class="fas fa-history fa-3x"></i>
        <ul>
        @foreach ($atividades as $atividade)
            <li>{{ $atividade }}</li>
        @endforeach
        </ul>
    </div>

    <div class="container-graficos">
        <div class="row">
            <!-- Gráfico de Pacientes Cadastrados -->
            <div class="col-md-6">
                <h4>Pacientes Cadastrados</h4>
                <canvas id="patientsChart" width="400" height="200"></canvas>
            </div>

            <!-- Gráfico de UBS Cadastradas -->
            <div class="col-md-6">
                <h4>UBS Cadastradas</h4>
                <canvas id="ubsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <h3>Ações Rápidas</h3>
        <ul>
            <li><a href="/selectUBS">Registrar UBS</a></li>
            <li><a href="/detentor">Verificar Detentores</a></li>
            <li><a href="/medicamentoForm">Adicionar Novo Medicamento</a></li>
        </ul>
    </div>
</main>
<br>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Pacientes Cadastrados
    var ctx1 = document.getElementById('patientsChart').getContext('2d');
    var patientsChart = new Chart(ctx1, {
        type: 'bar',  // Tipo de gráfico: barra
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                label: 'Pacientes Cadastrados',
                data: [120, 150, 170, 180, 220, 250, 270, 300, 320, 340, 360, 400],  // Dados estáticos
                backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Cor de fundo das barras
                borderColor: 'rgba(75, 192, 192, 1)',  // Cor da borda
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50
                    }
                }
            }
        }
    });

    // Gráfico de UBS Cadastradas
    var ctx2 = document.getElementById('ubsChart').getContext('2d');
    var ubsChart = new Chart(ctx2, {
        type: 'line',  // Tipo de gráfico: linha
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                label: 'UBS Cadastradas',
                data: [10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 35],  // Dados estáticos
                fill: false,
                borderColor: 'rgba(153, 102, 255, 1)',  // Cor da linha
                tension: 0.1,  // Suavização da linha
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 2
                    }
                }
            }
        }
    });
</script>

