<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Home;

class homeController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        if($this->getLogado() && $this->getUser()['email_validado'] != 1) $this->checkIfEmailIsValidated();
    }

    public function home() {
        echo $this->view->render("home", [
            'title' =>  'Artistar', 
            'logado' => $this->getLogado(),
        ]);
        return;
    }

    public function login() {
        if ($this->getLogado()) {
            header("location: /");
            return;
        }
        echo $this->view->render("login", [
            'title' =>  'Login - Artistar', 
        ]);
        return;
    }

    public function logout(){
        session_destroy();
        header("location: /");
    }


}
