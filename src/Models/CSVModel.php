<?php

namespace App\Models;

use App\Entity\UserDevice;
use App\Entity\Role;
use App\Entity\User;

class CSVModel
{
    private mixed $entityManager;
    private array $csvDataArray = [];

    public function __construct()
    {
        $this->entityManager = require __DIR__ . '/../../bootstrap.php';
    }

    public function exportCSV($data): bool|string
    {
        if (empty($data)) {
            return false;
        } else {
            $decodedData = JSON_DECODE($data);
            if ($decodedData->users === "true") {
                $users = $this->entityManager->getRepository(User::class)->findAll();
                $csv = fopen('php://temp', 'r+');
                fputcsv($csv, ['UUID', 'Name', 'Email', 'CreatedAt', 'UpdatedAt', 'Role', 'Devices', 'MaxDevices', 'AcceptedTOU']);
                foreach ($users as $user) {
                    fputcsv($csv, [$user->getId(), $user->getName(), $user->getEmail(), $user->getCreatedAt(), $user->getUpdatedAt(), $user->getRole()->getId(), count($user->getDevices()), $user->getMaxDevices(), $user->getAcceptedTOU()]);
                }
                rewind($csv);
                $csvData = stream_get_contents($csv);
                fclose($csv);
                $this->csvDataArray['users'][] = $csvData;
            }
            if ($decodedData->userDevices === "true") {
                $devices = $this->entityManager->getRepository(UserDevice::class)->findAll();
                $csv = fopen('php://temp', 'r+');
                fputcsv($csv, ['UUID', 'MAC', 'IP', 'UserID']);
                foreach ($devices as $device) {
                    $user = $device->getUser();
                    $userID = $user->getId();

                    fputcsv($csv, [$device->getId(), $device->getDeviceMac(), $device->getDeviceIp(), $userID]);
                }
                rewind($csv);
                $csvData = stream_get_contents($csv);
                fclose($csv);
                $this->csvDataArray['userDevices'][] = $csvData;
            }
            if ($decodedData->roles === "true") {
                $roles = $this->entityManager->getRepository(Role::class)->findAll();
                $csv = fopen('php://temp', 'r+');
                fputcsv($csv, ['UUID', 'RoleName']);
                foreach ($roles as $role) {
                    fputcsv($csv, [$role->getId(), $role->getRole()]);
                }
                rewind($csv);
                $csvData = stream_get_contents($csv);
                fclose($csv);
                $this->csvDataArray['roles'][] = $csvData;
            }
        }

        if(!empty($this->csvDataArray)) {
            return json_encode($this->csvDataArray);
        }
        return json_encode(['message' => 'No data to export.']);
    }

    public function importCSV($data): bool | string
    {
        if (empty($data)) {
            return false;
        }

        $errorData = [];

        foreach ($data as $item) {
            $item = array_map('trim', $item);
            if (isset($item['email'], $item['maxDevices'], $item['name'])) {
                $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $item['email']]);
                if ($existingUser) {
                    $errorData[] = "User with email " . $item['email'] . " already exists.";
                    continue;
                }

                $user = new User();
                $user->setEmail($item['email']);
                $role = $this->entityManager->getRepository(Role::class)->findOneBy(['role' => strtolower('student')]);
                $user->setRole($role);
                $user->setName($item['name']);
                $user->setAcceptedTOU(false);
                $user->setCreatedAt(new \DateTime());
                $user->setUpdatedAt(new \DateTime());
                $user->setMaxDevices(intval($item['maxDevices']));
                // Set other properties as needed
                $this->entityManager->persist($user);
                $errorData[] = "User with email " . $item['email'] . " added.";
            } else {
                if($item['email'] === "") {
                    continue;
                } else {
                    $errorData[] = "Invalid data for user with email " . $item['email'];
                }
            }
        }

        $this->entityManager->flush();
        if(empty($errorData)) {
            return true;
        }
        return json_encode($errorData);
    }
}