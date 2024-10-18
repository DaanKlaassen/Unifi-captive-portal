<?php

namespace App\Models;

use App\Entity\User;
use App\Entity\Role;

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

    public function createUser($data)
    {
        $role = $this->entityManager->getRepository(Role::class)->findOneBy(['role' => strtolower($data['role'])]);

        try {
            $user = new User();
            $user->setName($data['fullname']);
            $user->setEmail($data['email']);
            $user->setRole($role);
            $user->setMaxDevices($data['maxDevices']);
            $user->setAcceptedTOU(false);
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return ['status' => 'success', 'message' => 'User created successfully.'];
        } catch (\Exception $e) {
            if($e->getCode() == 19) {
                return ['status' => 'error', 'message' => 'User already exists'];
            } else {
                return ['status' => 'error', 'message' => 'User could not be created.' . $e->getMessage()];
            }
        }
    }

    public function updateUser($data)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $data['userId']]);
        if ($user) {
            $role = $this->entityManager->getRepository(Role::class)->findOneBy(['role' => strtolower($data['role'])]);
            $user->setEmail($data['email']);
            $user->setName($data['name']);
            $user->setRole($role);
            $user->setMaxDevices($data['maxDevices']);
            $user->setUpdatedAt(new \DateTime());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return ['status' => 'success', 'message' => 'User updated successfully.'];
        }
        return ['status' => 'error', 'message' => 'User not found or could not be updated.'];
    }
}

?>