<?php

namespace App\Models;

session_start();


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\User_Device;

class FormModel {
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function insertEmail($email, $domain, $macAddress, $ipAddress) {
        $name = explode('@', $email)[0];
        $fullname = implode(' ', explode('.', $name));
        $_SESSION['fullname'] = $fullname;

        switch($domain) {
            case 'student':
                $maxDevices = 1;
                break;
            case 'teacher':
                $maxDevices = 3;
                break;
            default:
                $maxDevices = 0;
        }

        // Create a new User entity
        $user = new User();
        $user->setName($fullname);
        $user->setEmail($email);
        $user->setMaxDevices($maxDevices);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());
        $user->setAcceptedTOU(true);

        // Assign a role to the user
        $role = $this->entityManager->getRepository(Role::class)->findOneBy(['role' => $domain]);
        if ($role) {
            $user->setRole($role);
        } else {
            throw new \Exception("Role not found");
        }

        // Create a new User_Device entity
        $device = new User_Device();
        $device->setDeviceMac($macAddress);
        $device->setDeviceIp($ipAddress);
        $user->addDevice($device);

        // Persist the user entity
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }
}
?>