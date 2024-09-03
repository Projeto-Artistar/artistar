<?php

$web = $_SERVER['DOCUMENT_ROOT'];
require_once($web.'/source/Models/Home.php');

Class apiController extends Core {
    public function eventos() {
        $home = new Home();
        $eventos = $home->Eventos();
        $this->loadView('apis/eventos', ['eventos' => $eventos]);
    }
}