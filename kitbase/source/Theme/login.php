<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connect Plus</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= url("assets/vendors/mdi/css/materialdesignicons.min.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/vendors/flag-icon-css/css/flag-icon.min.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/vendors/css/vendor.bundle.base.css") ?>">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= url("assets/css/style.css") ?>">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?= url("assets/images/logo-mini.png") ?>" />
    <style> .center-Img{text-align-last: center;} </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo center-Img">
                  <img src="<?= url("assets/images/logo-mini.png") ?>">
                </div>
                <h4>BackSite</h4>
                <p id="aviso"></p>
                <form class="pt-3">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="usuario-txt" placeholder="Usuário">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="senha-txt" placeholder="Senha">
                  </div>
                  <div class="mt-3">
                    <p class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" id="btn-avancar">Avançar</p>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">

                    <a href="#" class="auth-link text-black">Esqueceu sua senha ?</a>
                  </div>

                  <div class="text-center mt-4 font-weight-light"> Não tem uma conta ? <a href="register.html" class="text-primary">Clique aqui</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?= url("assets/js/jquery-3.6.0.js") ?>"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?= url("assets/js/off-canvas.js") ?>"></script>
    <script src="<?= url("assets/js/hoverable-collapse.js") ?>"></script>
    <script src="<?= url("assets/js/misc.js") ?>"></script>
    <!-- endinject -->
    <script>
        $(document).ready(function(){

            $(document).on('keypress',function(e) {
                if(e.which == 13) {
                    $("#btn-avancar").click();
                }
            });

            $("#btn-avancar").click(function(){
                let senha = $("#senha-txt").val();
                let usuario = $("#usuario-txt").val();

                let formData = new FormData();
                    formData.append("senha", senha);
                    formData.append("usuario", usuario);

                $.ajax({
                    url: "/Auth",
                    type: "POST",
                    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
                    enctype: 'multipart/form-data',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        let rt = JSON.parse(data)

                        if( rt.msg ){ $("#aviso").text(rt.msg) }
                        else{
                            let token = rt.token
                            localStorage.setItem("backsite-token", token)

                            window.location.href = "/"
                        }
                    }
                });
            });

        });
    </script>
  </body>
</html>