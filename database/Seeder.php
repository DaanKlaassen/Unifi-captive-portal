<?php

namespace App\Database;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserDevice;
use Doctrine\ORM\EntityManagerInterface;

require_once 'bootstrap.php';

// Retrieve the entity manager from the bootstrap file
$entityManager = require 'bootstrap.php';

// Function to seed roles
function seedRoles(EntityManagerInterface $entityManager, array $roles) {
    foreach ($roles as $roleName) {
        $role = $entityManager->getRepository(Role::class)->findOneBy(['role' => $roleName]);
        if (!$role) {
            $role = new Role();
            $role->setRole($roleName);
            $entityManager->persist($role);
            echo "Inserted role: $roleName\n"; // Debug message
        }
    }
}

// Seed roles
seedRoles($entityManager, ['admin', 'teacher', 'student']);

$entityManager->flush();
sleep(1);

// Seed users
$userData = [
    [
        'name' => 'Daan Klaassen',
        'email' => 'daan.klaassen@student.gildeopleidingen.nl',
        'devices' => 2,
        'maxDevices' => 2,
        'role' => 'admin',
        'acceptedTOU' => true
    ],
];

// Iterate through user data
foreach ($userData as $data) {
    $user = new User();
    $user->setName($data['name']);
    $user->setEmail($data['email']);
    $user->setMaxDevices($data['maxDevices']);
    
    // Add devices
    for ($i = 0; $i < $data['devices']; $i++) {
        $device = new UserDevice();
        $device->setDeviceMac('11:11:11:11:11:1' . $i);
        $device->setDeviceIp('192.168.1.' . (170 + $i));
        $user->addDevice($device);
    }
    
    // Find the role entity (ensure the role name matches exactly)
    $role = $entityManager->getRepository(Role::class)->findOneBy(['role' => strtolower($data['role'])]);
    if ($role) {
        $user->setRole($role);
        echo "Assigned role: " . $role->getRole() . " to user: " . $data['name'] . "\n"; // Debug message
    } else {
        echo "Role not found for user: " . $data['name'] . "\n";
        continue;
    }

    $user->setCreatedAt(new \DateTime());
    $user->setUpdatedAt(new \DateTime());
    $user->setAcceptedTOU($data['acceptedTOU']);
    
    // Persist the User entity
    $entityManager->persist($user);
}

// Flush roles and users to the database
try {
    $entityManager->flush();
    echo "Roles and users seeded successfully.\n";
} catch (\Exception $e) {
    echo "Error flushing roles and users: " . $e->getMessage() . "\n";
}
