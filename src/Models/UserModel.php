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

    public function getUsers()
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        return $users;
    }
}
?>