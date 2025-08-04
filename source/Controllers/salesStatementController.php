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
        $sales = $salesStatementModel->getSales($store);
        if (empty($sales)) {
            exit($this->renderApiResponse(404, "Nenhuma venda encontrada."));
        }
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
         
        echo $this->view->render("salesStatement/home", [
            'layout' => [
                'title' =>  'Extrato de Vendas - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'sales' => $sales,
            'items' => $salesItems,
        ]);
        return;
    }


}