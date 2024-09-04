<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Home;

class homeController extends Core
{

    public function home()
    {

        echo $this->view->render("home");
        return;
    }


    public function sair(){
        session_destroy();
    }

}
