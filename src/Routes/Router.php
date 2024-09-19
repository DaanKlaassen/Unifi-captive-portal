<?php

namespace App;

class Router
{
    protected $routes = [];

    // Define a route
    public function get($route, $controller, $method)
    {
        $this->routes['GET'][$route] = [$controller, $method];
    }

    // Dispatch the request to the correct controller and method
    public function dispatch()
    {
        $requestedRoute = '/'; // Change this based on your route structure
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$requestedRoute])) {
            $action = $this->routes[$method][$requestedRoute];

            if (is_array($action) && isset($action[0], $action[1])) {
                $controller = $action[0];
                $method = $action[1];

                if (class_exists($controller) && method_exists($controller, $method)) {
                    $controllerInstance = new $controller();
                    $controllerInstance->$method();
                } else {
                    echo 'Controller or method not found';
                }
            }
        } else {
            echo '404 Not Found';
        }
    }
}
