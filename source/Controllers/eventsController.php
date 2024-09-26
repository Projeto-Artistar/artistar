<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Events;

class eventsController extends Core {

    public function home() {
        echo $this->view->render("events/home", [
            'title' =>  'Eventos - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
            'banner' => $this->view->render("fragments/home/".($this->getLogado() ? "banner" : "slide")),
        ]);
        return;
    }

    public function details($get) {
        $dados = new Events();
        $evento = $dados->getBasicEventInfo(filter_var($get['eventId'], FILTER_SANITIZE_NUMBER_INT));

        if (empty($evento)) {
            header("Location: /error/404");
            return;
        } else if (!isset($get['friendlyUrl']) || $evento['url'] != $get['friendlyUrl']) {
            header("Location: /events/{$evento['id']}/{$evento['url']}");
            return;
        }
        echo $this->view->render("events/details", [
            'title' =>  $evento['title'].' - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
            'evento' => $evento,
        ]);
        return;
    }


}
