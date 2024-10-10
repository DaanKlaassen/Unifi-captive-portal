<?php

namespace App\Models;

use App\Entity\User;

class UserModel
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUsers(): bool|string
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $roleMapping = [
            1 => 'admin',
            2 => 'teacher',
            3 => 'student'
        ];
        $userArray = array_map(function ($user) use ($roleMapping) {
            return [
                'UUID' => $user->getId(),
                'Email' => $user->getEmail(),
                'Name' => $user->getName(),
                'CreatedAt' => $user->getCreatedAt(),
                'UpdatedAt' => $user->getUpdatedAt(),
                'role' => $roleMapping[$user->getRole()->getId()] ?? 'unknown',
                'devices' => array_map(function ($device) {
                    return [
                        'id' => $device->getId(),
                        'mac' => $device->getDeviceMac(),
                        'ip' => $device->getDeviceIp()
                    ];
                }, $user->getDevices()->toArray()),
                'maxDevices' => $user->getMaxDevices(),
                'acceptedTOU' => $user->getAcceptedTOU()
            ];
        }, $users);
        return json_encode($userArray);
    }

    public function deleteUserByEmail($email)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}

?>