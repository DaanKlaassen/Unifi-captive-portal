<?php

namespace App\Models;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class CheckMailModel
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function checkMail(string $email): bool
    {
        // Fetch the user by email
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        // Check if the user exists and return true if they have max devices
        if ($user) {
            return count($user->getDevices()) >= $user->getMaxDevices();
        }

        return false; // Email does not exist or no max devices limit reached
    }
}
