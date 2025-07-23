document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Estoque bom', 'Estoque baixo', 'Sem estoque', 'Estoque morto'],
            datasets: [{
                label: 'Produtos',
                data: [goodStock, lowStock, outOfStock, deadStock],
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
                        beginAtZero: true,
                        precision: 0
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

    $(document).ready(function() {
        $('#new-category').select2({
            tags: true,
            placeholder: "Selecione ou adicione uma nova categoria",
            allowClear: true,
            dropdownParent: $('#newModal'),
            language: {
                noResults: function() {
                    return "Adicione uma nova categoria";
                }
            }
        });
        $('#new-keywords').select2({
            tags: true,
            placeholder: "Selecione ou adicione uma nova palavra-chave",
            allowClear: true,
            dropdownParent: $('#newModal'),
            language: {
                noResults: function() {
                    return "Adicione uma nova palavra-chave";
                }
            }
        });

        $('#newModal').on('shown.bs.modal', function () {
            $('#new-category').select2({
                tags: true,
                placeholder: "Selecione ou adicione uma nova categoria",
                allowClear: true,
                dropdownParent: $('#newModal .modal-body'),
                language: {
                    noResults: function() {
                        return "Adicione uma nova categoria";
                    }
                }
            });
            $('#new-keywords').select2({
                tags: true,
                placeholder: "Selecione ou adicione uma nova palavra-chave",
                allowClear: true,
                dropdownParent: $('#newModal .modal-body'),
                language: {
                    noResults: function() {
                        return "Adicione uma nova palavra-chave";
                    }
                }
            });
        });

        $('.moedaReal').inputmask('decimal', {
            radixPoint:",",
            groupSeparator: ".",
            autoGroup: true,
            digits: 2,
            digitsOptional: false,
            placeholder: '0',
            rightAlign: false,
            onBeforeMask: function (value, opts) {
                return value;
            }
        });

        function calcularLucro() {
            let preco = $('#new-price').val();
            let desconto = $('#new-discount').val();
            let custo = $('#new-cost').val();

            // Remove apenas pontos de milhares e troca vírgula por ponto
            preco = preco ? parseFloat(preco.replace(/\./g, '').replace(',', '.')) : 0;
            desconto = desconto ? parseFloat(desconto.replace(/\./g, '').replace(',', '.')) : 0;
            custo = custo ? parseFloat(custo.replace(/\./g, '').replace(',', '.')) : 0;

            let lucro = preco - (custo + desconto);

            let lucroFormatado = lucro.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $('#new-profit').val(lucroFormatado);
        }

        $('#new-price, #new-discount, #new-cost').on('input keyup change', calcularLucro);
        $('#newModal').on('shown.bs.modal', calcularLucro);
    });

   $(function() {
    const $area = $('#image-drop-area');
    const $input = $('#new-image');
    const $text = $('#image-drop-text');

    $area.on('click', function(e) {
        e.stopPropagation();
        $input.trigger('click');
    });

    $area.on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $area.addClass('dragover');
    });

    $area.on('dragleave dragend', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $area.removeClass('dragover');
    });

    $area.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $area.removeClass('dragover');
        if (e.originalEvent.dataTransfer.files.length) {
            $input[0].files = e.originalEvent.dataTransfer.files;
            showPreview($input[0].files[0]);
        }
    });

    $input.on('change', function() {
        if (this.files && this.files[0]) {
            showPreview(this.files[0]);
        }
    });

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $area.find('img').remove();
            $area.append('<img src="' + e.target.result + '" alt="Preview">');
            $text.hide();
        };
        reader.readAsDataURL(file);
    }
});

$(document).on('click', '#create-product-btn', function() {

    var form = $('#form-new-product')[0];
    var formData = new FormData(form);

    $.ajax({
        url: '/stock/newProduct',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false
    }).done(function (response) {
        response = JSON.parse(response);
        if (response.code == 200) {
            location.href = $('#form-new-product').attr('action'); // Redireciona para a ação do formulário
        } else {
            console.log(response.data); // Exibe a mensagem de erro do servidor
        }
    }).fail(function (error) {
        console.log('An error occurred');
    });
});
    