<?php

namespace App\Routes;

use App\Controllers\PageController;
use App\Controllers\FormController;
use App\Controllers\VerifyController;
use App\Routes\Router;
use App\Config\AppConfig;

class RouteManager
{
    private $router;
    private $appConfig;
    private $entityManager;
    private $rootURL;

    public function __construct()
    {
        $this->entityManager = require __DIR__ . '/../../bootstrap.php';
        $this->router = new Router();
        $this->appConfig = new AppConfig();
        $this->rootURL = $this->appConfig->getRootURL();
        $this->router->setDependencies([$this->entityManager]);

        $this->initializeRoutes();
    }

    private function initializeRoutes()
    {
        // Define the routes
        $this->router->get("{$this->rootURL}/", PageController::class, 'index');
        $this->router->get("{$this->rootURL}/verify", PageController::class, 'verify');
        $this->router->get("{$this->rootURL}/succes", PageController::class, 'succes');
        $this->router->get("{$this->rootURL}/failed", PageController::class, 'failed');
        $this->router->get("{$this->rootURL}/limiet", PageController::class, 'limiet');
        $this->router->get("{$this->rootURL}/submit-form", FormController::class, 'handleFormSubmission');
        $this->router->post("{$this->rootURL}/resend-code", VerifyController::class, 'resendCode');
        $this->router->post("{$this->rootURL}/process-form", VerifyController::class, 'processFormSubmission');
        $this->router->post("{$this->rootURL}/verify-code", VerifyController::class, 'verifyCode');
    }

    public function dispatch()
    {
        // Dispatch the request
        $this->router->dispatch();
    }
}
