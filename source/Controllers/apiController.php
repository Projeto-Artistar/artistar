<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\API;
use Source\Model\Store;

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

    public function states() {

        $dados = new API();
        $states = $dados->listStates();

        echo $this->view->render("apiResponse", [
            'result' => [
                'code' => 200,
                'data' => [
                    'states' => $states
                ]
            ]
        ]);
    
        return;
    }

    public function cities($data) {

        $dados = new API();
        $cities = $dados->listCities(filter_var($data['uf'], FILTER_SANITIZE_STRING));

        echo $this->view->render("apiResponse", [
            'result' => [
                'code' => 200,
                'data' => [
                    'cities' => $cities
                ]
            ]
        ]);
    
        return;
    }

    public function storeProducts($data) {
        $storeId = isset($data['storeId']) ? (int) $data['storeId'] : 0;
        $search = isset($data['search']) ? trim((string) $data['search']) : '';

        if ($storeId < 1) {
            echo $this->view->render("apiResponse", [
                'result' => [
                    'code' => 400,
                    'message' => 'Loja invalida.'
                ]
            ]);
            return;
        }

        $storeModel = new Store();
        $products = $storeModel->getPublicProducts($storeId, $search);

        foreach ($products as &$product) {
            $price = ((float) $product['valor']) - ((float) $product['valor_desconto']);
            if ($price < 0) $price = (float) $product['valor'];

            $product['thumbnail'] = !empty($product['thumbnail'])
                ? storageURL($product['thumbnail'])
                : url('assets/image/200x300.png');
            $product['price'] = moedaReal($price);
        }

        echo $this->view->render("apiResponse", [
            'result' => [
                'code' => 200,
                'data' => [
                    'products' => $products
                ]
            ]
        ]);

        return;
    }

}