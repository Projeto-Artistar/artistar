const ctx = document.getElementById('myChart').getContext('2d');
var myChart
function atualizarGrafico(data, real = false) {
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    var data = {
        labels: labels,
        datasets: [{
            data: data,
            fill: false,
            borderColor: '#8B84D7',
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
