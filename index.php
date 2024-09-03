<?php
ini_set('display_errors', 1);

$web = $_SERVER['DOCUMENT_ROOT'];

$pagina = $_SERVER['REQUEST_URI'];

$urls = [
    '/' => 'homeController.home',
    '/logado' => 'homeController.logado',
    '/apis/eventos' => 'apiController.eventos'
];

if (isset($urls[$pagina])) {
    $controller = $urls[$pagina];
    $controller = explode('.', $controller);
    require_once($web.'/source/Controllers/'.$controller[0].'.php');
    $controller[0] = new $controller[0];
    $controller[0]->{$controller[1]}();
} else {
    require_once('404.php');
}