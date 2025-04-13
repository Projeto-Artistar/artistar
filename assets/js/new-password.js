$('#form-new-password').on('submit', function(e) {
    e.preventDefault();
    let senha = $('#senha').val();
    let confirmacaoSenha = $('#confirmacao-senha').val();
    let permitirInsercao = false;

    let senhaForteRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (!senhaForteRegex.test(senha)) {
        alert("A senha deve conter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.");
    } else if (senha !== confirmacaoSenha) {
        alert("As senhas não coincidem.");
    } else {
        permitirInsercao = true;
    }

    if (permitirInsercao) {
        
        $.ajax({
            url: '/auth/change-password',
            type: 'POST',
            data: {
                password: senha
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    location.href = $('#form-new-password').attr('action');
                }  else {    
                    alert(response.message);
                }
            },
            error: function(error) {
                console.log('An error occurred');
            }
        });
    }
});