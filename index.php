<?php
ini_set('display_errors', 1);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('default_charset', 'UTF-8');

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

session_start();

$router = new Router(ROOT);

$router->namespace("Source\Controllers");

$router->group(NULL);
$router->get("/", "homeController:home", "homeController.home");
$router->get("/login", "homeController:login", "homeController.login");

$router->group('sales');
$router->get("/", "salesController:home", "salesController.home");



$router->group('stock');
$router->get("/", "stockController:home", "stockController.home");
$router->post("/newProduct", "stockController:newProduct", "stockController.newProduct");
$router->post("/product/alter", "stockController:alterProduct", "stockController.alterProduct");
$router->post("/product/duplicate", "stockController:duplicateProduct", "stockController.duplicateProduct");
$router->post("/product/delete", "stockController:deleteProduct", "stockController.deleteProduct");
$router->get("/product/{productId}", "stockController:productDetails", "stockController.productDetails");

$router->group('auth');
$router->post("/login", "authController:login", "authController.login");
$router->get("/logout", "authController:logout", "authController.logout");
$router->get("/new-password", "authController:newPassword", "authController.newPassword");
$router->post("/change-password", "authController:changePassword", "authController.changePassword");

$router->group('results');
$router->get("/", "searchController:results", "searchController.results");

$router->group('events');
$router->get("/", "eventsController:home", "eventsController.home");
$router->get("/{eventId}", "eventsController:details", "eventsController.details");
$router->get("/{eventId}/{friendlyUrl}", "eventsController:details", "eventsController.details");

$router->group('register');
$router->get("/", "registerController:home", "registerController.home");
$router->post("/", "registerController:insertStore", "registerController.insertStore");
$router->get("/validate-email", "registerController:validate", "registerController.validate");
$router->post("/validate-code", "registerController:validateCode", "registerController.validateCode");

$router->group('password-reset');
$router->get("/", "resetController:home", "resetController.home");
$router->post("/", "resetController:sendEmail", "resetController.sendEmail");
$router->get("/code", "resetController:code", "resetController.code");
$router->post("/code", "resetController:validateCode", "resetController.validateCode");

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




