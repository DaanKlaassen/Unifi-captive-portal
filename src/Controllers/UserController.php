<?php

namespace App\Controllers;

use App\Models\UserModel;
use Doctrine\ORM\EntityManager;

class UserController {

    private $userModel;

    public function __construct(EntityManager $entityManager) {
        $this->userModel = new UserModel($entityManager);
    }

    public function users() {
        return $this->userModel->getUsers();
    }

}
