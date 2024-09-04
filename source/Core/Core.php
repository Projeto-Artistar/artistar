<?php


namespace Source\Core;

use League\Plates\Engine;

class Core
{

    protected $view;

    protected $nucleo;

    protected $router;

    protected $homenPath = 'artistar';

    public function __construct($router){
        $this->router=$router;
        $this->view = new Engine(dirname(__DIR__,1)."/Theme");
        $this->nucleo = $this->view;

        $this->view->addData(["router"=> $this->router]);

    }

    public function validaAcesso(){

    }


}