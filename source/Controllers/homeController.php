<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Home;

class homeController extends Core
{

    public function home() {
        $header = $this->view->render("fragments/".(isset($_SESSION['logado']) ? "header-logado" : "header"));
        $footer = $this->view->render("fragments/footer");
        $banner = $this->view->render("fragments/home/".(isset($_SESSION['logado']) ? "banner" : "slide"));
        echo $this->view->render("home", [
            'title' =>  'Artistar', 
            'header' => $header,
            'footer' => $footer,
            'banner' => $banner
        ]);
        return;
    }

    public function sair(){
        session_destroy();
        header("location: /");
    }

}
