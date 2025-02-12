<?php
ini_set('display_errors', 1);

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

session_start();

$router = new Router(ROOT);

$router->namespace("Source\Controllers");

$router->group(NULL);
$router->get("/", "homeController:home", "homeController.home");
$router->get("/login", "homeController:login", "homeController.login");


$router->group('begin');
$router->get("/", "beginController:home", "beginController.home");

$router->group('auth');
$router->post("/login", "authController:login", "authController.login");
$router->get("/logout", "authController:logout", "authController.logout");

$router->group('results');
$router->get("/", "searchController:results", "searchController.results");

$router->group('events');
$router->get("/", "eventsController:home", "eventsController.home");
$router->get("/{eventId}", "eventsController:details", "eventsController.details");
$router->get("/{eventId}/{friendlyUrl}", "eventsController:details", "eventsController.details");

$router->group('register');
$router->get("/", "registerController:home", "registerController.home");
$router->get("/validate-email", "registerController:validate", "registerController.validate");

$router->group('password-reset');
$router->get("/", "resetController:home", "resetController.home");
$router->get("/code", "resetController:code", "resetController.code");
$router->get("/new-password", "resetController:newPassword", "resetController.newPassword");

$router->group('legal');
$router->get("/terms", "legalController:terms", "legalController.terms");
$router->get("/privacy", "legalController:privacy");

$router->group('apis');
$router->post("/events", "apiController:events", "apiController.events");
$router->post("/events/details", "apiController:eventDetails", "apiController.eventDetails");
$router->post("/events/favorite", "apiController:eventFavorite", "apiController.eventFavorite");
$router->post("/cities", "apiController:cities", "apiController.cities");


$router->group("error");
$router->get("/404", "errorController:error404", "errorController.error404");


$router->dispatch();

if($router->error())
    header("location: /error/".$router->error());




