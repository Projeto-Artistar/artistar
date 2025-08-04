<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;

class errorController extends Core {

    public function error404() {
        echo $this->view->render("error/404");
        return;
    }

    public function error400() {
        echo $this->view->render("error/400");
        return;
    }

}