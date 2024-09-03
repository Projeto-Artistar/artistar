<?php



namespace Source\Controllers;

use League\Plates\Engine;
use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Inicial;

class homeController extends Core
{

    public function home()
    {

        $sideBar = "";
        $pages = $this->buildPages(true);

        $sideBar = $this->nucleo->render("fragments/menu-home/sideBar", ['pages' => $pages, 'avancado' => false]);
        $navBar = $this->nucleo->render("fragments/menu-home/navBar", ['homenPath' => $this->homenPath]);

        echo $this->view->render("home", [ "sideBar" => $sideBar, "navBar" => $navBar]);
        return;
    }


    public function sair(){
        session_destroy();
    }

}
