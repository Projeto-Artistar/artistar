<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Home;

class homeController extends Core {

    public function home() {
        echo $this->view->render("home", [
            'title' =>  'Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
            'banner' => $this->view->render("fragments/home/".(isset($_SESSION['logado']) ? "banner" : "slide")),
        ]);
        return;
    }

}
