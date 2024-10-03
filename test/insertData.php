<?php

require_once 'bootstrap.php';

use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserDevice;

// Retrieve the entity manager from the bootstrap file
$entityManager = require 'bootstrap.php';

$data = [
    'name' => 'Gé leurs',
    'email' => 'Gé.leurs@student.gildeopleidingen.nl',
    'devices' => 1,
    'role' => 'teacher',
    'acceptedTOU' => true,
];

// Create new User entity instance with test data
$user = new User();
$user->setName($data['name']);
$user->setEmail($data['email']);

// Add devices
for ($i = 0; $i < $data['devices']; $i++) {
    $device = new userDevice();
    $device->setDeviceMac('BI:TC:HL:ES:SN:' . str_pad($i, 2, '0', STR_PAD_LEFT));
    $device->setDeviceIp('192.168.1.' . (69 + $i));

    $user->addDevice($device);
}

// Find the role entity
$role = $entityManager->getRepository(Role::class)->findOneBy(['role' => $data['role']]);
if ($role) {
    $user->setRole($role);
} else {
    echo "Role '{$data['role']}' not found.\n";
    exit;
}

$user->setCreatedAt(new \DateTime());
$user->setUpdatedAt(new \DateTime());
$user->setAcceptedTOU($data['acceptedTOU']);

// Persist the User entity
$entityManager->persist($user);

// Flush users to database
try {
    $entityManager->flush();
    echo "Test data inserted successfully.\n";
} catch (\Exception $e) {
    echo "Error flushing user: " . $e->getMessage() . "\n";
}
