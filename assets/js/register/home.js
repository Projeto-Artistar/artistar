document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll(".needs-validation");

    Array.from(forms).forEach(function (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Impede o envio padrão do formulário
            event.stopPropagation();

            // Verifica se o formulário é válido
            if (!form.checkValidity()) {
                form.classList.add("was-validated");
                return; // Sai da função se o formulário for inválido
            }

            // Verifica se o campo de usuario tem mais de 3 caracteres
            let user = $('#user').val();
            if (user.length < 3) {
                $('#user').addClass('is-invalid').removeClass('is-valid'); // Marca o campo como inválido
                $('#user').next('.invalid-feedback').text('O nome de usuário deve ter pelo menos 3 caracteres.');
                return; // Sai da função se o campo for inválido
            } 

            // Validação adicional para senha
            let senha = $('#senha').val();
            let confirmacaoSenha = $('#confirmacao-senha').val();
            let senhaForteRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!senhaForteRegex.test(senha)) {
                $('#senha').addClass('is-invalid').removeClass('is-valid'); // Marca o campo como inválido
                $('#senha').next('.invalid-feedback').text('A senha deve conter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.');
                return;
            } else {
                $('#senha').removeClass('is-invalid').addClass('is-valid'); // Marca como válido
            }

            if (senha !== confirmacaoSenha) {
                $('#confirmacao-senha').addClass('is-invalid').removeClass('is-valid'); // Marca o campo como inválido
                $('#confirmacao-senha').next('.invalid-feedback').text('As senhas não coincidem.');
                return;
            } else {
                $('#confirmacao-senha').removeClass('is-invalid').addClass('is-valid'); // Marca como válido
            }

            // Se tudo estiver válido, envia os dados via AJAX
            let nome = $('#user').val();
            let complete_user = $('#complete_user').val();
            let email = $('#email').val();

            if (nome.length < 3) {
                $('#user').addClass('is-invalid').removeClass('is-valid'); // Marca o campo como inválido
                return;
            } else {
                $('#user').removeClass('is-invalid').addClass('is-valid'); // Marca como válido
            }

            if (!email.includes('@')) {
                $('#email').addClass('is-invalid').removeClass('is-valid'); // Marca o campo como inválido
                return;
            } else {
                $('#email').removeClass('is-invalid').addClass('is-valid'); // Marca como válido
            }

            // Envia os dados via AJAX
            $.ajax({
                url: '/register',
                type: 'POST',
                data: {
                    user: nome,
                    complete_user: complete_user,
                    email: email,
                    password: senha
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.code == 200) {
                        location.href = $('#form-register').attr('action'); // Redireciona para a ação do formulário
                    } else {
                        let errors = response.data || [];

                        errors.forEach(function (error) {
                            if (error.field === 'user') {
                                $('#user').addClass('is-invalid').removeClass('is-valid');
                                $('#user').next('.invalid-feedback').text(error.message);
                            }
                            if (error.field === 'email') {
                                $('#email').addClass('is-invalid').removeClass('is-valid');
                                $('#email').next('.invalid-feedback').text(error.message);
                            }
                        });

                        console.error(response.message); // Exibe a mensagem de erro do servidor
                    }
                },
                error: function (error) {
                    console.log('An error occurred');
                }
            });
        }, false);
    });
});