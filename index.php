<?php
ini_set('display_errors', 1);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('default_charset', 'UTF-8');
setlocale(LC_TIME, 'pt_BR.UTF-8');

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

session_start();

$router = new Router(ROOT);

$router->namespace("Source\Controllers");

$router->group(NULL);
$router->get("/", "homeController:home", "homeController.home");
$router->get("/login", "homeController:login", "homeController.login");
// $router->get("/{userFriendlyUrl}", "publicProfileController:profile", "publicProfileController.profile");

$router->group('register');
$router->get("/", "registerController:home", "registerController.home");
$router->post("/", "registerController:insertStore", "registerController.insertStore");
$router->post("/validate-user", "registerController:validateUser", "registerController.validateUser");
$router->post("/validate-email", "registerController:validateEmail", "registerController.validateEmail");
$router->get("/validate-email", "registerController:validate", "registerController.validate");
$router->post("/validate-code", "registerController:validateCode", "registerController.validateCode");

$router->group('auth');
$router->post("/login", "authController:login", "authController.login");
$router->get("/logout", "authController:logout", "authController.logout");
$router->get("/new-password", "authController:newPassword", "authController.newPassword");
$router->post("/change-password", "authController:changePassword", "authController.changePassword");
$router->post("/resend-code", "authController:resendCode", "authController.resendCode");

$router->group('password-reset');
$router->get("/", "resetController:home", "resetController.home");
$router->post("/", "resetController:sendEmail", "resetController.sendEmail");
$router->get("/code", "resetController:code", "resetController.code");
$router->post("/code", "resetController:validateCode", "resetController.validateCode");

$router->group('sales');
$router->get("/", "salesController:home", "salesController.home");
$router->post("/insert", "salesController:insert", "salesController.insert");

$router->group('stock');
$router->get("/", "stockController:home", "stockController.home");
$router->post("/newProduct", "stockController:newProduct", "stockController.newProduct");
$router->post("/product/alter", "stockController:alterProduct", "stockController.alterProduct");
$router->post("/product/duplicate", "stockController:duplicateProduct", "stockController.duplicateProduct");
$router->post("/product/delete", "stockController:deleteProduct", "stockController.deleteProduct");
$router->get("/product/{productId}", "stockController:productDetails", "stockController.productDetails");

$router->group('sales-statement');
$router->get("/", "salesStatementController:home", "salesStatementController.home");
$router->post("/sale/edit", "salesStatementController:editSale", "salesStatementController.editSale");
$router->get("/sale/{saleId}", "salesStatementController:saleDetails", "salesStatementController.saleDetails");

$router->group('statistics');
$router->get("/", "statisticsController:home", "statisticsController.home");
$router->post("/edit-graph", "statisticsController:editGraph", "statisticsController.editGraph");

$router->group('admin');
$router->get("/", "adminController:home", "adminController.home");
$router->get("/users", "adminController:users", "adminController.users");
$router->get("/stores", "adminController:stores", "adminController.stores");
$router->get("/products", "adminController:products", "adminController.products");
$router->get("/sales", "adminController:sales", "adminController.sales");
$router->get("/graphs", "adminController:graphs", "adminController.graphs");

$router->group('results');
$router->get("/", "searchController:results", "searchController.results");

$router->group('events');
$router->get("/", "eventsController:home", "eventsController.home"); // Tela de pesquisa/listagem
$router->get("/{friendlyUrl}", "eventsController:details", "eventsController.details"); // Tela de detalhes do evento com URL amigável
$router->get("/id/{eventId}", "eventsController:details", "eventsController.details"); // Tela de detalhes do evento por ID (Para eventos privados ou sem URL amigável)
$router->post("/subscribe", "eventsController:subscribe", "eventsController.subscribe");
$router->post("/unsubscribe", "eventsController:unsubscribe", "eventsController.unsubscribe");
$router->get("/my-events", "eventsController:myEvents", "eventsController.myEvents"); // Meus Eventos
$router->get("/create", "eventsController:create", "eventsController.create"); // Criação de novo evento
$router->post("/create", "eventsController:insert", "eventsController.insert"); // Armazenamento de novo evento
$router->get("/edit/{eventId}", "eventsController:edit", "eventsController.edit");
$router->post("/edit", "eventsController:update", "eventsController.update"); // Edição do evento
$router->post("/delete", "eventsController:delete", "eventsController.delete");

$router->group('legal');
$router->get("/terms", "legalController:terms", "legalController.terms");
$router->get("/privacy", "legalController:privacy");

$router->group('apis');
$router->post("/events", "apiController:events", "apiController.events");
$router->post("/events/details", "apiController:eventDetails", "apiController.eventDetails");
$router->post("/events/favorite", "apiController:eventFavorite", "apiController.eventFavorite");
$router->post("/states", "apiController:states", "apiController.states");
$router->post("/cities", "apiController:cities", "apiController.cities");


$router->group("error");
$router->get("/404", "errorController:error404", "errorController.error404");
$router->get("/400", "errorController:error400", "errorController.error400");


$router->dispatch();

if($router->error()){
    header("location: /error/".$router->error());
}




