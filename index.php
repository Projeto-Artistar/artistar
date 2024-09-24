<?php
ini_set('display_errors', 1);

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

session_start();

$router = new Router(ROOT);

$router->group(null)->namespace("Source\Controllers");
$router->get("/", "homeController:home", "homeController.home");
$router->get("/login", "homeController:login", "homeController.login");
$router->get("/logout", "homeController:logout", "homeController.logout");





$router->group('register')->namespace("Source\Controllers");
$router->get("/", "registerController:home", "registerController.home");
$router->get("/validate-email", "registerController:validate", "registerController.validate");




$router->group('password-reset')->namespace("Source\Controllers");
$router->get("/", "resetController:home", "resetController.home");
$router->get("/code", "resetController:code", "resetController.code");
$router->get("/new-password", "resetController:newPassword", "resetController.newPassword");

$router->group('legal')->namespace("Source\Controllers");
$router->get("/terms", "legalController:terms", "legalController.terms");
$router->get("/privacy", "legalController:privacy", "legalController.privacy");





$router->group('apis')->namespace("Source\Controllers");
$router->get("/eventos", "apiController:eventos", "apiController.eventos");





$router->group("error");
$router->get("/404", "errorController:error404", "errorController.error404");


$router->dispatch();

if($router->error())
    header("location: /error/".$router->error());




