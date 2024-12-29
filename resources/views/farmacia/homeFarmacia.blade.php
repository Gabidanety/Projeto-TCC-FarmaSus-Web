<!--CSS OK, SEM BACK-END (ASS: DUDA)-->

@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/DashboardFarmacia.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>

    <div class="welcome-message">
        <p><i class="fas fa-store"></i> Bem-vinda, <span class="farmacia-name">Farmácia</span>!</p> <!--AQUI VEM O BACK PUXANDO O NOME DO LOGIN (ASS: DUDA)-->
    </div>
</div>


<main>
    @if (session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="stats-cards">
        <div class="card">
            <h3>Medicamentos no Estoque</h3>
            <i class="fas fa-box-open fa-3x"></i>
            <a href="/estoqueHome" class="btn btn-info">Ver Estoque</a>
        </div>
        <div class="card">
            <h3>Entradas de Medicamentos</h3>
            <i class="fas fa-arrow-down fa-3x"></i>
            <a href="/EntradaMedicamentoHome" class="btn btn-info ">Ver Entradas</a>
        </div>
        <div class="card">
            <h3>Saídas de Medicamentos</h3>
            <i class="fas fa-arrow-up fa-3x"></i>
            <a href="/saidaLista" class="btn btn-info">Ver Saídas</a>
        </div>
        <div class="card">
            <h3>Tipos de Movimentação</h3>
            <i class="fas fa-cogs fa-3x"></i>
            <a href="/entrada_medicamento" class="btn btn-info">Ver Tipos</a>
        </div>
    </div>

    <!-- aqui vem back-end -->
    <div class="indicators-summary">
        <h2>Resumo de Indicadores Principais</h2>
        <div class="indicator-cards">
            <div class="indicator-card">
                <h4>Número Total de Medicamentos</h4>
                <span id="totalMedicamentos" class="indicator-value">{{ $totalMedicamentos }}</span>
            </div>
            <div class="indicator-card">
                <h4>Total de Saídas</h4>
                <span id="taxaConsumoSemanal" class="indicator-value">{{ $totalSaidas }}</span>
            </div>
            <div class="indicator-card">
                <h4>Medicamentos em Baixa</h4>
                <span id="medicamentosBaixa" class="indicator-value">{{ $medicamentosEmBaixa }}</span>
            </div>
            <div class="indicator-card">
                <h4>Última Movimentação</h4>
                <span id="ultimaMovimentacao" class="indicator-value">
                    {{ $ultimaMovimentacaoData ? $ultimaMovimentacaoData->format('d/m/Y') . ' - ' . $ultimaMovimentacaoTipo : 'Sem movimentação' }}
                </span> <!-- valor dinâmico -->
            </div>
        </div>
    </div>

    <!-- aqui vem back-end -->
    <div class="recent-activities">
        <img src="{{ asset('Image/verdeAdm (1).png')}}" alt="Imagem representativa" class="activity-section-image">
        <div class="content">
            <h2>Atividades Recentes</h2>
            <ul class="recent-activities-list">
                @foreach($atividadesRecentes as $atividade)
                <li>
                    <span class="activity-date">{{ $atividade['data'] }}</span>
                    <span class="activity-desc">{{ $atividade['descricao'] }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>


    <!-- aqui vem back-end -->
    <div class="charts-container">
    <div class="chart">
        <h3>Movimentação de Estoque (Entradas e Saídas)</h3>
        <canvas id="inventoryMovementChart"></canvas>
    </div>
    <div class="chart">
        <h3>Medicamentos Ativos e Inativos</h3>
        <canvas id="activeInactiveChart"></canvas>
    </div>
</div>

    <div class="quick-actions">
        <h3>Ações Rápidas</h3>
        <ul>
            <li><a href="/EntradaMedicamentoHome">Registrar Entrada de Medicamento</a></li>
            <li><a href="/saidaLista">Registrar Saída de Medicamento</a></li>
            <li><a href="/estoqueHome">Verificar Estoque</a></li>
            <li><a href="/MedicamentoHome">Adicionar Novo Medicamento</a></li>
        </ul>
    </div>

    <br>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        // Dados do backend (você enviará esses dados via Blade ou API)
        const datas = @json($datas);
        // const quantidadeEntradas = @json($quantidadeEntradas);
        // const quantidadeSaidas = @json($quantidadeSaidas);
        const quantidadeEntradas = [7, 3, 10,15];
        const quantidadeSaidas = [5, 9, 7,11];
        const ativos = @json($ativos);
        const inativos = @json($inativos);


const inventoryMovementData = {

    labels: datas, // Datas únicas no formato 'd/m/Y'
    datasets: [
        {
            label: 'Entradas',
            data: quantidadeEntradas, // Quantidades de entradas
            backgroundColor: 'rgba(76, 175, 80, 0.5)',
            borderColor: 'rgba(76, 175, 80, 1)',
            borderWidth: 1
        },
        {
            label: 'Saídas',
            data: quantidadeSaidas, // Quantidades de saídas
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }
    ]
};

const inventoryMovementConfig = {
    type: 'bar', // Gráfico de barras
    data: inventoryMovementData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'Movimentação de Estoque (Entradas e Saídas)'
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Datas'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Quantidade'
                },
                beginAtZero: true
            }
        }
    }
};

        // Configuração do Gráfico de Status de Medicamentos
        const activeInactiveData = {
            labels: ['Ativos', 'Inativos'], // Medicamentos ativos/inativos
            datasets: [
                {
                    label: 'Medicamentos',
                    data: [ativos, inativos], // Quantidades de ativos/inativos
                    backgroundColor: [
                        'rgba(76, 175, 80, 0.7)', // Ativos
                        'rgba(255, 99, 132, 0.7)' // Inativos
                    ],
                    borderColor: [
                        'rgba(76, 175, 80, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }
            ]
        };

        const activeInactiveConfig = {
            type: 'doughnut', // Gráfico do tipo rosquinha
            data: activeInactiveData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Status dos Medicamentos (Ativos/Inativos)'
                    }
                }
            }
        };

        // Renderizar os gráficos
        const inventoryMovementChart = new Chart(
            document.getElementById('inventoryMovementChart'),
            inventoryMovementConfig
        );

        const activeInactiveChart = new Chart(
            document.getElementById('activeInactiveChart'),
            activeInactiveConfig
        );
    </script>