<?php


namespace Source\Core;


use League\Plates\Engine;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
//use Source\Model\CoreModal;

class Core
{

    protected $view;

    protected $nucleo;

    protected $router;

    protected $homenPath = 'kitbase';

    public function __construct($router){
        $this->router=$router;
        $this->view = new Engine(dirname(__DIR__,1)."/Theme");
        if (is_dir(dirname(__DIR__,3).'/nucleo/source/Theme/fragments/menu-home/')) {
            $this->nucleo = new Engine(dirname(__DIR__,3)."/nucleo/source/Theme");
        } else {
            $this->nucleo = $this->view;
        }

        $this->view->addData(["router"=> $this->router]);

        $this->validaAcesso();

    }

    public function buildPages($home = false) {
        $pages = [
            // [
            //     'title'         => 'Home',
            //     'href'          => 'launch',
            //     'class-icon'    => 'mdi mdi-home menu-icon',
            //     'active'        => $home,
            // ],
        ];

        return $pages;
    }

    public function validaAcesso(){

//        if( isset($_COOKIE["backsite-token"]) ){
//            $validaToken = (array)JWT::decode($_COOKIE["backsite-token"], new Key(KEY, 'HS256'));
//
//            $validaToken ? 0 : header("location: /Login");
//
//            if( $_SERVER["REQUEST_URI"] == "/Login")
//                header("location: /");
//
//        }else{
//
//            if( $_SERVER["REQUEST_URI"] != "/Login" && $_SERVER["REQUEST_URI"] != "/Auth")
//                header("location: /Login");
//
//        }
    }

//    public function carregaSideBar($nmSideBar){
//
//        $sideBar = new CoreModal();
//        $sideBar = $sideBar->carregaSideBar($nmSideBar);
//
//        return $sideBar["data"];
//
//    }
}