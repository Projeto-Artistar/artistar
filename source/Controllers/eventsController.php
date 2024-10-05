<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Events;

class eventsController extends Core {

    public function home() {
        $get = [];
        if (isset($_GET['s'])) $get['s'] = filter_var($_GET['s'], FILTER_SANITIZE_STRING);
        if (isset($_GET['r'])) $get['r'] = filter_var($_GET['r'], FILTER_SANITIZE_STRING);
        if (isset($_GET['sd'])) $get['sd'] = filter_var($_GET['sd'], FILTER_SANITIZE_STRING);
        if (isset($_GET['fd'])) $get['fd'] = filter_var($_GET['fd'], FILTER_SANITIZE_STRING);
        
        echo $this->view->render("events/home", [
            'title'         =>  'Eventos - Artistar', 
            'header'        => $this->header(),
            'footer'        => $this->footer(),
            'banner'        => $this->view->render("fragments/home/".($this->getLogado() ? "banner" : "slide")),
            'events'        => (new Events())->getEvents(),
            'queryString'   => http_build_query($get),
            'currentPage'   => isset($_GET['page']) ? filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT) : 1
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
