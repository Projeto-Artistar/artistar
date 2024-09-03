<?php

class Core {
    public $web;

    public function __construct() {
        $this->web = $_SERVER['DOCUMENT_ROOT'];
    }
    public function loadPage($page, $parameters = []) {
        if (file_exists($this->web."/source/Theme/{$page}.php")) {
            foreach ($parameters as $key => $value)
                $$key = $value;
            require_once($this->web."/source/Theme/{$page}.php");
        }
    }
}