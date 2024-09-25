<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\API;

class apiController extends Core {

    public function events() {

        $dados = new API(ROOT);
        $eventos = $dados->listEvents();

        echo $this->view->render("apis/eventos", ['eventos' => $eventos]);
        return;
    }


    public function sair(){
        session_destroy();
    }

}