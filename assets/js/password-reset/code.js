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
    });
});

$('#form-confirmation-code').on('submit', function(e) {
    e.preventDefault();
    let code = Array.from({ length: 9 }, (_, i) => $('#codigo' + i).val()).join('');
    $.ajax({
        url: '/password-reset/code',
        type: 'POST',
        data: {
            code: code,
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                location.href = $('#form-confirmation-code').attr('action');
            }  else {    
                alert(response.message);
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
});
