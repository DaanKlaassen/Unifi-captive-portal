<?php

namespace App\Controllers;

session_start();

use App\Models\FormModel;
use Doctrine\ORM\EntityManagerInterface;

require_once __DIR__ . '/../../bootstrap.php';

class FormController
{
    private $model;
    private $unifiController;

    public function __construct(EntityManagerInterface $entityManager, $config)
    {
        $this->model = new FormModel($entityManager);
        $this->unifiController = new UnifiController($config);
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
                    header("Location: /succes");
                    $this->unifiController->authenticateUser($macAddress, 2000, $fullEmail, $_SESSION['fullname']);
                    exit();
                } catch (\Exception $e) {
                    header("Location: /failed");
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
