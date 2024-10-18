<?php

namespace App\Controllers;

use UniFi_API\Client;

use App\Config\AppConfig;

use App\Models\UnifiModel;

class UnifiController
{
    private $unifiClient;
    private $loggedInClient;
    private $currentUser;
    private AppConfig $config;
    private UnifiModel $unifiModel;

    public function __construct(AppConfig $config)
    {
        $this->config = $config;
        $unifiConfig = $this->config->getUnifiConfig();
        $this->unifiClient = new Client($unifiConfig['CONTROLLER_USER'], $unifiConfig['CONTROLLER_PASSWORD'], $unifiConfig['CONTROLLER_URL'], $unifiConfig['SITE_ID']);

        $this->loggedInClient = $this->unifiClient->login();

        echo $this->loggedInClient;

        $this->currentUser = $this->getCurrentUser();

        $this->unifiModel = new UnifiModel($this->unifiClient);
    }

    private function getCurrentUser()
    {
        if ($this->loggedInClient) {
            $user_ip = $_SERVER['REMOTE_ADDR'];

            // Get the list of connected clients
            $clients = $this->unifiClient->list_clients();

            // Find the current user based on IP address
            $session_user = null;
            foreach ($clients as $client) {
                if ($client->ip == $user_ip) {
                    $session_user = $client;
                    break;
                }
            }
            return $session_user;
        }
    }
    public function getUserIp()
    {
        echo $this->currentUser->ip;
        return $this->currentUser->ip;
    }
    public function getUserMac()
    {
        echo $this->currentUser->mac;
        return $this->currentUser->mac;
    }

    public function authenticateUser($macAddress, $duration, $note, $fullname)
    {
        $response = $this->unifiModel->authenticateUser($macAddress, $duration, $note, $fullname);
        if ($response) {
            echo json_encode(['status' => 'success', 'message' => 'User authenticated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User could not be authenticated.']);
        }
    }

    public function stat_hourly_user()
    {
        $hourly_users = $this->unifiModel->get_hourly_users();
        echo json_encode($hourly_users);
    }

    public function get_all_users()
    {
        $all_users = $this->unifiModel->get_all_users();
        echo json_encode($all_users);
    }

}
