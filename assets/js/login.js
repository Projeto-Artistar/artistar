$('#form-login').on('submit', function(e) {
    e.preventDefault();
    let email = $('#email').val();
    let senha = $('#senha').val();
    $.ajax({
        url: '/auth/login',
        type: 'POST',
        data: {
            email: email,
            password: senha
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                location.href = $('#form-login').attr('action');
            }  else {    
                alert(response.message);
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
});