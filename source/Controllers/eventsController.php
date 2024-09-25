<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Home;

class eventsController extends Core {

    public function home() {
        echo $this->view->render("home", [
            'title' =>  'Eventos - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function details() {
        echo $this->view->render("login", [
            'title' =>  'Termos de Uso - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function logout(){
        session_destroy();
        header("location: /");
    }


}
