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

$('#form-password-reset').on('submit', function(e) {
    e.preventDefault();
    disableRegisterBtn();
    let email = $('#email').val();

    setTimeout(function() {
        $.ajax({
            url: '/password-reset',
            type: 'POST',
            data: {
                email: email,
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    location.href = $('#form-password-reset').attr('action');
                }  else {    
                    $('#toastTitle').text('E-mail não encontrado');
                    $('#toastBody').text('O e-mail informado não foi encontrado!');
                    $('#myToast').addClass('bg-danger');
                    $('#myToast').removeClass('bg-success');
                    var myToast = new bootstrap.Toast(document.getElementById('myToast'));
                    myToast.show();
                }
                enableRegisterBtn();
            },
            error: function(error) {
                console.log('An error occurred');
                console.error(error);
                enableRegisterBtn();
            }
        });
    }, 10); // Pequeno delay para garantir renderização do spinner
});