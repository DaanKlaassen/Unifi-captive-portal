<?php
// bootstrap.php

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Uid\Uuid;

require_once "vendor/autoload.php";
require "config/config.php";

if (!Type::hasType('uuid')) {
    Type::addType('uuid', 'Doctrine\DBAL\Types\StringType');
}

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src/Entity'],
    isDevMode: true,
);

echo $dbName;

// configuring the database connection
$connection = DriverManager::getConnection([
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . "/database/$dbName",
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);
return $entityManager;