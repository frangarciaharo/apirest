<?php

namespace App\Http\Routing;
use App\Http\Request;

class Router{
    private RouteCollection $routeCollection;

    function __construct(RouteCollection $routeCollection)
    {
        $this->routeCollection=$routeCollection;
    }
    function dispatch(Request $request){
        $routes=$this->routeCollection->getRoutes();
        foreach ($routes as $route){
            if($route['method']===strtoupper($request->getMethod()) && $this->matchUri($route['path'], $request->getUri(), $params)){
                [$controllerClass, $action]=$route['handler'];
                $controller = new $controllerClass($request);
                call_user_func_array([$controller, $action], $params);
            }
        }
    }
    private function matchUri(string $routepath, string $requestUri, &$params):bool{
        $pattern = preg_replace('#\{{\w+}\}#', '(?P<$1>[^/+])',$routepath);
        $pattern = "#^".$pattern."$#";
        if(preg_match($pattern, $requestUri, $matches)){
            $params = array_filter($matches, fn($key)=>is_string($key), ARRAY_FILTER_USE_KEY);
            return true;
        }
        return false;
    }
}