<?php

namespace App\Controllers;

session_start();

use App\Models\VerifyModel;
use App\Models\CheckMailModel;
use Doctrine\ORM\EntityManagerInterface;

require_once __DIR__ . '/../../bootstrap.php';

class VerifyController
{
    private $verifyModel;
    private $checkMailModel;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->verifyModel = new VerifyModel();
        $this->checkMailModel = new CheckMailModel($entityManager);
    }

    public function verifyCode()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputCodeArray = $_POST['verification_code'];
            $data = $this->verifyModel->verifyCode($inputCodeArray);

            if ($data === true) {
                header('Location: /submit-form');
                exit();
            } else {
                echo "Invalid verification code";
            }
        }
    }
    public function processFormSubmission()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Capture data from the form submission
            $fullEmail = $this->verifyModel->checkRole($_POST['domain'], $_POST['email']);

            // check if the email isnt yet in the database and if the device count is less than put in the database
            $emailExists = $this->checkMailModel->checkMail($fullEmail);
            if ($emailExists) {
                header('Location: /limiet');
                exit();
            }

            $verificationCode = $this->verifyModel->generateCode();

            // Send the verification code to the user's email
            // Uncomment and implement the mail function according to your server setup
            // mail($fullEmail, "Your verification code", "Your code is: $verificationCode");

            // Store the verification code and form data in the session
            $_SESSION['verification_code'] = $verificationCode;
            $_SESSION['email'] = $fullEmail;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['verified'] = false;
            $_SESSION['form_submitted'] = true;

            // Redirect to the verify page
            header('Location: /verify');
            exit();
        }
    }
}
