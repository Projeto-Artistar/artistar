$('#form-password-reset').on('submit', function(e) {
    e.preventDefault();
    let email = $('#email').val();
    
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
                alert(response.message);
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
});