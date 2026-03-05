<?php

require_once __DIR__."/../vendor/autoload.php";
use App\Http\Request;
use App\Http\Routing\RouteCollection;
USE App\Http\Routing\Router;

$request = new Request();
$routes = new RouteCollection(__DIR__.'/../config/routes.php');
$router= new Router($routes);

$router->dispatch($request);