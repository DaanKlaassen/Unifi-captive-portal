<?php

namespace App\Routes;

class Router
{
    protected $routes = [];
    protected $dependencies = [];

    // Define a route
    public function get($route, $controller, $method)
    {
        $this->routes['GET'][$route] = [$controller, $method];
    }

    public function post($route, $controller, $method)
    {
        $this->routes['POST'][$route] = [$controller, $method];
    }

    // Set dependencies for the router
    public function setDependencies(array $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    // Dispatch the request to the correct controller and method
    public function dispatch()
    {
        $requestedRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$requestedRoute])) {
            $action = $this->routes[$method][$requestedRoute];

            if (is_array($action) && isset($action[0], $action[1])) {
                $controller = $action[0];
                $method = $action[1];

                if (class_exists($controller) && method_exists($controller, $method)) {
                    $controllerInstance = $this->createControllerInstance($controller);
                    $controllerInstance->$method();
                } else {
                    echo 'Controller or method not found';
                }
            }
        } else {
            echo '404 Not Found';
        }
    }

    // Create controller instance with or without dependencies
    protected function createControllerInstance($controller)
    {
        $reflection = new \ReflectionClass($controller);
        $constructor = $reflection->getConstructor();

        if ($constructor && $constructor->getNumberOfParameters() > 0) {
            return $reflection->newInstanceArgs($this->dependencies);
        }

        return new $controller();
    }
}
?>