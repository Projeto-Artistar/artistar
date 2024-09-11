<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Register;

class registerController extends Core {

    public function home() {
        echo $this->view->render("register/home", [
            'title' =>  'Cadastro - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function validate() {
        echo $this->view->render("register/validate-email", [
            'title' =>  'Confirmação de Email - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

}
