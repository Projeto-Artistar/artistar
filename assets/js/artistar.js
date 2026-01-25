function atualizarToast(toast, title, body, isSuccess = true) {
    $('#toastTitle').text(title);
    $('#toastBody').text(body);
    //remove class bg-success
    if (isSuccess) {
        $('#'+toast).removeClass('bg-danger');
        $('#'+toast).addClass('bg-success');
    } else {
        $('#'+toast).removeClass('bg-success');
        $('#'+toast).addClass('bg-danger');
    }
    var myToast = new bootstrap.Toast(document.getElementById(toast));
    myToast.show();
}