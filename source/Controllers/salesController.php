<?php

namespace Source\Controllers;
use Source\Core\Core;
use Source\Model\Sales;
use Source\Model\Helpers\PaymentMethods;

class salesController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        $this->validaAcesso();
        $this->getLayout()->setHeader($this->getLogado() ? 'header-logado' : 'header');
        $this->getLayout()->setFooter('footer');
        $this->addLayout();
    }

    public function home() {
        $salesModel = new Sales();
        $store = $this->getUser()['loja_id'] ?? 0;
        $products = $salesModel->getProducts($store);
        array_walk_recursive($products, function(&$item){
            $item=strval($item);
        });
        foreach ($products as &$product) {
            $product['total'] = moedaReal($product['preco'] - $product['desconto']);
            $product['preco'] = moedaReal($product['preco']);
            $product['desconto'] = moedaReal($product['desconto']);
            $product['imagem'] = empty($product['imagem']) ? url('assets/image/200x300.png') : storageURL($product['imagem']);
        }
        $paymentMethods = new PaymentMethods();
        echo $this->view->render("sales/home", [
            'layout' => [
                'title' =>  'Nova Venda - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'products' => $products,
            'storeEvents' => $salesModel->getStoresCurrentEvents($store),
            'paymentMethods' => $paymentMethods->getMethods(),
        ]);
        return;
    }

    public function insert($post) {
        $salesModel = new Sales();
        $store = $this->getUser()['loja_id'] ?? 0;
        $newSale = $salesModel->insertSale($post, $store);
        if ($newSale) {
            exit($this->renderApiResponse(200, "Venda registrada com sucesso.", $newSale));
        }
    }


}