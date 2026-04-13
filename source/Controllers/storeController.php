<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Store;

class storeController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        $this->getLayout()->setHeader($this->getLogado() ? 'header-logado' : 'header');
        $this->getLayout()->setFooter('footer');
    }

    public function details($data) {

        $storeModel = new Store();
        $storeId = !empty($this->getUser()) ? $this->getUser()['loja_id'] : null;
        $store = $storeModel->getStoreData($storeId);

        $this->addLayout(!empty($store['nome']) ? $store['nome'] : null);


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