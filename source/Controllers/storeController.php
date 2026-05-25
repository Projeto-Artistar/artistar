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
        $storeId = null;

        if (!empty($data['storeId'])) {
            $storeId = (int) $data['storeId'];
        } elseif (!empty($data['friendlyUrl'])) {
            $friendlyUrl = strtolower(trim((string) $data['friendlyUrl'], '/'));

            if ($friendlyUrl === 'manage') {
                $this->manage();
                return;
            }

            $storeBySlug = $storeModel->getStoreDataByFriendlyUrl((string) $data['friendlyUrl']);
            $storeId = !empty($storeBySlug['codigo']) ? (int) $storeBySlug['codigo'] : null;
        } elseif (!empty($this->getUser()['loja_id'])) {
            $storeId = (int) $this->getUser()['loja_id'];
        }

        $store = $storeModel->getStoreData($storeId);

        if (empty($store)) {
            header("location: /error/404");
            return;
        }

        $isOwner = false;
        if ($this->getLogado() && !empty($this->getUser()['loja_id'])) {
            $isOwner = ((int) $this->getUser()['loja_id']) === ((int) $store['codigo']);
        }

        $this->addLayout(!empty($store['nome']) ? $store['nome'] : null);

        $products = $storeModel->getPublicProducts($storeId, '', 24, true);
        $followersCount = $storeModel->getStoreFollowersCount($storeId);

        echo $this->view->render("store/details", [
            'layout' => [
                'title' =>  $store['nome'] . ' - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'store' => $store,
            'isOwner' => $isOwner,
            'followersCount' => $followersCount,
            'products' => $products ?? []
        ]);
    }

    public function manage() {
        $this->validaAcesso();

        $storeId = !empty($this->getUser()['loja_id']) ? (int) $this->getUser()['loja_id'] : 0;
        if ($storeId < 1) {
            header("location: /error/404");
            return;
        }

        $storeModel = new Store();
        $store = $storeModel->getStoreData($storeId);

        if (empty($store)) {
            header("location: /error/404");
            return;
        }

        $this->addLayout('Minha Loja');

        echo $this->view->render("store/manage", [
            'layout' => [
                'title' =>  'Minha Loja - Artistar',
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'store' => $store
        ]);
    }

    public function edit($data) {
        $this->validaAcesso();

        $storeId = !empty($data['storeId']) ? (int) $data['storeId'] : 0;
        $loggedStoreId = !empty($this->getUser()['loja_id']) ? (int) $this->getUser()['loja_id'] : 0;

        if ($storeId < 1 || $loggedStoreId < 1 || $storeId !== $loggedStoreId) {
            header("location: /error/404");
            return;
        }

        header("location: /store/manage");
        return;
    }
}