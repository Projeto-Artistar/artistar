<?php

namespace Source\Controllers;
use Source\Core\Core;
use Source\Model\Stock;

class stockController extends Core
{

    public function home() {
        $stockModel = new Stock();
        $stocks = [];
        echo $this->view->render("stock/home", [
            'title' =>  'Stock - Artistar', 
            'logado' => $this->getLogado(),
            'stocks' => $stocks,
        ]);
        return;
    }
}