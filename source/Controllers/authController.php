<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Auth;

class authController extends Core {

    public function register() {
        echo $this->view->render("auth/register", [
            'title' =>  'Cadastro - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function validate() {
        echo $this->view->render("auth/validate-email", [
            'title' =>  'Confirmação de Email - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function login() {
        echo $this->view->render("auth/login", [
            'title' =>  'Login - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function sair(){
        session_destroy();
        header("location: /");
    }

}
