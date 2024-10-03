<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../vendor/autoload.php';
use App\Routes\RouteManager;

// Include the routes configuration file
$routeManager = new RouteManager();
$routeManager->dispatch();
