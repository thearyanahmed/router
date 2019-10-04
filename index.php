<?php

require __DIR__ . '/vendor/autoload.php';

use Prophecy\Router\Request;
use Prophecy\Router\Router;

$router = new Router(new Request);

$router->get('/', function() {
    return json_encode('hello world');
});

$router->get('/hello','UserController::index');

$router->get('/banana',function() {
    return json_encode('banana');
});