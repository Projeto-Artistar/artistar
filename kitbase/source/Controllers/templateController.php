<?php



namespace Source\Controllers;

use League\Plates\Engine;
use CoffeeCode\Router\Router;
use Source\Core\Core;
//use Source\Model\Home;

class templateController extends Core
{

    public function carregaTela()
    {

        $sideBar = $this->view->render("fragments/menu-home/sideBar", []);
        $navBar = $this->view->render("fragments/menu-home/navBar", []);


        $rotaArquivo = str_replace("/kitbase", "", $_SERVER["REQUEST_URI"]);

        $rotaArquivo = count(explode("/", $rotaArquivo)) <= 2 ? $rotaArquivo.$rotaArquivo : $rotaArquivo;

//        var_dump($rotaArquivo);
//        exit();

        echo $this->view->render("fragments/template/$rotaArquivo", [ "sideBar" => $sideBar, "navBar" => $navBar ]);
        return;
    }


    public function sair(){
        session_destroy();
    }

}
