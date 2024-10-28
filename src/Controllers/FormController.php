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
    private FormModel $model;
    private UnifiController $unifiController;
    private AppConfig $appConfig;
    private string $rootURL;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->appConfig = new AppConfig();
        $this->model = new FormModel($entityManager);
        $this->unifiController = new UnifiController($this->appConfig);
        $this->rootURL = $this->appConfig->getRootURL();
    }

    public function handleFormSubmission(): void
    {
        if (isset($_SESSION['verified']) && $_SESSION['verified'] === true) {
            // Retrieve data from the session
            $fullEmail = $_SESSION['email'];
            $domain = $_SESSION['form_data']['domain'];
            $ipAddress = $this->unifiController->getUserIp();

            if (filter_var($fullEmail, FILTER_VALIDATE_EMAIL)) {
                // Retrieve the MAC address using the IP address
                $macAddress = $this->unifiController->getUserMac();

                if(!$macAddress) {
                    echo "MAC address not found";
                    exit();
                }

                try {
                    $response = $this->model->insertEmail($fullEmail, $domain, $macAddress, $ipAddress);

                    if($response === true) {
                        $this->unifiController->authenticateUser($macAddress, 2000, $fullEmail, $_SESSION['fullname']);
                        header("Location: {$this->rootURL}/success");
                    }

                    exit();
                } catch (\Exception $e) {
                    echo $e->getMessage();
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
