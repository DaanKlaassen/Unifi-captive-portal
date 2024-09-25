<?php

namespace App\Controllers;

session_start();

class VerifyController
{
    public function verifyCode()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputCodeArray = $_POST['verification_code'];
            $inputCode = strtoupper(implode('', $inputCodeArray));
            $sessionVerifyCode = strtoupper($_SESSION['verification_code']);

            echo $inputCode . "<br>";
            echo $sessionVerifyCode . "<br>";

            if ($inputCode === $sessionVerifyCode) {
                // Verification successful, redirect to submit form
                $_SESSION['verified'] = true;
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
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $domain = $_POST['domain'];

            // Construct the full email
            if ($domain === 'student') {
                $fullEmail = $email . '@student.gildeopleidingen.nl';
            } elseif ($domain === 'teacher') {
                $fullEmail = $email . '@rocgilde.nl';
            } else {
                echo "Invalid domain selected";
                return;
            }

            // Generate a random verification code (6 characters: numbers and uppercase letters)
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $verificationCode = '';
            for ($i = 0; $i < 6; $i++) {
                $verificationCode .= $characters[rand(0, strlen($characters) - 1)];
            }

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
