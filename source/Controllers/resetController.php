<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Reset;

class resetController extends Core {

    public function home() {
        echo $this->view->render("password-reset/home", [
            'title' =>  'Esqueci minha senha - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function code() {
        echo $this->view->render("password-reset/code", [
            'title' =>  'Confirmar código - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function newPassword() {
        echo $this->view->render("password-reset/new-password", [
            'title' =>  'Redefinir senha - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
        ]);
        return;
    }

}
