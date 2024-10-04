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
            'events' => (new Events())->getEvents()
        ]);
        return;
    }

    public function details($data) {
        $dados = new Events();
        $event = $dados->getEventBasicInfo(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        
        if (empty($event)) {
            header("Location: /error/404");
            return;
        } else if (!isset($data['friendlyUrl']) || $event['url'] != $data['friendlyUrl']) {
            header("Location: /events/{$event['id']}/{$event['url']}");
            return;
        }

        $days = $dados->getEventDays(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        $prices = $dados->getEventPrices(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        $photos = $dados->getEventPhotos(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        echo $this->view->render("events/details", [
            'title' =>  $event['title'].' - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
            'event' => $event,
            'days' => $days,
            'prices' => $prices,
            'photos' => $photos
        ]);
        return;
    }


}
