<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Access environment variables
$dbName = $_ENV['DATABASE_NAME'];

// Mail configuration
$mailConfig = [
    'HOST' => $_ENV['MAIL_HOST'],
    'SMTPAUTH' => $_ENV['MAIL_SMTPAUTH'],
    'USERNAME' => $_ENV['MAIL_USERNAME'],
    'PASSWORD' => $_ENV['MAIL_PASSWORD'],
    'SMTPSECURE' => $_ENV['MAIL_SMTPSECURE'],
    'PORT' => $_ENV['MAIL_PORT'],
    'HOSTMAILNAME' => $_ENV['HOST_MAIL_NAME'],
    'HOSTMAILADDRESS' => $_ENV['HOST_MAIL_ADDRESS'],
];

$unifiConfig = [
    'CONTROLLER_USER' => $_ENV['CONTROLLER_USER'],
    'CONTROLLER_PASSWORD' => $_ENV['CONTROLLER_PASSWORD'],
    'CONTROLLER_URL' => $_ENV['CONTROLLER_URL'],
    'SITE_ID' => $_ENV['SITE_ID'],
];

return [
    'dbName' => $dbName,
    'mailConfig' => $mailConfig,
    'unifiConfig' => $unifiConfig,
];