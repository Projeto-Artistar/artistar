<?php

namespace Source\Controllers;
use Source\Core\Core;
use Source\Model\Settings;

class settingsController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        $this->validaAcesso();
    }

    public function home() {
        echo $this->view->render("settings/home", [
            'layout' => [
                'title' =>  'Configurações - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
        ]);
        return;
    }

}