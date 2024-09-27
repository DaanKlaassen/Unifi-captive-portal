<?php

namespace App\Routes;

use App\Controllers\PageController;
use App\Controllers\FormController;
use App\Controllers\VerifyController;
use App\Routes\Router;

function initializeRouter() {
	$entityManager = require __DIR__ . '/../../Bootstrap.php';
	$config = require __DIR__ . '/../../config/Config.php';

	$router = new Router();
	$router->setDependencies([$entityManager, $config]);

	return $router;
}

$router = initializeRouter();

// Define the route
$router->get('/', PageController::class, 'index');
$router->get('/verify', PageController::class, 'verify');
$router->get('/succes', PageController::class, 'succes');
$router->get('/failed', PageController::class, 'failed');
$router->get('/limiet', PageController::class, 'limiet');
$router->get('/submit-form', FormController::class, 'handleFormSubmission');
$router->post('/resend-code', VerifyController::class, 'resendCode');
$router->post('/process-form', VerifyController::class, 'processFormSubmission');
$router->post('/verify-code', VerifyController::class, 'verifyCode');

// Dispatch the request
$router->dispatch();
