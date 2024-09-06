<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Auth;

class authController extends Core
{

    public function login() {
        $footer = $this->view->render("fragments/footer");
        echo $this->view->render("login", [
            'title' =>  'Login - Artistar', 
            'footer' => $footer,
        ]);
        return;
    }

    public function register() {
        $footer = $this->view->render("fragments/footer");
        echo $this->view->render("register", [
            'title' =>  'Cadastro - Artistar', 
            'footer' => $footer,
        ]);
        return;
    }

    public function validate() {
        $footer = $this->view->render("fragments/footer");
        echo $this->view->render("validate", [
            'title' =>  'Confirmação de Email - Artistar', 
            'footer' => $footer,
        ]);
        return;
    }

    public function sair(){
        session_destroy();
        header("location: /");
    }

}
