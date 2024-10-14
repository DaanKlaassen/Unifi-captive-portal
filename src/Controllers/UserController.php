<?php

namespace App\Controllers;

use App\Models\UserModel;
use Doctrine\ORM\EntityManager;

class UserController
{

    private $userModel;

    public function __construct(EntityManager $entityManager)
    {
        $this->userModel = new UserModel($entityManager);
    }

    public function users()
    {
        $users = $this->userModel->getUsers();
        header('Content-Type: application/json');
        echo $users;
    }

    public function deleteUser()
    {
        $email = $_GET['id'] ?? null;
        if ($email && $this->userModel->deleteUserByEmail($email)) {
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found or could not be deleted.']);
        }
    }

    public function createUser()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->userModel->createUser($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function bulkDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $input = json_decode(file_get_contents('php://input'), true);

            if (isset($input['emails']) && is_array($input['emails'])) {
                $emails = $input['emails'];

                foreach ($emails as $email) {
                    $this->userModel->deleteUserByEmail($email);
                }
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            }
        }
    }
}
