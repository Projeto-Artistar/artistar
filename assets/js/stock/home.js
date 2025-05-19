document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Estoque bom', 'Estoque baixo', 'Sem estoque', 'Estoque morto'],
            datasets: [{
                label: 'Produtos',
                data: [12, 19, 3, 5],
                backgroundColor: [
                    'rgba(25, 135, 84, 1)',
                    'rgba(255,193,7, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(108,117,125, 1)',
                    
                    
                ],
                borderColor: [
                    'rgba(25, 135, 84, 1)',
                    'rgba(255,193,7, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(108,117,125, 1)',
                    
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            responsive: true,
            legend: {
                display: false,
            },
            title: {
                display: false,
            }
        }
    });
});