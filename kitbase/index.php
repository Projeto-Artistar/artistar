<?php


require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

session_start();

$router = new Router(ROOT);

$router->group(null)->namespace("Source\Controllers");
$router->get("/", "homeController:home", "homeController.home");

$router->group("error");
//$router->get("/{errcode}", function($data){
//    echo "<h1> Ops, algo deu errado :/ </h1>";
//});

$router->get("/{errcode}", function($data){
    header("location: /samples/error-404");
});


$router->dispatch();

if($router->error()){
    $router->redirect("/error/{$router->error()}");
}



