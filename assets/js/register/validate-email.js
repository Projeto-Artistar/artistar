document.addEventListener('DOMContentLoaded', function() {
    // Formata segundos em mm:ss

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



function formatTime(seconds) {
    const min = Math.floor(seconds / 60).toString().padStart(2, '0');
    const sec = (seconds % 60).toString().padStart(2, '0');
    return `${min}:${sec}`;
}

function resendCode() {
    $('#spinner-resend').show();
    $('#text-resend').hide();

    $('#resend-code').addClass('disabled').off('click');

    $.ajax({
        url: '/auth/resend-code',
        type: 'POST',
        data: {
            email: $('#email').val(),
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {

                $('#toastTitle').text('E-mail reenviado com sucesso!');
                $('#toastBody').text('O código enviado será válido por 1 hora. Aguarde 1 minuto para tentar novamente!');
                //remove class bg-success
                // Add class bg-danger
                $('#myToast').addClass('bg-success');
                $('#myToast').removeClass('bg-danger');

                var myToast = new bootstrap.Toast(document.getElementById('myToast'));
                myToast.show();

                let timeLeft = 60; // 1 minute in seconds
                $('#text-resend').text(formatTime(timeLeft));
                const timer = setInterval(function() {
                    timeLeft--;
                    $('#text-resend').text(formatTime(timeLeft));
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        $('#text-resend').text('Reenviar');
                        $('#resend-code').removeClass('disabled');
                        $('#resend-code').on('click', resendCode);
                    }
                }, 1000);

                $('#spinner-resend').hide();
                $('#text-resend').show();
            } else {
                $('#text-resend').text('Reenviar');
                $('#resend-code').removeClass('disabled');
                $('#resend-code').on('click', resendCode);
                alert(response.message);
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
    
}

$('#resend-code').on('click', function(e) {
    resendCode();
});

function disableRegisterBtn() {
    $('#btn-confirm-password-reset').prop('disabled', true);
    $('#spinner-confirm').show();
    $('#text-confirm').hide();
}

function enableRegisterBtn() {
    $('#btn-confirm-password-reset').prop('disabled', false);
    $('#spinner-confirm').hide();
    $('#text-confirm').show();
}

$('#form-confirmacao').on('submit', function(e) {
    e.preventDefault();
    disableRegisterBtn();
    let code = Array.from({ length: 9 }, (_, i) => $('#codigo' + i).val()).join('');
    setTimeout(function() {
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
                    $('#toastTitle').text('Código inválido');
                    $('#toastBody').text('O código enviado é inválido (outro código foi enviado ou expirou), tente novamente!');
                    $('#myToast').addClass('bg-danger');
                    $('#myToast').removeClass('bg-success');

                    var myToast = new bootstrap.Toast(document.getElementById('myToast'));
                    myToast.show();
                }
                enableRegisterBtn();
            },
            error: function(error) {
                console.error(error);
                enableRegisterBtn();
            }
        });
    }, 10);
});

