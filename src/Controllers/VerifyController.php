<?php

namespace App\Controllers;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
;

use App\Config\AppConfig;
use App\Models\VerifyModel;
use App\Models\CheckMailModel;
use Doctrine\ORM\EntityManagerInterface;
use App\Controllers\MailController;
require_once __DIR__ . '/../../bootstrap.php';

class VerifyController
{
    private $verifyModel;
    private $checkMailModel;
    private $mailController;
    private AppConfig $appConfig;
    private $rootURL;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->appConfig = new AppConfig();
        $this->verifyModel = new VerifyModel();
        $this->checkMailModel = new CheckMailModel($entityManager);
        $this->mailController = new MailController($this->appConfig);
        $this->rootURL = $this->appConfig->getRootURL();
    }

    public function verifyCode()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputCodeArray = $_POST['verification_code'] ?? ''; // Added null coalescing
            $data = $this->verifyModel->verifyCode($inputCodeArray);

            if ($data === true) {
                header("Location: {$this->rootURL}/submit-form");
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

            // Check if the email isn't yet in the database and if the device count is less than put in the database
            $emailExists = $this->checkMailModel->checkMail($fullEmail);
            if ($emailExists) {
                header("Location: {$this->rootURL}/limiet");
                exit();
            }

            $verificationCode = $this->verifyModel->generateCode();
            // Send the verification code to the user's email
            $this->mailController->sendMail($fullEmail, "Your verification code", "Your code is: $verificationCode");

            // Store the verification code and form data in the session
            $_SESSION['verification_code'] = $verificationCode;
            $_SESSION['email'] = $fullEmail;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['verified'] = false;
            $_SESSION['form_submitted'] = true;

            // Redirect to the verify page
            header("Location: {$this->rootURL}/verify");
            exit();
        }
    }
    public function resendCode()
    {
        if ($this->mailController->resend()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
