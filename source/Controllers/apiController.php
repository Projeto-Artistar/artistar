<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\API;

class apiController extends Core {

    private function render404() {
        echo $this->view->render("apis/404");
        return;
    }

    public function events() {

        $dados = new API();
        $eventos = $dados->listEvents();

        echo $this->view->render("apis/events", ['eventos' => $eventos]);
        return;
    }

    public function eventDetails($data) {

        $dados = new API();
        $basicInfo = $dados->getEventBasicInfo(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        if (empty($basicInfo)) {
            $this->render404();
            return;
        }
        $days = $dados->getEventDays(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        $prices = $dados->getEventPrices(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        $photos = $dados->getEventPhotos(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));

        echo $this->view->render("apis/eventDetails", [
            'basicInfo' => $basicInfo,
            'days'      => $days,
            'prices'    => $prices,
            'photos'    => $photos
        ]);
        return;
    }

}