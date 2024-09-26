<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\API;

class apiController extends Core {

    public function events() {

        $dados = new API();
        $eventos = $dados->listEvents();

        echo $this->view->render("apis/events", ['eventos' => $eventos]);
        return;
    }

    public function eventDetails($data) {

        $dados = new API();
        $evento = $dados->getEventDetails(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));

        echo $this->view->render("apis/eventDetails", ['evento' => $evento]);
        return;
    }

}