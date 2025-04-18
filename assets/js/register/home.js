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

            // Validação adicional para senha
            let senha = $('#senha').val();
            let confirmacaoSenha = $('#confirmacao-senha').val();
            let senhaForteRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!senhaForteRegex.test(senha)) {
                $('#senha').addClass('is-invalid'); // Marca o campo como inválido
                return;
            } else {
                $('#senha').removeClass('is-invalid').addClass('is-valid'); // Marca como válido
            }

            if (senha !== confirmacaoSenha) {
                $('#confirmacao-senha').addClass('is-invalid'); // Marca o campo como inválido
                return;
            } else {
                $('#confirmacao-senha').removeClass('is-invalid').addClass('is-valid'); // Marca como válido
            }

            // Validação adicional para nome de usuário e e-mail
            let nome = $('#user').val();
            let email = $('#email').val();

            if (nome.length < 3) {
                $('#user').addClass('is-invalid'); // Marca o campo como inválido
                return;
            } else {
                $('#user').removeClass('is-invalid').addClass('is-valid'); // Marca como válido
            }

            if (!email.includes('@')) {
                $('#email').addClass('is-invalid'); // Marca o campo como inválido
                return;
            } else {
                $('#email').removeClass('is-invalid').addClass('is-valid'); // Marca como válido
            }

            // Se tudo estiver válido, envia os dados via AJAX
            $.ajax({
                url: '/register',
                type: 'POST',
                data: {
                    user: nome,
                    email: email,
                    password: senha
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.code == 200) {
                        location.href = $('#form-register').attr('action'); // Redireciona para a ação do formulário
                    } else {
                        // Marca os campos como inválidos com base na resposta do servidor
                        if (response.field === 'user') {
                            $('#user').addClass('is-invalid');
                        }
                        if (response.field === 'email') {
                            $('#email').addClass('is-invalid');
                        }
                        alert(response.message); // Exibe a mensagem de erro do servidor
                    }
                },
                error: function (error) {
                    console.log('An error occurred');
                }
            });
        }, false);
    });
});