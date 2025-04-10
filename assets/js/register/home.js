$('#form-register').on('submit', function(e) {
    let nome = $('#user').val();
    let email = $('#email').val();
    let senha = $('#senha').val();
    let confirmacaoSenha = $('#confirmacao-senha').val();
    e.preventDefault();
    if (confirmacaoSenha === senha) {
        $.ajax({
            url: '/register',
            type: 'POST',
            data: {
                user: nome,
                email: email,
                password: senha
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    location.href = $('#form-register').attr('action');
                }  else {    
                    console.log(response);
                }
            },
            error: function(error) {
                console.log('An error occurred');
            }
        });
    }
});