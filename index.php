<?php
ini_set('display_errors', 1);

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

session_start();

$router = new Router(ROOT);

$router->group(null)->namespace("Source\Controllers");
$router->get("/", "homeController:home", "homeController.home");

$router->group('apis')->namespace("Source\Controllers");
$router->get("/eventos", "apiController:eventos", "apiController.eventos");

$router->group("error");
$router->get("/404", "errorController:error404", "errorController.error404");


$router->dispatch();

if($router->error())
    header("location: /error/".$router->error());




