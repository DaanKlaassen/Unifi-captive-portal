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

    public function delete($route, $controller, $method)
    {
        $this->routes['DELETE'][$route] = [$controller, $method];
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

        // Path to the public directory where your static files are located
        $publicDir = __DIR__ . '/../../public';

        // Check if the requested route corresponds to a file
        $filePath = $publicDir . $requestedRoute;

        if (file_exists($filePath) && !is_dir($filePath)) {
            // Serve the static file
            return $this->serveStaticFile($filePath);
        }

        // Continue with routing to controllers
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

    // Function to serve static files
    protected function serveStaticFile($filePath)
    {
        // Get the file's MIME type
        $mimeType = mime_content_type($filePath);
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: max-age=3600');
        readfile($filePath);
        exit;
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
