<?php

namespace App\Config;

use Dotenv\Dotenv;

class AppConfig
{
    private $dbName;
    private $rootURL;
    private $mailConfig;
    private $unifiConfig;

    public function __construct()
    {
        // Load .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();

        // Initialize configurations
        $this->dbName = $_ENV['DATABASE_NAME'];
        $this->rootURL = $_ENV['ROOT_URL'];
        
        // Mail configuration
        $this->mailConfig = [
            'HOST' => $_ENV['MAIL_HOST'],
            'SMTPAUTH' => $_ENV['MAIL_SMTPAUTH'],
            'USERNAME' => $_ENV['MAIL_USERNAME'],
            'PASSWORD' => $_ENV['MAIL_PASSWORD'],
            'SMTPSECURE' => $_ENV['MAIL_SMTPSECURE'],
            'PORT' => $_ENV['MAIL_PORT'],
            'HOSTMAILNAME' => $_ENV['HOST_MAIL_NAME'],
            'HOSTMAILADDRESS' => $_ENV['HOST_MAIL_ADDRESS'],
        ];

        // Unifi configuration
        $this->unifiConfig = [
            'CONTROLLER_USER' => $_ENV['CONTROLLER_USER'],
            'CONTROLLER_PASSWORD' => $_ENV['CONTROLLER_PASSWORD'],
            'CONTROLLER_URL' => $_ENV['CONTROLLER_URL'],
            'SITE_ID' => $_ENV['SITE_ID'],
        ];
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function getRootURL(): string
    {
        return $this->rootURL;
    }

    public function getMailConfig(): array
    {
        return $this->mailConfig;
    }

    public function getUnifiConfig(): array
    {
        return $this->unifiConfig;
    }
}
