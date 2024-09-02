<?php

namespace Core;

class Core {
    public $web;

    public function __construct() {
        $this->web = dirname(__FILE__);
    }
    public function loadPage($page) {
        if (file_exists($this->web."/../Theme/{$page}.html"))
            echo file_get_contents($this->web."/../Theme/{$page}.html");
        else
            echo 'Página não encontrada';
    }
}