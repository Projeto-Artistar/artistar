<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Search;

class searchController extends Core {

    public function results() {

        $dados = new Search();

        $get = [
            's'     => (isset($_GET['s']) ? filter_var($_GET['s'], FILTER_SANITIZE_STRING) : ''),
            'r'     => (isset($_GET['r']) ? filter_var($_GET['r'], FILTER_SANITIZE_STRING) : ''),
            'c'     => (isset($_GET['c']) ? filter_var($_GET['c'], FILTER_SANITIZE_STRING) : ''),
            'sd'    => (isset($_GET['sd']) ? filter_var($_GET['sd'], FILTER_SANITIZE_STRING) : ''),
            'fd'    => (isset($_GET['fd']) ? filter_var($_GET['fd'], FILTER_SANITIZE_STRING) : '')
        ];
        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

        $results = $dados->getResults($search, $get);

        echo $this->view->render("results", [
            'title'     =>  'Resultados para: '.$search.' - Artistar', 
            'header'    => $this->header($search),
            'footer'    => $this->footer(),
            'banner'    => $this->view->render("fragments/home/".($this->getLogado() ? "banner" : "slide")),
            'estados'   => $this->getEstados(),
            'get'       => $get,
            'results' => $results
        ]);
        return;
    }


}
