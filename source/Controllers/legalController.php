<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Legal;

class legalController extends Core {

    public function terms() {
        echo $this->view->render("legal/terms", [
            'title' =>  'Termos de Uso - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function privacy() {
        echo $this->view->render("legal/privacy", [
            'title' =>  'Políticas de Privacidade - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
        ]);
        return;
    }

}
