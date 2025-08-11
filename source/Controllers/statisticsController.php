<?php

namespace Source\Controllers;
use Source\Core\Core;
use Source\Model\Statistics;

class statisticsController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        if (!$this->getLogado()) {
            header("Location: /login");
        }
    }

    public function home() {
        $statisticsModel = new Statistics();
        $store = $this->getUser()['loja_id'] ?? 0;
        $periodoSelecionado = $_GET['period'] ?? 'day';
        $dataReferencia = $_GET['date'] ?? date('Y-m-d');
        $periodos = $statisticsModel->getPeriodos();
        $totais = $statisticsModel->getTotals($store, $periodos[$periodoSelecionado], $dataReferencia);
        $bestSellers = $statisticsModel->getBestSellers($store, $periodos[$periodoSelecionado], $dataReferencia);
        $graphData = $statisticsModel->arrangeGraphData($totais, $periodoSelecionado, $dataReferencia);
        $productRanking = $statisticsModel->getProductRanking($store, $periodos[$periodoSelecionado], $dataReferencia);

        echo $this->view->render("statistics/home", [
            'layout' => [
                'title' =>  'Estatísticas - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'periodos' => $periodos,
            'periodoSelecionado' => $periodoSelecionado,
            'dataReferencia' => $dataReferencia,
            'bestSellers' => $bestSellers,
            'graphData' => $graphData,
            'productRanking' => $productRanking
        ]);
        return;
    }

}