<?php

namespace App\Controllers;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
;

use App\Models\FormModel;
use Doctrine\ORM\EntityManagerInterface;
use App\Config\AppConfig;

require_once __DIR__ . '/../../bootstrap.php';

class FormController
{
    private $model;
    private $unifiController;
    private AppConfig $appConfig;
    private $rootURL;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->appConfig = new AppConfig();
        $this->model = new FormModel($entityManager);
        $this->unifiController = new UnifiController($this->appConfig);
        $this->rootURL = $this->appConfig->getRootURL();
    }

    public function handleFormSubmission()
    {
        if (isset($_SESSION['verified']) && $_SESSION['verified'] === true) {
            // Retrieve data from the session
            $fullEmail = $_SESSION['email'];
            $domain = $_SESSION['form_data']['domain'];
            $ipAddress = $this->unifiController->getUserIp();

            if (filter_var($fullEmail, FILTER_VALIDATE_EMAIL)) {
                // Retrieve the MAC address using the IP address
                $macAddress = $this->unifiController->getUserMac();

                try {
                    $this->model->insertEmail($fullEmail, $domain, $macAddress, $ipAddress);
                    header("Location: {$this->rootURL}/success");
                    $this->unifiController->authenticateUser($macAddress, 2000, $fullEmail, $_SESSION['fullname']);
                    exit();
                } catch (\Exception $e) {
                    header("Location: {$this->rootURL}/failed");
                    exit();
                }
            } else {
                echo "Invalid email format";
            }

            // Unset the verified session variable
            unset($_SESSION['verified']);
        } else {
            echo "Unauthorized access";
        }
    }
}
