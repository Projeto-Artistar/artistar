<?php


namespace Source\Core;

use League\Plates\Engine;

class Core
{

    protected $view;

    protected $nucleo;

    protected $router;

    protected $homenPath = 'artistar';

    protected $logado = false;

    public function __construct($router){
        $this->router=$router;
        $this->view = new Engine(dirname(__DIR__,1)."/Theme");
        $this->nucleo = $this->view;

        $this->view->addData(["router"=> $this->router]);

    }

    public function header() {
        return $this->view->render("fragments/".($this->getLogado() ? "header-logado" : "header"));
    }

    public function footer() {
        return $this->view->render("fragments/footer");
    }

    public function verificaLogado(){
        if(isset($_SESSION['logado'])) $this->logado = true;
    }

    public function getLogado () {
        return $this->logado;
    }

    public function validaAcesso(){
        if(!$this->getLogado()){
            header("location: /login");
        }

    }


}