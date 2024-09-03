<?php


namespace Source\Controllers;

use League\Plates\Engine;
use CoffeeCode\Router\Router;
use Source\Core\Core;

class elementosController extends Core
{

    public function contextual()
    {

        $sideBar = "";
        $pages = [
            [
                'title'         => 'Home',
                'href'          => 'kitbase',
                'class-icon'    => 'mdi mdi-cube menu-icon',
            ],
            [
                'title'         => 'Elementos',
                'class-icon'    => 'mdi mdi-apps menu-icon',
                'href'          => 'elementos',
                'dropdown'      => [
                    'Menu Contextual' => 'kitbase/elementos/contextual',
                    'Menu Contextual 2' => 'kitbase/elementos/contextSeg',
                ]
            ]
        ];

        if (file_exists(dirname(__DIR__,3).'/nucleo/source/Theme/fragments/menu-home/sideBar.php')) {
            $sideBar = $this->nucleo->render("fragments/menu-home/sideBar", ['pages' => $pages, 'avancado' => '/kitbase/avancado']);
        } else {
            $sideBar = $this->view->render("fragments/menu-home/sideBar", ['pages' => $pages, 'avancado' => '/kitbase/avancado']);
        }

        if (file_exists(dirname(__DIR__,3).'/nucleo/source/Theme/fragments/menu-home/navBar.php')) {
            $navBar = $this->nucleo->render("fragments/menu-home/navBar", []);
        } else {
            $navBar = $this->view->render("fragments/menu-home/navBar", []);
        }

        echo $this->view->render("elementos/contextual", [ "sideBar" => $sideBar, "navBar" => $navBar ]);
        return;
    }

    public function contextSeg()
    {

        $sideBar = "";
        $pages = [
            [
                'title'         => 'Home',
                'href'          => 'kitbase',
                'class-icon'    => 'mdi mdi-cube menu-icon',
            ],
            [
                'title'         => 'Elementos',
                'class-icon'    => 'mdi mdi-apps menu-icon',
                'href'          => 'elementos',
                'dropdown'      => [
                    'Menu Contextual' => 'kitbase/elementos/contextual',
                    'Menu Contextual 2' => 'kitbase/elementos/contextSeg',
                ]
            ]
        ];

        if (file_exists(dirname(__DIR__,3).'/nucleo/source/Theme/fragments/menu-home/sideBar.php')) {
            $sideBar = $this->nucleo->render("fragments/menu-home/sideBar", ['pages' => $pages, 'avancado' => '/kitbase/avancado']);
        } else {
            $sideBar = $this->view->render("fragments/menu-home/sideBar", ['pages' => $pages, 'avancado' => '/kitbase/avancado']);
        }

        if (file_exists(dirname(__DIR__,3).'/nucleo/source/Theme/fragments/menu-home/navBar.php')) {
            $navBar = $this->nucleo->render("fragments/menu-home/navBar", []);
        } else {
            $navBar = $this->view->render("fragments/menu-home/navBar", []);
        }

        echo $this->view->render("elementos/contextSeg", [ "sideBar" => $sideBar, "navBar" => $navBar ]);
        return;
    }

}
