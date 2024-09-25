<?php

namespace App\Routes;

use App\Controllers\PageController;
use App\Controllers\FormController;
use App\Routes\Router;

$entityManager = require __DIR__ . '/../../Bootstrap.php';

$router = new Router();

$router->setDependencies([$entityManager]);

// Define the route
$router->get('/', PageController::class, 'index');
$router->post('/submit-form', FormController::class, 'handleFormSubmission');

// Dispatch the request
$router->dispatch();
?>