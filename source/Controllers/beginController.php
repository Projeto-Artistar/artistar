<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Begin;

class beginController extends Core {

    public function home() {
        $this->validaAcesso();
        echo $this->view->render("begin", [
            'title' =>  'Iniciar - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
        ]);
        return;     
    }

}
