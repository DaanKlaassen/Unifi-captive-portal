<?php

namespace App\Controllers;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
;

use PHPMailer\PHPMailer\PHPMailer;
use App\Models\MailModel;
use App\Config\AppConfig;

class MailController
{
    protected PHPMailer $mailer;
    protected MailModel $mailModel;
    private AppConfig $config;

    public function __construct(AppConfig $config)
    {
        $this->config = $config; // Store the AppConfig instance
        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config->getMailConfig()['HOST'];
        $this->mailer->SMTPAuth = $this->config->getMailConfig()['SMTPAUTH'];
        $this->mailer->Username = $this->config->getMailConfig()['USERNAME'];
        $this->mailer->Password = $this->config->getMailConfig()['PASSWORD'];
        $this->mailer->SMTPSecure = $this->config->getMailConfig()['SMTPSECURE'];
        $this->mailer->Port = $this->config->getMailConfig()['PORT'];

        // Recipients
        $this->mailer->setFrom($this->config->getMailConfig()['HOSTMAILADDRESS'], $this->config->getMailConfig()['HOSTMAILNAME']);

        $this->mailModel = new MailModel($this->mailer);
    }

    public function sendMail($to, $subject, $body)
    {
        return $this->mailModel->send($to, $subject, $body);
    }

    public function resend()
    {
        return $this->mailModel->send($_SESSION['email'], "Your verification code", "Your code is: {$_SESSION['verification_code']}");
    }
}
