<?php

namespace App\Models;

class UnifiModel
{
    private $unifiClient;

    public function __construct($unifiClient)
    {
        $this->unifiClient = $unifiClient;
    }

    public function authenticateUser($macAddress, $duration, $note, $fullname)
    {
        try {
            $auth_result  = $this->unifiClient->authorize_guest($macAddress, $duration);
            $getid_result = $this->unifiClient->stat_client($macAddress);
            $user_id      = $getid_result[0]->_id;
            $this->unifiClient->set_sta_note($user_id, $note);
            $this->unifiClient->set_sta_name($user_id, $fullname);

            return $auth_result;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function get_hourly_users()
    {
        return $this->unifiClient->stat_hourly_user();
    }

    public function get_all_users()
    {
        return $this->unifiClient->list_clients();
    }
}
