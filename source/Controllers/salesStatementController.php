<?php

namespace Source\Controllers;
use Source\Core\Core;
use Source\Model\SalesStatement;

class salesStatementController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        if (!$this->getLogado()) {
            header("Location: /login");
        }
    }

    public function home() {
        $salesStatementModel = new SalesStatement();
        $store = $this->getUser()['loja_id'] ?? 0;

        $pagination = $_GET['pagination'] ?? [
            'offset' => 0
        ];
        $pagination['limit'] = 25;

        $whereSales = $salesStatementModel->buildWhereSales([]);

        $sort = $_GET['sort'] ?? 'name_asc';

        $orderList = $salesStatementModel->getOrderList($sort);
        $order = $salesStatementModel->buildOrderBy($orderList, $sort);

        $sales = $salesStatementModel->getSales($store, $pagination, $whereSales, $order);

        $totalSales = $salesStatementModel->getTotalSales($store, $pagination, $whereSales);

        $pages = [
            'current' => ($pagination['offset'] / $pagination['limit']) + 1,
            'total' => ceil($totalSales / $pagination['limit'])
        ]; 

        $salesIds = array_column($sales, 'id');
        $items = $salesStatementModel->getItems($salesIds);

        $salesItems = [];

        foreach ($items as $item) {
            $item['valor_unitario'] = moedaReal($item['valor'] / $item['qtd']);
            $item['desconto_unitario'] = moedaReal($item['desconto'] / $item['qtd']);
            $item['valor'] = moedaReal($item['valor']);
            $item['desconto'] = moedaReal($item['desconto']);
            if (!isset($salesItems[$item['id_venda']])) {
                $salesItems[$item['id_venda']] = [];
            }
            $salesItems[$item['id_venda']][] = $item;
        }
         
        echo $this->view->render("sales-statement/home", [
            'layout' => [
                'title' =>  'Extrato de Vendas - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'sales' => $sales,
            'totalSales' => $totalSales,
            'items' => $salesItems,
            'pagination' => $pagination,
            'pages' => $pages,
            'sort' => $sort,
            'orderList' => $orderList,
        ]);
        return;
    }

    public function editSale($post) {
        return;
    }

    public function cancelSale($post) {
        return;
    }

    public function reactiveSale($post) {
        return;
    }

    public function saleDetails($get) {
        $salesStatementModel = new SalesStatement();
        $store = $this->getUser()['loja_id'] ?? 0;
        $saleId = $get['saleId'] ?? 0;
        if (!$store) exit($this->renderApiResponse(404, "Loja não encontrada."));

        $saleInfo = $salesStatementModel->getSaleById($saleId, $store);

        if (!$saleInfo) exit($this->renderApiResponse(404, "Venda não encontrada."));

        $saleItems = $saleId ? $salesStatementModel->getSaleItems($saleId) : [];

        foreach ($saleItems as &$item) {
            $item['preco'] = moedaReal($item['preco']);
            $item['valor'] = moedaReal($item['valor']);
            $item['desconto'] = moedaReal($item['desconto']);
        }

        $products = $salesStatementModel->getProducts($store);

        foreach ($products as &$product) {
            $product['total'] = moedaReal($product['preco'] - $product['desconto']);
            $product['preco'] = moedaReal($product['preco']);
            $product['desconto'] = moedaReal($product['desconto']);
        }


        echo $this->view->render("sales-statement/saleDetails", [
            'layout' => [
                'title' =>  'Nova Venda - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'products' => $products,
            'saleInfo' => $saleInfo,
            'saleItems' => $saleItems,
        ]);
        return;
    }

}