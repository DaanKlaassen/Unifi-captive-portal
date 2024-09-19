<?php

use App\Controllers\PageController;
use App\Router;

$router = new Router();

// Define the route
$router->get('/', PageController::class, 'index');

// Dispatch the request
$router->dispatch();
