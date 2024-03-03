<?php 

namespace Src\Routes;
use Src\Controller\HomeController;
use Src\Controller\SubscribeController;
$router = new Router();

$router->addRoute('GET', '/', function() {
    $controller = new HomeController();
    $controller->index();
});

$router->addRoute('POST', '/subscribe', function() {
    $controller = new SubscribeController();
    $controller->subscribe();
});
$router->addRoute('GET', '/successful', function() {
    $controller = new SubscribeController();
    $controller->successful();
});


$router->matchRoute();