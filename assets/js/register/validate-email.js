document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (this.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', function(event) {
            if (event.key === 'Backspace' && this.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Evento para colar o código completo
        input.addEventListener('paste', function(event) {
            event.preventDefault(); // Impede o comportamento padrão de colar
            const pasteData = (event.clipboardData || window.clipboardData).getData('text').toUpperCase().replace(/[^A-Z0-9]/g, '');
            
            // Distribui os caracteres colados nos inputs
            pasteData.split('').forEach((char, i) => {
                if (i < inputs.length) {
                    inputs[i].value = char;
                }
            });

            // Move o foco para o último campo preenchido
            const lastFilledInput = Array.from(inputs).reverse().find(input => input.value !== '');
            if (lastFilledInput) {
                lastFilledInput.focus();
            }
        });

    });
});

$('#form-confirmacao').on('submit', function(e) {
    e.preventDefault();
    let code = Array.from({ length: 9 }, (_, i) => $('#codigo' + i).val()).join('');
    $.ajax({
        url: '/register/validate-code',
        type: 'POST',
        data: {
            code: code,
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                location.href = $('#form-confirmacao').attr('action');
            }  else {    
                alert(response.message);
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
});

