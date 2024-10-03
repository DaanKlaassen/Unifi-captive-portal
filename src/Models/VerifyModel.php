<?php

namespace App\Models;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
;

class VerifyModel
{
    public function verifyCode($inputCodeArray)
    {

            $inputCode = strtoupper(implode('', $inputCodeArray));
            $sessionVerifyCode = strtoupper($_SESSION['verification_code']);

            echo $inputCode . "<br>";
            echo $sessionVerifyCode . "<br>";

            if ($inputCode === $sessionVerifyCode) {
                // Verification successful, redirect to submit form
                $_SESSION['verified'] = true;
                return true;
            } else {
                return false;
            }
    }

    public function generateCode()
    {
        // Generate a random verification code (6 characters: numbers and uppercase letters)
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $verificationCode = '';
        for ($i = 0; $i < 6; $i++) {
            $verificationCode .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $verificationCode;
    }

    public function checkRole($role, $email)
    {
        // Construct the full email
        if ($role === 'student') {
            return "{$email}@student.gildeopleidingen.nl";
        } elseif ($role === 'teacher') {
            return "{$email}@rocgilde.nl";
        } else {
            echo "Invalid domain selected";
            return;
        }
    }
}