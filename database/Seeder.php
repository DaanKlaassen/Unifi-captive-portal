<?php

require_once 'Bootstrap.php';  // Adjust the path if necessary

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

// Retrieve the entity manager from the bootstrap file
$entityManager = require 'Bootstrap.php';

$data = [
    'name' => 'Daan Klaassen',
    'email' => 'daan.klaassen@student.gildeopleidingen.nl',
    'devices' => 2,
    'role' => 'admin',
    'mac' => '11:11:11:11:11:11',
    'ipAddress' => '192.168.1.170',
    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'),
    'updatedAt' => (new \DateTime())->format('Y-m-d H:i:s')
];

$jsonData = json_encode($data);
$dataObject = json_decode($jsonData, false); // Decoding to object

// Create new User entity instance with test data
$user = new User();
$user->setName($dataObject->name);
$user->setEmail($dataObject->email);
$user->setDevices($dataObject->devices);
$user->setRole($dataObject->role);  // Ensure the role is 16 characters or less
$user->setMac($dataObject->mac); // MAC address example
$user->setIpAddress($dataObject->ipAddress);

// Convert string dates to DateTime objects
$user->setCreatedAt(new \DateTime($dataObject->createdAt));
$user->setUpdatedAt(new \DateTime($dataObject->updatedAt));

// Persist the User entity
$entityManager->persist($user);
$entityManager->flush();

echo "Test data inserted successfully.\n";