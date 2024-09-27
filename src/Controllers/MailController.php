<?php

namespace App\Controllers;

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use App\Models\MailModel;

class MailController
{
    protected $mailer;
    protected MailModel $mailModel;

    public function __construct(array $config)
    {
        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = $config['HOST'];
        $this->mailer->SMTPAuth = $config['SMTPAUTH'];
        $this->mailer->Username = $config['USERNAME'];
        $this->mailer->Password = $config['PASSWORD'];
        $this->mailer->SMTPSecure = $config['SMTPSECURE'];
        $this->mailer->Port = $config['PORT'];

        // Recipients
        $this->mailer->setFrom($config['HOSTMAILADDRESS'], $config['HOSTMAILNAME']);

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
