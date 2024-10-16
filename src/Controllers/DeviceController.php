<?php

namespace App\Controllers;
use App\Entity\UserDevice;

class DeviceController
{
     private $entityManager;

    public function __construct($entityManager)
        {
            $this->entityManager = $entityManager;
        }

    public function deleteDevice()
    {
        $userId = $_GET['userId'] ?? null;
        $deviceId = $_GET['deviceId'] ?? null;

        $deviceRepository = $this->entityManager->getRepository('App\Entity\UserDevice');
        $device = $deviceRepository->findOneBy(['id' => $deviceId, 'user' => $userId]);

        if ($device) {
            $this->entityManager->remove($device);
            $this->entityManager->flush();
            echo json_encode(['success' => 'Device deleted']);
        } else {
            echo json_encode(['error' => 'Device not found']);
        }
    }
}