<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Store;

class storeController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
    }

    public function details($data) {

        $storeModel = new Store();
        $storeId = !empty($data['storeId']) ? filter_var($data['storeId'], FILTER_SANITIZE_NUMBER_INT) : null;
        $friendlyUrl = !empty($data['friendlyUrl']) ? filter_var($data['friendlyUrl'], FILTER_SANITIZE_STRING) : null;

        $store = null;
        $store = $storeModel->getStoreData($storeId);


        echo $this->view->render("store/details", [
            'layout' => [
                'title' =>  $store['nome'] . ' - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'store' => $store
        ]);
    }
}