<?php

namespace Source\Controllers;
use Source\Core\Core;
use Source\Model\Sales;

class salesController extends Core {

    // public function __construct($router = ROOT) {
    //     parent::__construct($router);
    //     if (!$this->getLogado()) {
    //         header("Location: /login");
    //     }
    // }

    public function home() {
        $salesModel = new Sales();
        $store = $this->getUser()['loja_id'] ?? 0;
        $products = $salesModel->getProducts($store);
        echo $this->view->render("sales/home", [
            'layout' => [
                'title' =>  'Nova Venda - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'products' => $products,
        ]);
        return;
    }

}