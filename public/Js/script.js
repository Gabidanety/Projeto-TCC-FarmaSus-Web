// Configuração do gráfico de acesso
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        datasets: [{
            label: 'Acessos ao BuscaSUS',
            data: [10, 10, 20, 25, 30, 27],
            borderColor: '#14213D',
            borderWidth: 4,
            fill: false,
        }]
    },
    options: {
        responsive: true,
    }
});

/*AVALIAÇÃO DO APP*/
var ctx = document.getElementById('ratingChart').getContext('2d');
var ratingChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['1 Estrela', '2 Estrelas', '3 Estrelas', '4 Estrelas', '5 Estrelas'],
        datasets: [{
            label: 'Número de Avaliações',
            data: [1, 3, 3, 19, 27], // Substitua pelos dados reais
            backgroundColor: [
        
                '#72D9FF',
                '#3DBDEC',
                '#3998FF',
                '#1F2B5B',
                '#14213D'
            ],
            borderColor: [
              
                '#72D9FF',
                '#3DBDEC',
                '#3998FF',
                '#1F2B5B',
                '#14213D'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

