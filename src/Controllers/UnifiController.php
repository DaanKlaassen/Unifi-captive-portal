<?php

namespace App\Controllers;

use UniFi_API\Client;

require_once __DIR__ . '/../../config/Config.php';

class UnifiController
{
    private $unifiClient;
    private $loggedInClient;
    private $currentUser;

    public function __construct($config)
    {
        $unifiConfig = $config['unifiConfig'];
        $this->unifiClient = new Client($unifiConfig['CONTROLLER_USER'], $unifiConfig['CONTROLLER_PASSWORD'], $unifiConfig['CONTROLLER_URL'], $unifiConfig['SITE_ID']);

        $this->loggedInClient = $this->unifiClient->login();

        $this->currentUser = $this->getCurrentUser();
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
        return $this->currentUser->ip;
    }
    public function getUserMac()
    {
        return $this->currentUser->mac;
    }
    public function authenticateUser($macAddress, $duration, $note, $fullname)
    {
        try {
            $auth_result  = $this->unifiClient->authorize_guest($macAddress, $duration);
            $getid_result = $this->unifiClient->stat_client($macAddress);
            $user_id      = $getid_result[0]->_id;
            $note_result  = $this->unifiClient->set_sta_note($user_id, $note);
            $name_result  = $this->unifiClient->set_sta_name($user_id, $fullname);
        } catch (\Throwable $th) {
            return false;
        }
    }
}
