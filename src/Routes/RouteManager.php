<?php

namespace App\Routes;

use App\Controllers\CSVController;
use App\Controllers\PageController;
use App\Controllers\FormController;
use App\Controllers\VerifyController;
use App\Controllers\UserController;
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
        $this->router->get("{$this->rootURL}/success", PageController::class, 'success');
        $this->router->get("{$this->rootURL}/failed", PageController::class, 'failed');
        $this->router->get("{$this->rootURL}/limiet", PageController::class, 'limiet');
        $this->router->get("{$this->rootURL}/admin", PageController::class, 'admin');
        $this->router->get("{$this->rootURL}/admin/export", PageController::class, 'export');
        $this->router->get("{$this->rootURL}/admin/import", PageController::class, 'import');
        $this->router->get("{$this->rootURL}/admin/users", PageController::class, 'users');
        $this->router->get("{$this->rootURL}/submit-form", FormController::class, 'handleFormSubmission');
        $this->router->get("{$this->rootURL}/admin/create-user", PageController::class, 'createUser');
        $this->router->get("{$this->rootURL}/users", UserController::class, 'users');
        $this->router->post("{$this->rootURL}/export-csv", CSVController::class, 'exportCSV');
        $this->router->post("{$this->rootURL}/import-csv", CSVController::class, 'importCSV');
        $this->router->post("{$this->rootURL}/create-user", UserController::class, 'createUser');
        $this->router->post("{$this->rootURL}/resend-code", VerifyController::class, 'resendCode');
        $this->router->post("{$this->rootURL}/process-form", VerifyController::class, 'processFormSubmission');
        $this->router->post("{$this->rootURL}/verify-code", VerifyController::class, 'verifyCode');
        $this->router->delete("{$this->rootURL}/delete-user", UserController::class, 'deleteUser');
    }

    public function dispatch()
    {
        // Dispatch the request
        $this->router->dispatch();
    }
}
