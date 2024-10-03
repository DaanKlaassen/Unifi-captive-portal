<?php
// bootstrap.php

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Uid\Uuid;
use App\Config\AppConfig;

require_once "vendor/autoload.php";
$appConfig = new AppConfig();
$dbName = $appConfig->getDbName();

if (!Type::hasType('uuid')) {
    Type::addType('uuid', 'Doctrine\DBAL\Types\StringType');
}

// Create a simple "default" Doctrine ORM configuration for Attributes
$doctrineConfig = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src/Entity'],
    isDevMode: true,
);

// Configuring the database connection
$connection = DriverManager::getConnection([
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . "/database/{$dbName}",
], $doctrineConfig);

// Obtaining the entity manager
$entityManager = new EntityManager($connection, $doctrineConfig);
return $entityManager;
