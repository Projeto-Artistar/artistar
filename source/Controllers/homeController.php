<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Home;
use Source\Model\Helpers\BuildLayout;

class homeController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        if($this->getLogado() && $this->getUser()['email_validado'] != 1) $this->checkIfEmailIsValidated();
    }

    public function home() {
        $this->getLayout()->setHeader($this->getLogado() ? 'header-logado' : 'header');
        $this->getLayout()->setFooter('footer');
        $this->addLayout();
        $this->addTranslator('home');
        echo $this->view->render("home");
        return;
    }

    public function login() {
        $this->getLayout()->setFooter('footer');
        $this->addLayout();
        if ($this->getLogado()) {
            header("location: /");
            return;
        }
        echo $this->view->render("login", [
            'title' =>  'Login - Artistar', 
            'redirect' => $this->getRedirect()
        ]);
        return;
    }

    public function logout(){
        session_destroy();
        header("location: /");
    }


}
