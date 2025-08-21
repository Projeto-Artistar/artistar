const ctx = document.getElementById('myChart').getContext('2d');
var myChart
function atualizarGrafico(data, real = false) {
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    var data = {
        labels: labels,
        datasets: [{
            data: data,
            fill: true,
            borderColor: '#8B84D7',
            backgroundColor: 'rgba(139, 132, 215, 0.2)',
        }]
    };
    var config = {
        type: 'line',
        data: data,
        options: {
            legend: {
                display: false
            },
        }
    };
    if (real) {
        config.options.tooltips = {
            callbacks: {
                label: function(tooltipItem, data) {
                    return tooltipItem.yLabel.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                }
            }
        };
        config.options.scales = {
            yAxes: [{
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    }
                }
            }]
        };
    } else {
        // ticks 1
        config.options.scales = {
            yAxes: [{
                ticks: {
                    stepSize: 1
                }
            }]
        };
    }
    return new Chart(ctx, config);
}

document.addEventListener("DOMContentLoaded", function() {
    myChart = atualizarGrafico(totalVendas, true);
});

$('#graphByValue').on('click', function() {
    myChart.destroy();
    myChart = atualizarGrafico(totalVendas, true);
});

$('#graphByQuantity').on('click', function() {
    myChart.destroy();
    myChart = atualizarGrafico(totalTransacoes, false);
});

const slider = document.getElementById("slider");
const buttons = document.querySelectorAll("#toggle>.toggle-btn");

buttons.forEach(btn => {
    btn.addEventListener("click", () => {
        var side = btn.getAttribute("data-side");

        buttons.forEach(b => b.classList.remove("active", "text-white", "text-dark"));

        if (side === "left") {
            slider.classList.remove("right");
            slider.classList.add("left");
            btn.classList.add("active", "text-white");
            buttons[1].classList.add("text-dark");
        } else {
            slider.classList.remove("left");
            slider.classList.add("right");
            btn.classList.add("active", "text-white");
            buttons[0].classList.add("text-dark");
        }
    });
});

const sliderContainer = document.getElementById("slider-product-order");
const buttonsProduct = document.querySelectorAll("#toggle-product-order>.toggle-btn");

buttonsProduct.forEach(btn => {
    btn.addEventListener("click", () => {
        var side = btn.getAttribute("data-side");

        buttonsProduct.forEach(b => b.classList.remove("active", "text-white", "text-dark"));

        if (side === "left") {
            sliderContainer.classList.remove("right");
            sliderContainer.classList.add("left");
            btn.classList.add("active", "text-white");
            buttonsProduct[1].classList.add("text-dark");
        } else {
            sliderContainer.classList.remove("left");
            sliderContainer.classList.add("right");
            btn.classList.add("active", "text-white");
            buttonsProduct[0].classList.add("text-dark");
        }
    });
});

$('#productsByRevenue').on('click', function() {
    //Reorder the table based on revenue
    //The Revenue is a data-revenue attribute
    const rows = Array.from(document.querySelectorAll('#productsTable tbody tr'));
    rows.sort((a, b) => {
        const aRevenue = parseFloat(a.getAttribute('data-revenue'));
        const bRevenue = parseFloat(b.getAttribute('data-revenue'));
        return bRevenue - aRevenue;
    });

    rows.forEach((row, index) => {
        let id = row.getAttribute('data-product');
        $('#position-' + id).text('#' + (index + 1));
        document.querySelector('#productsTable tbody').appendChild(row);
    });
});

$('#productsByQuantity').on('click', function() {
    //Reorder the table based on quantity
    const rows = Array.from(document.querySelectorAll('#productsTable tbody tr'));
    rows.sort((a, b) => {
        const aQuantity = parseInt(a.getAttribute('data-quantity'));
        const bQuantity = parseInt(b.getAttribute('data-quantity'));
        return bQuantity - aQuantity;
    });
    rows.forEach((row, index) => {
        let id = row.getAttribute('data-product');
        $('#position-' + id).text('#' + (index + 1));
        document.querySelector('#productsTable tbody').appendChild(row);
    });
});

var colors = [
    {
        color: 'rgba(255, 99, 132, 1)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)'
    },
    {
        color: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)'
    },
    {
        color: 'rgba(255, 206, 86, 1)',
        backgroundColor: 'rgba(255, 206, 86, 0.2)'
    },
    {
        color: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)'
    },
    {
        color: 'rgba(153, 102, 255, 1)',
        backgroundColor: 'rgba(153, 102, 255, 0.2)'
    },
    {
        color: 'rgba(255, 159, 64, 1)',
        backgroundColor: 'rgba(255, 159, 64, 0.2)'
    }
];

for (const [key, graph] of Object.entries(customGraphs)) {
    let datasets = [];
    const graphLabel = document.getElementById(`graph-label-${graph.id}`);
    if (graphLabel) graphLabel.textContent = graph.name;
    switch (graph.type) {
        case 'pie':
            new Chart(document.getElementById(`grafico-0${graph.id}`).getContext('2d'), {
                type: 'pie',
                data: {
                    labels: graph.data.map(item => item.nome),
                    datasets: [{
                        label: graph.data.map(item => item.nome),
                        data: graph.data.map(item => item.total),
                        borderColor: graph.data.map((item, index) => colors[index % colors.length].color),
                        backgroundColor: graph.data.map((item, index) => colors[index % colors.length].backgroundColor)
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'bottom'
                    },
                    tooltips: {
                       callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var valor = dataset.data[tooltipItem.index];
                                valor = parseFloat(valor);

                                var total = data.datasets[tooltipItem.datasetIndex].data;

                                var total = data.datasets[tooltipItem.datasetIndex].data.reduce(function(prev, curr) {
                                    return parseFloat(prev) + parseFloat(curr);
                                });

                                var percentual = ((valor / total) * 100).toFixed(2) + '%';
                                if (graph.real) {

                                    var valorFormatado = valor.toLocaleString('pt-BR', {
                                        style: 'currency',
                                        currency: 'BRL'
                                    });
                                } else {
                                    var valorFormatado = valor.toString();
                                }

                                return data.labels[tooltipItem.index] + ': ' + valorFormatado + ' (' + percentual + ')';
                            }
                        }
                    },
                }
            });
            break;
        case 'bar':
            graph.data.forEach((item, index) => {
                datasets.push({
                    label: item.nome,
                    data: [item.total],
                    backgroundColor: colors[index % colors.length].backgroundColor,
                    borderColor: colors[index % colors.length].color,
                    borderWidth: 1
                });
            });
            new Chart(document.getElementById(`grafico-0${graph.id}`).getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Itens'],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    title: {
                        display: false
                    },
                    legend: {
                        position: 'bottom' 
                    },
                    tooltips: {
                       callbacks: {
                            label: function(tooltipItem, data) {
                                if (graph.real) {
                                    return tooltipItem.yLabel.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                                } else {
                                    return tooltipItem.yLabel;
                                }
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function(value) {
                                    if (graph.real) {
                                        return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                                    } else {
                                        return value;
                                    }
                                },
                                precision: (!graph.real) ? 0 : undefined,
                            }
                        }]
                    }
                }
            });
            break;
        case 'line':
            graph.data.forEach((item, index) => {
                datasets.push({
                    label: item.label,
                    data: item.data,
                    backgroundColor: colors[index % colors.length].backgroundColor,
                    borderColor: colors[index % colors.length].color,
                    borderWidth: 1
                });
            });
            new Chart(document.getElementById(`grafico-0${graph.id}`).getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    title: {
                        display: false
                    },
                    legend: {
                        position: 'bottom' 
                    },
                    tooltips: {
                       callbacks: {
                            label: function(tooltipItem, data) {
                                if (graph.real) {
                                    return tooltipItem.yLabel.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                                } else {
                                    return tooltipItem.yLabel;
                                }
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function(value) {
                                    if (graph.real) {
                                        return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                                    } else {
                                        return value;
                                    }
                                },
                                precision: (!graph.real) ? 0 : undefined
                            }
                        }]
                    }
                }
            });
            break;
        default:
            console.log(`Unknown chart type for ${graph.name}`);
    }
}



$('[data-modal-label]').on('click', function() {
    var modalLabel = $(this).data('modal-label') + ' - '+customGraphs[$(this).data('graph-id')].name;
    $('#editGraphModalLabel').text(modalLabel);
    $('#graph-id').val($(this).data('graph-id'));
    var graphBase = customGraphs[$(this).data('graph-id')].base;
    $('#graph-type').val(graphBase.grafico_tipo).trigger('change');
    $('#graph-counter').val(graphBase.grafico_contador).trigger('change');
    $('#graph-target').val(graphBase.grafico_alvo).trigger('change');
    $('#graph-filter').val(graphBase.grafico_filtro).trigger('change');

    if (graphBase.grafico_alvo === 'category') {
        $('#graph-category').val(graphBase.grafico_lista.split(',')).trigger('change');
    } else if (graphBase.grafico_alvo === 'product') {
        $('#graph-products').val(graphBase.grafico_lista.split(',')).trigger('change');
    }

});

$(document).ready(function() {
    $('#graph-category').select2({
        placeholder: "Selecione uma ou mais categorias",
        allowClear: true,
        dropdownParent: $('#editGraphModal'),
        width: '100%',
        language: {
            noResults: function() {
                return "Nenhuma categoria encontrada";
            }
        }
    });

    $('#graph-products').select2({
        placeholder: "Selecione uma ou mais produtos",
        allowClear: true,
        dropdownParent: $('#editGraphModal'),
        width: '100%',
        language: {
            noResults: function() {
                return "Nenhum produto encontrado";
            }
        }
    });

    $('#editGraphModal').on('shown.bs.modal', function () {
        $('#graph-category').select2({
            placeholder: "Selecione uma ou mais categorias",
            allowClear: true,
            dropdownParent: $('#editGraphModal'),
            width: '100%',
            language: {
                noResults: function() {
                    return "Nenhuma categoria encontrada";
                }
            }
        });

        $('#graph-products').select2({
            placeholder: "Selecione uma ou mais produtos",
            allowClear: true,
            dropdownParent: $('#editGraphModal'),
            width: '100%',
            language: {
                noResults: function() {
                    return "Nenhum produto encontrado";
                }
            }
        });
    });

});

function atualizaListaPersonalizada() {
    $('#graph-category-container').hide();
    $('#graph-products-container').hide();
    if ($('#graph-filter').val() === 'custom') {
        if ($('#graph-target').val() === 'category') {
            $('#graph-category-container').show();
        } else if ($('#graph-target').val() === 'product') {
            $('#graph-products-container').show();
        }
    }
}

//If graph-target is "category", stop showing the "all_option" and "top_10_option" and select the "custom_option"
$('#graph-target').on('change', function() {
    switch($(this).val()) {
        case 'product':
            $('#all_option').show();
            $('#top_10_option').show();
            $('#custom_option').show();
            break;
        case 'category':
            $('#all_option').hide();
            $('#top_10_option').hide();
            $('#custom_option').show();
            $('#custom_option').prop('selected', true);
            break;
        case 'payment_method':
            $('#all_option').show();
            $('#top_10_option').hide();
            $('#custom_option').hide();
            $('#all_option').prop('selected', true);
            break;
        default:
            alert("Opção inválida");

    }
    atualizaListaPersonalizada();
});


$('#graph-filter').on('change', function() {
    atualizaListaPersonalizada();
});

$(document).on('click', '#edit-graph-btn', function() {

    var form = $('#form-edit-graph')[0];
    var formData = new FormData(form);

    $.ajax({
        url: '/statistics/edit-graph',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false
    }).done(function (response) {
        response = JSON.parse(response);
        if (response.code == 200) {
            location.href = $('#form-edit-graph').attr('action'); // Redireciona para a ação do formulário
        } else {
            console.error('Erro ao editar o gráfico:', response.message);
        }
    }).fail(function (error) {
        console.error('An error occurred:', error);
    });
});
