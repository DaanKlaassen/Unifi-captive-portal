<?php
namespace App\Controllers;

use App\Models\FormModel;
use Doctrine\ORM\EntityManagerInterface;

require_once __DIR__ . '/../../bootstrap.php';

class FormController {
    private $model;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->model = new FormModel($entityManager);
    }

    public function handleFormSubmission() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $domain = $_POST['domain'];
            $ipAddress = $_POST['ipAddress'];

            // Determine the full email based on the selected domain
            if ($domain === 'student') {
                $fullEmail = $email . '@student.gildeopleidingen.nl';
            } elseif ($domain === 'teacher') {
                $fullEmail = $email . '@rocgilde.nl';
            } else {
                echo "Invalid domain selected";
                return;
            }

            if (filter_var($fullEmail, FILTER_VALIDATE_EMAIL)) {
                // Retrieve the MAC address using the IP address
                $macAddress = $this->getMacAddress($ipAddress);

                try {
                    $this->model->insertEmail($fullEmail, $domain, $macAddress, $ipAddress);
                    echo "New record created successfully";
                } catch (\Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Invalid email format";
            }
        }
    }

    private function getMacAddress($ipAddress) {
        return '00:00:00:00:00:00';
    }
}

// Retrieve the entity manager from the bootstrap file
$entityManager = require '../bootstrap.php';
$controller = new FormController($entityManager);
$controller->handleFormSubmission();
?>