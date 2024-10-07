<?php

namespace App\Models;

class ClearSession
{
    public function clearSession()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}