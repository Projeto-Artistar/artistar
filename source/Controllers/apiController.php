<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Home;

class apiController extends Core {

    public function eventos() {

        $dados = new Home(ROOT);
        $eventos = $dados->trazerEventos();
        

        echo $this->view->render("apis/eventos", ['eventos' => $eventos]);
        return;
    }


    public function sair(){
        session_destroy();
    }

}