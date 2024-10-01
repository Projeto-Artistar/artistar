<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\API;

class apiController extends Core {

    private function renderError($errCode = 404, $forceLogin = false) {
        echo $this->view->render("apiResponse", [
            'result' => [
                'code' => $errCode,
                'forceLogin' => $forceLogin
            ],
            
        ]);
        return;
    }

    public function events() {

        $dados = new API();
        $eventos = $dados->listEvents();

        echo $this->view->render("apiResponse", [
            'result' => [
                'code' => 200,
                'data' => [
                    'eventos' => $eventos
                ]
            ]
        ]);
        return;
    }

    public function eventFavorite($data) {

        // if (!$this->getLogado()) {
        //     $this->renderError(401, true);
        //     return;
        // }

        $dados = new API();

        $favorite = $dados->setFavorite(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));

        echo $this->view->render("apiResponse", [
            'result' => [
                'code' => 200,
                'data' => [
                    'favorite' => $favorite
                ]
            ]
        ]);

        return;
    }

}