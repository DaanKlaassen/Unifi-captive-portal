<?php

namespace App\Models;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
};


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\UserDevice;

class FormModel
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function insertEmail($email, $domain, $macAddress, $ipAddress): bool
    {
        try {

            $name = explode('@', $email)[0];
            $fullname = implode(' ', explode('.', $name));
            $_SESSION['fullname'] = $fullname;

            $maxDevices = match ($domain) {
                'student' => 1,
                'teacher' => 3,
                default => 0,
            };

            // Find the existing User entity by email
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            if (!$user) {
                throw new \Exception("User not found");
            }
            $user->setName($fullname);
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

            // Create a new UserDevice entity
            $device = new UserDevice();
            $device->setDeviceMac($macAddress);
            $device->setDeviceIp($ipAddress);
            $user->addDevice($device);

            // Persist the user entity
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
            exit();
        }
    }
}