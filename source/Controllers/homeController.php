<?php

$web = $_SERVER['DOCUMENT_ROOT'];
require_once($web.'/source/Core/Core.php');

Class homeController extends Core {
    public function home() {
        $this->loadView('home');
    }

    public function logado() {
        $this->loadView('home.logado');
    }
}