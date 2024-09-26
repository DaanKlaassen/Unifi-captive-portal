<?php

namespace App\Controllers;

class PageController
{
    public function index()
    {
        include __DIR__ . '/../views/Index.php';
    }
    public function verify()
    {
        include __DIR__ . '/../views/Verify.php';
    }
    public function succes()
    {
        include __DIR__ . '/../views/Succes.php';
    }
    public function failed()
    {
        include __DIR__ . '/../views/Failed.php';
    }
    public function limiet()
    {
        include __DIR__ . '/../views/Limiet.php';
    }
}
